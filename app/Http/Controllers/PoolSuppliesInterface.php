<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Request;                                // Check if the request is a post for shopping cart.

use App\Products;                           // Pull in products from database for our site.
use App\ProductThumbs;                      // Pull in product thumbs/covers for our site.

use Cart;                                   // Used when we want to update/add to the cart.

class PoolSuppliesInterface extends Controller
{

    public function landing()
    {
        $products = Products::fetchAllProducts();
        $products = ProductThumbs::fetchIntoProducts($products);

        $viewVariables = [
            'products' => $products
        ];

        return view('pages.landing', $viewVariables);
    }

    public function product($productId)
    {

        $product = Products::fetchProduct($productId);
        $product = ProductThumbs::fetchIntoProduct($product);

        $suggestedProducts = Products::fetchSuggestedProducts($product);
        $suggestedProducts = ProductThumbs::fetchIntoProducts($suggestedProducts);

        $viewVariables = [
            'product' => $product,
            'suggestedProducts' => $suggestedProducts
        ];

        return view('pages.product', $viewVariables);
    }

    public function search($query)
    {
        $query = trim(urldecode($query));

        if($query > 3 && $query < 20)
        {
            $products = Products::searchProducts($query);
            $products = ProductThumbs::fetchIntoProducts($products);
        }
        else
        {
            $products = [];         // We send an empty array just so the user thinks they need to change their query.
        }


        $viewVariables = [
            'query' => $query,
            'products' => $products
        ];

        return view('pages.search', $viewVariables);
    }
}
