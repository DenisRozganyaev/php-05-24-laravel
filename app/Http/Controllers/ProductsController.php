<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(12);

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $gallery = [
            $product->thumbnailUrl,
            ...$product->images->map(fn ($image) => $image->url)
        ];

        $wishes = [
            'exist' => auth()->check() ? auth()->user()->isWishedProduct($product, 'exist') : false,
            'price' => auth()->check() ? auth()->user()->isWishedProduct($product, 'price') : false
        ];

        return view('products.show', compact('product', 'gallery', 'wishes'));
    }
}
