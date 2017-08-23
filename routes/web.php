<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PoolSuppliesInterface@landing');

Route::get('/product/{id}', 'PoolSuppliesInterface@product');

Route::post('/product/{id}', 'PoolSuppliesInterface@product'); // Lazy way of handling adding to cart.

Route::get('/about', function(){
    return view('pages.about');
});

Route::get('/support', function(){
    return view('pages.support');
});

Route::get('/cart', function(){
    return view('pages.cart');
});

Route::get('/checkout', function(){
    return view('pages.checkout');
});

Route::post('/success', function(){
    Cart::destroy();
    return view('pages.success');
});
