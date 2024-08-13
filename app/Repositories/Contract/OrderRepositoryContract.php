<?php

namespace App\Repositories\Contract;

use App\Enums\PaymentSystem;
use App\Enums\TransactionStatus;
use App\Models\Order;

interface OrderRepositoryContract
{
    public function create(array $data): Order|false;

    public function setTransaction(string $vendorOrderId, PaymentSystem $system, TransactionStatus $status): Order;
}
