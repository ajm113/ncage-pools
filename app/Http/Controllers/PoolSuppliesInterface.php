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
}
