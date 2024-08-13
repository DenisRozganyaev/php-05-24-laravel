<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_order_id')->unique();

            $table->foreignId('status_id')->constrained('order_statuses');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('name', 35);
            $table->string('lastname', 50);
            $table->string('phone', 15);
            $table->string('email');

            $table->string('city');
            $table->string('address');

            $table->float('total');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
