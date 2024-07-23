<?php

namespace Tests\Unit\Services;

use App\Services\Contracts\FileServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileServiceTest extends TestCase
{
    const FILE_NAME = 'image.png';
    protected FileServiceContract $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(FileServiceContract::class); // FileService
        Storage::fake('public');
    }

    public function test_success_with_the_valid_file()
    {
        $uploadedFile = $this->uploadedFile();
        $this->assertTrue(Storage::has($uploadedFile));
        $this->assertEquals(Storage::getVisibility($uploadedFile), 'public');
    }

    public function test_it_returns_the_same_path_for_string_file()
    {
        $fileName = 'test/image.png';
        $uploadedFile = $this->service->upload($fileName);

        $this->assertEquals($uploadedFile, $fileName);
    }

    public function test_it_returns_path_without_storage_name()
    {
        $fileName = 'public/storage/test/image.png';
        $uploadedFile = $this->service->upload($fileName);

        $this->assertEquals($uploadedFile, '/test/image.png');
    }

    public function test_success_with_the_valid_file_and_additional_path()
    {
        $folder = 'test';

        $this->assertFalse(Storage::directoryExists($folder));

        $uploadedFile = $this->uploadedFile(additionPath: $folder);

        $this->assertTrue(Storage::directoryExists($folder));
        $this->assertTrue(Storage::has($uploadedFile));
        $this->assertEquals(Storage::getVisibility($uploadedFile), 'public');
    }

    public function test_remove_file()
    {
        $uploadedFile = $this->uploadedFile();

        $this->assertTrue(Storage::has($uploadedFile));

        $this->service->remove($uploadedFile);

        $this->assertFalse(Storage::has($uploadedFile));
    }

    protected function uploadedFile(string $fileName = null, string $additionPath = ''): string
    {
        $file = UploadedFile::fake()->image($fileName ?? self::FILE_NAME);
        return $this->service->upload($file, $additionPath);
    }
}
