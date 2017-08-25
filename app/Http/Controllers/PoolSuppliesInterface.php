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
