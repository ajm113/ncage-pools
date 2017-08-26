<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Products;                      // Pull in product thumbs/covers for our site.

use Cart;                                   // Used when we want to update/add to the cart.

class CartInterface extends Controller
{

    public function remove($productId)
    {
        $productId = intval($productId);                     // Sanatize our product id.

        $product = $this->fetchProductFromCart($productId);

        if($product)
            Cart::remove($product->rowId);

        return response()->json([
            'success' => (boolval($product)),
            'quantity' => (boolval($product)) ? $product->qty : 0
        ]);
    }

    public function update($productId, $quantity)
    {
        $productId = intval($productId);                    // Sanatize our product id.
        $quantity = intval($quantity);                      // Sanatize our quantity.
        $quantity = ($quantity < 1 || $quantity > 999) ? 1 : $quantity;

        $product = $this->fetchProductFromCart($productId);

        if($product)
        {
            $quantityDifference = ($quantity - $product->qty);  // Used to get the difference for front-end.
            Cart::update($product->rowId, $quantity);
        }

        return response()->json([
            'success' => boolval($product),
            'quantity' => ($product) ? $quantityDifference : 0
        ]);
    }

    public function add($productId)
    {
        $quantity = intval($_POST['quantity']);                     // Sanatize our input.
        $quantity = ($quantity < 1 || $quantity > 999) ? 1 : $quantity; // Some simple checking to make sure our quantity is OK.

        $product = Products::fetchProduct($productId);

        if($product)
            Cart::add($product['id'], $product['name'], $quantity, $product['price'], ['size' => 'large']);

        return response()->json([
            'success' => ($product == true),
            'quantity' => $quantity,
            'message' => ($product == false) ? 'Supplied product is invalid!' : ''
        ]);
    }

    protected function fetchProductFromCart($productId)
    {
        $product = Cart::search(function ($cartItem, $rowId) use($productId) {
            return $cartItem->id === $productId;
        });

        if($product->isEmpty())
            return false;

        return $product->first();
    }
}
