<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->delete();
        DB::table('products')->delete();
        Storage::deleteDirectory('faker');

        $createProduct = function (Category $category) {
            $category->products()->attach(
                Product::factory(rand(2, 5))
                    ->withThumbnail()
                    ->create()
                    ->pluck('id') // [5, 6, 7]
            );
        };

        Category::factory(5)->create()->each($createProduct);
        Category::factory(5)->withParent()->create()->each($createProduct);
    }
}
