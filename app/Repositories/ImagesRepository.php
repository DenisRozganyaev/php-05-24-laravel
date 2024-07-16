<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class ImagesRepository implements Contract\ImagesRepositoryContract
{
    public function attach(Model $model, string $relation, array $images = [], ?string $directory = null): void
    {
        if (! method_exists($model, $relation)) {
            throw new \Exception($model::class . "doesn't have '$relation' relation");
        }

        if (!empty($images)) {
            foreach($images as $image) {
                call_user_func([$model, $relation])->create([
                   'path' => compact('image', 'directory')
                ]);
            }
        }
    }
}
