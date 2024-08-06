<?php

namespace App\Jobs\WishList;

use App\Notifications\WishList\ProductAvailableNotification;

class ProductExistsJob extends BaseJob
{
    public function handle(): void
    {
        $this->sendNotifications(ProductAvailableNotification::class, 'exist');
    }
}
