<?php

namespace App\Observers;

use App\Jobs\WishList\PriceUpdatedJob;
use App\Jobs\WishList\ProductExistsJob;
use App\Models\Product;

class WishListObserver
{
    public function updated(Product $product): void
    {
        if ($product->finalPrice < $product->getOriginal('finalPrice')) {
            PriceUpdatedJob::dispatch($product);
        }

        if ($product->exist && ! $product->getOriginal('exist')) {
            ProductExistsJob::dispatch($product);
        }
    }
}
