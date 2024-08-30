<?php

namespace App\Http\Requests\Admin\Categories;

use App\Enums\Permissions\Category as Permission;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    protected $redirectRoute = 'admin.categories.create';

    public function authorize(): bool
    {
        return auth()->user()->can(Permission::PUBLISH->value);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min: 2', 'max: 50', 'unique:' . Category::class],
            'parent_id' => ['nullable', 'numeric', 'exists:' . Category::class . ',id']
        ];
    }
}
