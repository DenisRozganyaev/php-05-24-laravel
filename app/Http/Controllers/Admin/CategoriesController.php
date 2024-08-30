<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permissions\Category as Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\CreateRequest;
use App\Http\Requests\Admin\Categories\EditRequest;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['parent'])
            ->paginate(10);

        return view('admin/categories/index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/categories/create', ['categories' => Category::select(['id', 'name'])->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        Category::create($data);

        notify()->success("Category [$data[name]] was created.");

        return redirect()->route('admin.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin/categories/edit', [
            'categories' => Category::select(['id', 'name'])
                ->whereNot('id', $category->id)
                ->get(),
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        $category->updateOrFail($data);

        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->middleware('permission:' . Permission::DELETE->value);

        $category->deleteOrFail();

        return redirect()->route('admin.categories.index');
    }
}
