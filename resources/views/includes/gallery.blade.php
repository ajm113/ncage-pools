<div class="container generic-gallery">
    <div class="row">
        @foreach($products as $product)
            <div class="col-lg-3 col-md-6 col-sm-12 thumbnail">
                <a href="/product/{{ $product['id']  }}" title="{{ $product['name']  }}"><h6>{{ $product['name']  }}</h6></a>
                <a href="/product/{{ $product['id']  }}" title="{{ $product['name']  }}"><img src="{{ current($product['images'])  }}" alt="{{ $product['name']  }}" class="img-fluid img-thumbnail"></a>
                <span class="text-success">$ {{ $product['price'] }}</span>
            </div>
        @endforeach
    </div>
</div>
