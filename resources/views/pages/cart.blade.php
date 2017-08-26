@extends('layouts.default')

@section('pageTitle', "My Cart")

@section('content')
    <div class="container">
        <h1>My Cart</h1>
        <p><i>Review your cart before checking out!</i></p>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach(Cart::content() as $row)
                    <tr>
                        <td>
                            <a href="/product/{{ $row->id }}" title="{{ $row->name }}">{{ $row->name }}</a><br>
                            <a href="#" class="cart-item-delete" data-id="{{ $row->id }}" data-token="{{ csrf_token() }}"><i class="fa fa-times text-danger" aria-hidden="true"></i>Delete</a>
                        </td>
                        <td>
                            <input type="number" min="1" max="999" value="{{ $row->qty }}" data-id="{{ $row->id }}" data-token="{{ csrf_token() }}" class="form-control cart-item-update">
                        </td>
                        <td>$ {{ $row->price }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="1">&nbsp;</td>
                    <td>Subtotal</td>
                    <td>$ {{ Cart::subtotal() }}</td>
                </tr>
                <tr>
                    <td colspan="1">&nbsp;</td>
                    <td>Tax</td>
                    <td>$ {{ Cart::tax() }}</td>
                </tr>
                <tr>
                    <td colspan="1">&nbsp;</td>
                    <td>Total</td>
                    <td>$ {{ Cart::total() }}</td>
                </tr>
            </tfoot>
        </table>
        <p>If everything looks good to you, let's checkout!</p>
        <div class="text-right">
            <a href="/checkout" class="btn btn-success">Checkout!</a>
        </div>
    </div>

    @include('includes.notifications.remove-from-cart')
@stop
@section('pagescript')
    <script src="/assets/js/cart-page.js"></script>
@stop
