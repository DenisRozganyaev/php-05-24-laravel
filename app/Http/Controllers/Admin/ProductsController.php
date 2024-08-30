<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permissions\Product as Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contract\ProductsRepositoryContract;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['categories'])
            ->sortable()
            ->paginate(10);

        return view('admin/products/index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/products/create', ['categories' => Category::select(['id', 'name'])->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request, ProductsRepositoryContract $repository)
    {
        if ($product = $repository->create($request)) {
            notify()->success("Product '$product->title' was created!");

            return redirect()->route('admin.products.index');
        }
        notify()->error('Oops, smth went wrong');

        return redirect()->back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load(['images', 'categories']);

        $categories = Category::all();
        $productCategories = $product->categories->pluck('id')->toArray();

        return view('admin/products/edit', compact('categories', 'productCategories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, Product $product, ProductsRepositoryContract $repository)
    {
        if ($repository->update($product, $request)) {
            notify()->success("Product '$product->title' was updated!");

            return redirect()->route('admin.products.edit', $product);
        }
        notify()->error('Oops, smth went wrong');

        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->middleware('permission:'.Permission::DELETE->value);

        $product->categories()->detach();
        $product->images()->delete();
        $product->deleteOrFail();

        notify()->sucess("Product '$product->title' was removed!");

        return redirect()->route('admin.products.index');
    }
}
