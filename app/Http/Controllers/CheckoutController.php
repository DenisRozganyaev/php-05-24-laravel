<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $cart = Cart::instance('cart');
        $user = auth()->user();

        return view('checkout/index', compact('cart', 'user'));
    }
}
