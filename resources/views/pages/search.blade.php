@extends('layouts.default')

@section('pageTitle', 'Search Results |' . $query)

@section('content')
    <div class="container">
        <h2>Search Results for "{{ $query }}".</h2>
    </div>
    <div id="search-results">
        @if(!empty($products))
            @include('includes.gallery', ['products' => $products])
        @else
        <div class="text-center">
            <h2>Nothing found!</h2>
            <p>Please change your search query, and try again.</p>
        </div>
        @endif
    </div>
@stop

@section('pagescript')
    <script src="/assets/js/search.js"></script>
@stop
