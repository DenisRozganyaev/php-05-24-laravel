<?php

namespace App\Services\Contracts;

use Illuminate\Http\UploadedFile;

interface FileServiceContract
{
    public function upload(string|UploadedFile $file, string $additionalPath = ''): string;

    public function remove(string $filePath): void;
}
