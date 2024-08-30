<?php

namespace App\Jobs\WishList;

use App\Notifications\WishList\NewPriceNotification;

class PriceUpdatedJob extends BaseJob
{
    public function handle(): void
    {
        $this->sendNotifications(NewPriceNotification::class);
    }
}
