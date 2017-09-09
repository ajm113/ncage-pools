@extends('layouts.sitemap')
@section('content')
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        @foreach ($products as $product)
            <url>
                <loc>{{ URL::to('/product/' . $product['id']) }}</loc>
                <changefreq>weekly</changefreq>
                <priority>0.6</priority>
            </url>
        @endforeach
    </urlset>
@stop
