@extends('layouts.default')

@section('pageTitle', "Checkout!")

@section('content')
    <div class="container">
        <h1>One Last Step!</h1>
        <form action="/success" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2>Billing</h2>
                    <div class="form-group">
                        <label for="billing-name"> First and Last Name</label>
                        <input type="text" name="billing-name" placeholder="John Doe" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="billing-address-one"> Address Line 1</label>
                        <input type="text" name="billing-address-one" placeholder="1234 E Road Ave" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="billing-address-two"> Address Line 2 (Optional)</label>
                        <input type="text" name="billing-address-two" placeholder="B1234" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="billing-city"> City</label>
                        <input type="text" name="billing-city" placeholder="City" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="billing-postal-code"> Postal Code / Zip</label>
                        <input type="text" name="billing-postal-code" placeholder="12345" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="billing-country"> Country</label>
                        <input type="text" name="billing-country" placeholder="United States" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="billing-email"> Email</label>
                        <input type="email" name="billing-email" placeholder="johndoe@email.com" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="billing-phone"> Phone</label>
                        <input type="telephone" name="billing-phone" placeholder="1234567890" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="billing-bitcoin"> Bitcoin Wallet</label>
                        <input type="password" name="billing-bitcoin" placeholder="1cec944e63c3dfe2d00cba193ac23d71" class="form-control" required="required">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2>Shipping</h2>
                    <div class="form-group">
                        <label><input type="checkbox" id="shipping-same-as-billing"> Shipping same as billing address</label>
                    </div>
                    <div class="form-group">
                        <label for="shipping-address-one"> Address Line 1</label>
                        <input type="text" name="shipping-address-one" placeholder="1234 E Road Ave" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="shipping-address-two"> Address Line 2 (Optional)</label>
                        <input type="text" name="shipping-address-two" placeholder="B1234" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="shipping-city"> City</label>
                        <input type="text" name="shipping-city" placeholder="City" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="shipping-postal-code"> Postal Code / Zip</label>
                        <input type="text" name="shipping-postal-code" placeholder="12345" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="shipping-country"> Country</label>
                        <input type="text" name="shipping-country" placeholder="United States" class="form-control" required="required">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col text-right">
                    <button class="btn btn-success btn-lg">Submit Order!!!</button>
                </div>
            </div>
        </form>
    </div>
@stop

@section('pagescript')
    <script src="/assets/js/checkout-page.js"></script>
@stop
