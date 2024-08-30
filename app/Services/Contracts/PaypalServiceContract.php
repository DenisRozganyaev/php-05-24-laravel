<?php

namespace App\Services\Contracts;

use App\Enums\TransactionStatus;
use Gloudemans\Shoppingcart\Cart;

interface PaypalServiceContract
{
    public function create(Cart $cart): ?string;

    public function capture(string $vendorOrderId): TransactionStatus;
}
