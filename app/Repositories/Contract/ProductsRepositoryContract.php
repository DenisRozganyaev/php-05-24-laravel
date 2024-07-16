<?php

namespace App\Repositories\Contract;

use App\Http\Requests\Admin\Products\CreateRequest;
use App\Models\Product;

interface ProductsRepositoryContract
{
    public function create(CreateRequest $request): Product|false;
    public function update(Product $product, CreateRequest $request): bool;
}
