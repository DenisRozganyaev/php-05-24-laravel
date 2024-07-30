@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 py-5">
                <h1>Products</h1>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-lg-4 g-3">
            @each('products.parts.card', $products, 'product')
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
