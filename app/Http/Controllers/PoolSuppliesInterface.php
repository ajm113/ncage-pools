<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use App\Products;
use App\ProductThumbs;

use Cart;

class PoolSuppliesInterface extends Controller
{

    public function landing()
    {
        $viewVariables = [
            'products' => $this->fetchProducts()
        ];

        return view('pages.landing', $viewVariables);
    }

    public function product(Request $request, $productId)
    {

        $product = $this->fetchProduct($productId);

        $viewVariables = [
            'product' => $product
        ];

        if(Request::isMethod('post'))
        {
            $quantity = intval($_POST['quantity']);                     // Sanatize our input.
            $quantity = ($quantity < 1 || $quantity > 999) ? 1 : $quantity; // Some simple checking to make sure our quantity is OK.

            Cart::add($product['id'], $product['name'], $quantity, $product['price'], ['size' => 'large']);
        }

        return view('pages.product', $viewVariables);
    }

    protected function fetchProducts($includeCover = true)
    {
        $products =  Products::get()->toArray();

        if($includeCover)
        {
            $productIds = []; // List of ids we need to use for our cover images.

            foreach ($products as $product)
            {
                $productIds[] = $product['id'];
            }

            $covers = $this->fetchProductsThumbs($productIds, true);

            // Now iterate through all the found covers
            // and apply them to the products.
            foreach ($covers as $cover)
            {
                foreach ($products as &$product) // Iterate through our products.
                {

                    // If cover and product id match, append the cover to the images array.
                    if($product['id'] == $cover['product_id'])
                    {
                        $product['images'][] = $cover['url'];
                        break;
                    }
                }
            }
        }

        return $products;
    }

    protected function fetchProduct($productId, $includeThumbs = true)
    {
        $productId = intval($productId);
        $product = Products::limit(1)
        ->where('id', $productId)->first()->toArray();

        if($includeThumbs)
        {
            $product['images'] = [];

            foreach ($this->fetchProductThumbs($productId) as $image) {
                $product['images'][] = $image['url'];
            }
        }

        return $product;
    }

    protected function fetchProductThumbs($productId)
    {
        return $this->fetchProductsThumbs([$productId]);
    }

    protected function fetchProductsThumbs(array $productIds, $coverOnly = false)
    {
        $productThumbs = ProductThumbs::whereIn('product_id', $productIds);

        if($coverOnly)
        {
            $productThumbs->distinct();
        }

        return $productThumbs->get()->toArray();
    }
}
