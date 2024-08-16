<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ThankYouController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $vendorOrderId)
    {
        try {
            $order = Order::with(['transaction', 'products', 'status'])
                ->where('vendor_order_id', $vendorOrderId)
                ->firstOrFail();

            $showInvoiceBtn = auth()->check() && auth()->id() === $order?->user_id;

            return view('orders/thank-you', compact('order', 'showInvoiceBtn'));
        } catch (\Exception $exception) {
            return redirect()->route('home');
        }
    }
}
