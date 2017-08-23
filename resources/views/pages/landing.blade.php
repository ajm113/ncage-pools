@extends('layouts.default')

@section('pageTitle', "I could swim for hours, that's why I started a pool supply company.")

@section('content')
    <div class="container">
        <br>
        <h3>I could swim for hours, that's why I started a pool supply company.</h3>
        <i>-- Nicolas Cage</i>
    </div>
    @include('includes.gallery', ['products' => $products])
@stop
