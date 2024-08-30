<?php

namespace App\Http\Controllers\Ajax\Payments;

use App\Enums\PaymentSystem;
use App\Events\OrderCreatedEvent;
use App\Events\Sockets\Admin\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Repositories\Contract\OrderRepositoryContract;
use App\Services\Contracts\PaypalServiceContract;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaypalController extends Controller
{
    public function __construct(protected PaypalServiceContract $paymentService)
    {
    }

    public function create(CreateOrderRequest $request, OrderRepositoryContract $orderRepository): JsonResponse
    {
        try {
            DB::beginTransaction();

            $paypalOrderId = $this->paymentService->create(Cart::instance('cart'));

            if (!$paypalOrderId) {
                return response()->json(['error' => "Payment was not completed"], 422);
            }

            $data = [
                ...$request->validated(),
                'vendor_order_id' => $paypalOrderId
            ];

            $order = $orderRepository->create($data);

            DB::commit();

            return response()->json($order);
        } catch (\Exception $exception) {
            DB::rollBack();
            logs()->error($exception);

            return response()->json(['error' => $exception->getMessage()], 422);
        }
    }

    public function capture(string $vendorOrderId, OrderRepositoryContract $orderRepository): JsonResponse
    {
        try {
            DB::beginTransaction();

            $paymentStatus = $this->paymentService->capture($vendorOrderId);

            $order = $orderRepository->setTransaction(
                $vendorOrderId,
                PaymentSystem::Paypal,
                $paymentStatus
            );

            Cart::instance('cart')->destroy();

            DB::commit();

            OrderCreatedEvent::dispatchIf($order, $order);
            OrderCreated::dispatch($order->total);

            return response()->json($order);
        } catch (\Exception $exception) {
            DB::rollBack();
            logs()->error($exception);

            return response()->json(['error' => $exception->getMessage()], 422);
        }
    }
}
