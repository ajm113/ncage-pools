<div class="container generic-gallery">
    <div class="row">
        @foreach($products as $product)
            <a class="col-lg-3 col-md-6 col-sm-12 thumbnail" href="/product/{{ $product['id']  }}" title="{{ $product['name']  }}">
                <h6>{{ $product['name']  }}</h6>
                <img src="{{ current($product['images'])  }}" alt="{{ $product['name']  }}" class="img-fluid img-thumbnail">
            </a>
        @endforeach
    </div>
</div>
