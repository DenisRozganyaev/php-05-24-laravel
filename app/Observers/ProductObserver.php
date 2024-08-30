<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\Contracts\FileServiceContract;

class ProductObserver
{

    public function deleted(Product $product): void
    {
        app(FileServiceContract::class)->remove($product->thumbnail);
    }
}
