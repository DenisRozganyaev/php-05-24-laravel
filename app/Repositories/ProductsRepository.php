<?php

namespace App\Repositories;

use App\Http\Requests\Admin\Products\CreateRequest;
use App\Models\Product;
use App\Repositories\Contract\ProductsRepositoryContract;

class ProductsRepository implements ProductsRepositoryContract
{

    public function create(CreateRequest $request): Product|false
    {
        return false;
    }
}
