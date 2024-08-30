<div class="col">
    <div class="card shadow-sm product-card" style="width: 18rem;">
        <img src="{{ $product->thumbnailUrl }}" class="card-img-top w-100 product-card-image" alt="{{ $product->title }}">
        <div class="card-body">
            <h5 class="card-title">{{ $product->title }}</h5>
            <div class="row">
                <div class="col-12 col-sm-6">Price: </div>
                <div class="col-12 col-sm-6">{{ $product->finalPrice }} $</div>
            </div>
        </div>
        <div class="card-footer">
            <a href="#" class="btn btn-outline-success my-2">Buy</a>
            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-info my-2">Show</a>
        </div>
    </div>
</div>
