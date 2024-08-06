<?php

namespace App\Jobs\WishList;

use App\Models\Product;
use App\Notifications\WishList\NewPriceNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

abstract class BaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Product $product)
    {
        $this->onQueue('wishlist');
    }

    abstract public function handle(): void;

    protected function sendNotifications(string $notificationClass, string $type = 'price'): void
    {
        // 1500 => 3 iterate 500 500 500
        $this->product->followers()
            ->wherePivot($type, true)
            ->chunk(
                500,
                fn(Collection $users) => Notification::send(
                    $users,
                    app($notificationClass, [
                        'product' => $this->product
                    ])
                )
            );
    }
}
