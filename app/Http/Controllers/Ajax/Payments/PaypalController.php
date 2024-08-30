<?php

namespace App\Http\Controllers\Ajax\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Services\Contracts\PaypalServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaypalController extends Controller
{
    public function __construct(protected PaypalServiceContract $paymentService)
    {
    }

    public function create(CreateOrderRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $orderData = $this->paymentService->create($request);

            DB::commit();

            return response()->json();
        } catch (\Exception $exception) {
            DB::rollBack();
            logs()->error($exception);

            return response()->json(['error' => $exception->getMessage()], 422);
        }
    }

    public function capture(string $vendorOrderId): JsonResponse
    {
        try {
            DB::beginTransaction();

            $orderData = $this->paymentService->capture($vendorOrderId);

            DB::commit();

            return response()->json();
        } catch (\Exception $exception) {
            DB::rollBack();
            logs()->error($exception);

            return response()->json(['error' => $exception->getMessage()], 422);
        }
    }
}
