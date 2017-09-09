<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Closure;
use App\Products;
use Illuminate\Http\RedirectResponse;

class SitemapController extends Controller
{
    public function index()
    {
        return response()->view('sitemaps.index')
        ->header('Content-Type', 'text/xml');
    }

    public function core()
    {
        return response()->view('sitemaps.core')
        ->header('Content-Type', 'text/xml');
    }

    public function products()
    {
        $products = Products::fetchAllProducts();

        $viewVariables = [
            'products' => $products
        ];

        return response()->view('sitemaps.products', $viewVariables)
        ->header('Content-Type', 'text/xml');
    }
}
