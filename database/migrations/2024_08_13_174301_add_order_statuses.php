<?php

use App\Enums\OrderStatusEnum;
use App\Models\OrderStatus;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        foreach (OrderStatusEnum::values() as $name) {
            OrderStatus::create(compact('name'));
        }
    }

    public function down(): void
    {
        OrderStatus::whereIn('name', OrderStatusEnum::values())->delete();
    }
};
