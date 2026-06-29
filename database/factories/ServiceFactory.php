<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true).' Grooming',
            'category' => 'grooming',
            'price' => fake()->numberBetween(50000, 150000),
            'duration_minutes' => 60,
            'daily_slot_capacity' => 5,
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
