<?php

namespace App\Http\Resources\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // route() => categories/name-of-category
        // url() => http://laravel.test
        // url(route('categories.show', $this)) => http://laravel.test/categories/name-of-category

        return [
            //            'url' => url(route('categories.show', $this)),
            'name' => $this->name,
            'parent' => new self($this->parent),
        ];
    }
}
