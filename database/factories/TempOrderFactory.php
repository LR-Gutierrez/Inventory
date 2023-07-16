<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TempOrder>
 */
class TempOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => fake()->numberBetween(1, 10),
            'product_id' => fake()->numberBetween(1, 10),
            'item_quantity' => fake()->randomNumber(3),
            'price' => fake()->randomFloat(2),
            'created_at' => now(),
            'created_by' => fake()->numberBetween(1,10),
        ];
    }
}
