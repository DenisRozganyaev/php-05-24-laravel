<?php

namespace App\Http\Requests\Admin\Categories;

use App\Enums\Permissions\Category as Permission;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can(Permission::EDIT->value);
    }

    public function rules(): array
    {
        $id = $this->route('category')->id;

        return [
            'name' => ['required', 'string', 'min: 2', 'max: 50', Rule::unique(Category::class, 'name')->ignore($id)],
            'parent_id' => ['nullable', 'numeric', 'exists:'.Category::class.',id'],
        ];
    }
}
