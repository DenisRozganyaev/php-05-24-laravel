<?php

namespace App\Repositories;

use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Models\Product;
use App\Repositories\Contract\ImagesRepositoryContract;
use App\Repositories\Contract\ProductsRepositoryContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ProductsRepository implements ProductsRepositoryContract
{
    public function __construct(protected ImagesRepositoryContract $imageRepository)
    {
    }

    public function create(CreateRequest $request): Product|false
    {
        try {
            DB::beginTransaction();

            $data = $this->formRequestData($request);
            $product = Product::create($data['attributes']);
            $this->setProductRelationData($product, $data);

            DB::commit();

            return $product;
        } catch (Throwable $exception) {
            DB::rollBack();
            logs()->error($exception);

            return false;
        }
    }

    public function update(Product $product, EditRequest $request): bool
    {
        try {
            DB::beginTransaction();

            $data = $this->formRequestData($request);
            $product->update($data['attributes']);
            $this->setProductRelationData($product, $data);

            DB::commit();

            return true;
        } catch (Throwable $exception) {
            DB::rollBack();
            logs()->error($exception);

            return false;
        }
    }

    protected function setProductRelationData(Product $product, array $data): void
    {
        $product->categories()->sync($data['categories']);

        if (!empty($data['images'])) {
            $this->imageRepository->attach(
                $product,
                'images',
                $data['images'],
                $product->images_dir
            );
        }
    }

    protected function formRequestData(CreateRequest|EditRequest $request): array
    {
        return [
            'attributes' => collect($request->validated())
                ->except(['categories'])
                ->prepend(Str::slug($request->get('title')), 'slug')
                ->toArray(),
            'categories' => $request->get('categories', []),
            'images' => $request->file('images', [])
        ];
    }
}
