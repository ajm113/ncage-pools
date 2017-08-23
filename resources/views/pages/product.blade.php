@extends('layouts.default')


@section('pageTitle', $product['name'] )

@section('content')
    <div class="container">
        <h3>{{ $product['name'] }}</h3>


        <div class="row">
            <div class="col">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($product['images'] as $index => $image)
                            <div class="carousel-item {{ ($index == 0) ? 'active' : ''  }}">
                                <img class="d-block img-fluid" src="{{ $image }}" alt="{{ $product['name'] }} {{ $index+1 }}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col">
                <h4>Description</h4>
                <p>
                    {{ $product['description'] }}
                </p>
                <hr>
                <h4>Specifications</h4>
                <table class="table">
                    <thead>
                    <tbody>
                        <tr>
                            <th scope="row">Name</th>
                            <td>{{ $product['name'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Brand</th>
                            <td>{{ $product['brand'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Type</th>
                            <td>{{ ucfirst($product['type']) }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Above Ground</th>
                            <td>{{ $product['aboveground'] ? 'Yes' : 'No' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
