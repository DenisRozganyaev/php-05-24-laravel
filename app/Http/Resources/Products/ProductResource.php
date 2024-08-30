<?php

namespace App\Http\Resources\Products;

use App\Http\Resources\Categories\CategoriesCollection;
use App\Http\Resources\Images\ImagesCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'thumbnail' => $this->thumbnailUrl,
            'quantity' => $this->quantity,
            'prices' => [
                'price' => $this->price,
                'discount' => $this->discount,
                'final' => $this->finalPrice
            ],
            'categories' => new CategoriesCollection($this->categories),
            'images' => new ImagesCollection($this->images),
        ];
    }
}
