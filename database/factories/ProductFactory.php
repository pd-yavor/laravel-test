<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = ProductCategory::inRandomOrder()->first();
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->numberBetween(25, 500),
            'description' => $this->faker->text(),
            'image' => $this->faker->imageUrl(),
            'category_id' => $category->id,
        ];
    }
}
