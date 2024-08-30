<?php

namespace App\Repositories\Contract;

use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Http\Requests\Api\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface ProductsRepositoryContract
{
    public function create(CreateRequest $request): Product|false;
    public function update(Product $product, EditRequest $request): bool;
    public function updateApi(Product $product, ProductUpdateRequest $request): bool;

    public function paginate(Request $request): LengthAwarePaginator;
}
