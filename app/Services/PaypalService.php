<?php

namespace App\Services;

use App\Http\Requests\CreateOrderRequest;
use App\Services\Contracts\PaypalServiceContract;
use Srmklive\PayPal\Services\PayPal;


class PaypalService implements PaypalServiceContract
{
    protected Paypal $paypalClient;

    public function __construct()
    {
        $this->paypalClient = app(Paypal::class);
        $this->paypalClient->setApiCredentials(config('paypal'));
        $this->paypalClient->setAccessToken($this->paypalClient->getAccessToken());
    }

    public function create(CreateOrderRequest $request): array
    {
        return [];
    }

    public function capture(string $vendorOrderId): array
    {
        return [];
    }
}
