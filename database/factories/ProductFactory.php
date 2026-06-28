<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true).' Pet Food',
            'category' => 'makanan',
            'price' => fake()->numberBetween(20000, 200000),
            'stock' => fake()->numberBetween(0, 50),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
