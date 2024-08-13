<?php

namespace App\Services\Contracts;

use App\Http\Requests\CreateOrderRequest;
use Illuminate\Http\JsonResponse;

interface PaypalServiceContract
{
    public function create(CreateOrderRequest $request): array;

    public function capture(string $vendorOrderId): array;
}
