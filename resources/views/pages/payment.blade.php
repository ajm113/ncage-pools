@extends('layouts.default')

@section('pageTitle', "Set Payment")

@section('content')
    <div class="container">
        <h1>Payment Details</h1>
        <form action="/success" method="POST" class="payment-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2>Credit Card</h2>
                    <div class="form-group">
                        <label for="name-on-card"> Name on Card</label>
                        <input type="text" name="name-on-card" placeholder="John Doe" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="card-number"> Card Number</label>
                        <input type="number" name="card-number" placeholder="1234567890" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="expiration-date"> Expiration Date</label>
                        <input type="text" name="expiration-date" placeholder="MMYY" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="cvv"> CVV</label>
                        <input type="text" name="cvv" placeholder="123" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit Payment</button>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                    <h2>You Will Be Charged</h2>
                    <h1 class="text-success">$ {{ Cart::total() }}</h1>
                    <p>
                        After you click <strong>Submit Payment</strong> your card will be charged! <br>
                        <i>Not really, this payment form isn't connected to anything. ;)</i>
                    </p>
                </div>
            </div>
        </form>
    </div>
    @include('includes.notifications.payment-error')
@stop

@section('pagescript')
    <script src="/assets/js/vendors/jquery.payment.min.js"></script>
    <script src="/assets/js/checkout-page.js"></script>
@stop
