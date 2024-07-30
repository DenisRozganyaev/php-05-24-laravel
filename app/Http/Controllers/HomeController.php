<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends BaseController
{
    public function index()
    {
        $categories = Category::take(5)->get();
        $products = Product::orderByDesc('id')->take(8)->get();

        return view('home', compact('categories', 'products'));
    }
}
