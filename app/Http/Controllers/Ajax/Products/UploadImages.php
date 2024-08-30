<?php

namespace App\Http\Controllers\Ajax\Products;

use App\Enums\Permissions\Product as Permission;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class UploadImages extends Controller
{
    public function __invoke(Request $request, Product $product)
    {
        $this->middleware('permission:'.Permission::EDIT->value);
        $data = $request->validate([
            'images.*' => ['required', 'image:jpeg,png,jpg'],
        ]);
        $response = [];

        try {
            foreach ($data['images'] as $image) {
                $img = $product->images()->create([
                    'path' => [
                        'image' => $image,
                        'directory' => $product->slug,
                    ],
                ]);
                $response[] = ['url' => $img->url, 'id' => $img->id];
            }

            return response()->json($response);
        } catch (\Throwable $exception) {
            logs()->error($exception);

            return response()->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
