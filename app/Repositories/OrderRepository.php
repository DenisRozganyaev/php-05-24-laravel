<?php

namespace App\Repositories;

use App\Enums\PaymentSystem;
use App\Enums\TransactionStatus;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Repositories\Contract\OrderRepositoryContract;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;

class OrderRepository implements OrderRepositoryContract
{
    public function create(array $data): Order|false
    {
        $status = OrderStatus::default()->first();

        $data['total'] = Cart::instance('cart')->total();
        $data['status_id'] = $status->id;

        $order = auth()->check()
            ? auth()->user()->orders()->create($data)
            : Order::create($data);

        $this->addProductsToOrder($order);

        return $order;
    }

    public function setTransaction(string $vendorOrderId, PaymentSystem $system, TransactionStatus $status): Order
    {
        $order = Order::where('vendor_order_id', $vendorOrderId)->firstOrFail();

        $order->transaction()->create([
            'payment_system' => $system,
            'status' => $status,
        ]);

        $order->update([
            'status_id' => $this->getOrderStatus($status)->id,
        ]);

        return $order;
    }

    protected function getOrderStatus(TransactionStatus $status): OrderStatus
    {
        return match ($status) {
            TransactionStatus::Success => OrderStatus::paid()->first(),
            TransactionStatus::Canceled => OrderStatus::canceled()->first(),
            default => OrderStatus::default()->first()
        };
    }

    protected function addProductsToOrder(Order $order): void
    {
        Cart::instance('cart')->content()->each(function ($item) use ($order) {
            $product = $item->model;

            $order->products()->attach($product, [
                'quantity' => $item->qty,
                'single_price' => $item->price,
                'name' => $product->title,
            ]);

            $quantity = $product->quantity - $item->qty;

            if (! $product->update(['quantity' => $quantity])) {
                throw new Exception("Not enough product [$product->title] quantity");
            }
        });
    }
}
