<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Image;

class RemoveImageController extends Controller
{
    public function __invoke(Image $image): \Illuminate\Http\JsonResponse
    {
        try {
            $image->deleteOrFail();

            return response()->json(['message' => 'Image was removed!']);
        } catch (\Throwable $exception) {
            logs()->error($exception);

            return response()->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
