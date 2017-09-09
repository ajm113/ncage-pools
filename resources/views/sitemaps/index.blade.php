@extends('layouts.sitemap')
@section('content')
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ URL::to('/') }}/sitemaps/core.xml</loc>
    </sitemap>
    <sitemap>
        <loc>{{ URL::to('/') }}/sitemaps/products.xml</loc>
    </sitemap>
</sitemapindex>
@stop
