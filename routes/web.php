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
Route::get('/checkout', function(){
    return view('pages.checkout');
});
Route::get('/search/{query}', 'PoolSuppliesInterface@search');
Route::post('/success', function(){
    Cart::destroy();
    return view('pages.success');
});
Route::get('/about', function(){
    return view('pages.about');
});
Route::get('/support', function(){
    return view('pages.support');
});


Route::post('/product/{id}', 'CartInterface@add');
Route::get('/cart', function(){
    return view('pages.cart');
});
Route::delete('/cart/{id}', 'CartInterface@remove');
Route::put('/cart/{id}/{qty}', 'CartInterface@update');


Route::post('/nca', 'TrackerInterface@event');

Route::get('/sitemaps/index.xml', 'SitemapController@index');
Route::get('/sitemaps/core.xml', 'SitemapController@core');
Route::get('/sitemaps/products.xml', 'SitemapController@products');
