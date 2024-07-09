<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permissions\Category as Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\CreateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contract\ProductsRepositoryContract;
use Illuminate\Support\Str;

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
            return redirect()->route('admin.products.index');
        }

        return redirect()->back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin/categories/edit', [
            'categories' => Category::select(['id', 'name'])
                ->whereNot('id', $product->id)
                ->get(),
            'category' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        $product->updateOrFail($data);

        return redirect()->route('admin.categories.edit', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->middleware('permission:' . Permission::DELETE->value);

        $product->deleteOrFail();

        return redirect()->route('admin.categories.index');
    }
}
