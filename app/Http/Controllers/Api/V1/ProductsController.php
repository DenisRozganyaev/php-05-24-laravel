<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Api\ProductUpdateRequest;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Products\ProductsCollection;
use App\Models\Product;
use App\Repositories\Contract\ProductsRepositoryContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProductsRepositoryContract $repository)
    {
        return new ProductsCollection($repository->paginate($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request, ProductsRepositoryContract $repository)
    {
        if ($product = $repository->create($request)) {
            return response()->json([
                'status' => 'success',
                'data' => new ProductResource($product),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid input data',
        ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->loadMissing(['categories', 'images']);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product, ProductsRepositoryContract $repository)
    {
        if ($repository->updateApi($product, $request)) {
            return response()->json([
                'status' => 'success',
                'data' => new ProductResource($product),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid input data',
        ], 422);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            $product->categories()->detach();
            $product->images()->delete();
            $product->deleteOrFail();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => new ProductResource($product),
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            logs()->error($exception);

            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ], $exception->getCode());
        }
    }
}
