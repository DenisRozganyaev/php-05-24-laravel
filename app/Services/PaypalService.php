<?php

namespace App\Services;

use App\Enums\TransactionStatus;
use App\Services\Contracts\PaypalServiceContract;
use Gloudemans\Shoppingcart\Cart;
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

    public function create(Cart $cart): ?string
    {
        $paypalOrder = $this->paypalClient->createOrder($this->buildOrderRequestData($cart));

        logs()->info('Paypal create order response:', [
            'response' => $paypalOrder,
        ]);

        return $paypalOrder['id'] ?? null;
    }

    public function capture(string $vendorOrderId): TransactionStatus
    {
        $result = $this->paypalClient->capturePaymentOrder($vendorOrderId);

        return match ($result['status']) {
            'COMPLETED', 'APPROVED' => TransactionStatus::Success,
            'CREATED', 'SAVED' => TransactionStatus::Pending,
            default => TransactionStatus::Canceled
        };
    }

    protected function buildOrderRequestData(Cart $cart): array
    {
        $currencyCode = config('paypal.currency');
        $items = [];

        $cart->content()->each(function ($cartItem) use (&$items, $currencyCode) {
            $items[] = [
                'name' => $cartItem->name,
                'quantity' => $cartItem->qty,
                'sku' => $cartItem->model->SKU,
                'url' => url(route('products.show', $cartItem->model)),
                'category' => 'PHYSICAL_GOODS',
                'unit_amount' => [
                    'value' => $cartItem->price,
                    'currency_code' => $currencyCode,
                ],
                'tax' => [
                    'value' => round($cartItem->price / 100 * $cartItem->taxRate, 2),
                    'currency_code' => $currencyCode,
                ],
            ];
        });

        return [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => $currencyCode,
                        'value' => $cart->total(),
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => $currencyCode,
                                'value' => $cart->subtotal(),
                            ],
                            'tax_total' => [
                                'currency_code' => $currencyCode,
                                'value' => $cart->tax(),
                            ],
                        ],
                    ],
                    'items' => $items,
                ],
            ],
        ];
    }
}
