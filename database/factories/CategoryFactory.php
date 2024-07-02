<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(rand(1, 3), true);
        $slug = Str::slug($name);

        return compact('name', 'slug');
    }

    public function withParent(): static
    {
        return $this->state(fn ($attrs) => ['parent_id' => Category::all()->random()?->id]);
    }
}
