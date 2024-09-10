@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 py-5">
            <h1>Top Categories</h1>
            <div>
                @each('categories.parts.label', $categories, 'category')
            </div>
        </div>
    </div>




    <div class="row justify-content-center">
        <div class="col-12 py-5">
            <h1>Latest products</h1>
        </div>
    </div>




    
    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-lg-4 g-3">
        @each('products.parts.card', $products, 'product')
    </div>
</div>
@endsection
