<?php

namespace App\Observers;

use App\Models\Image;
use App\Services\Contracts\FileServiceContract;

class ImageObserver
{
    public function deleted(Image $image): void
    {
        app(FileServiceContract::class)->remove($image->path);
    }
}
