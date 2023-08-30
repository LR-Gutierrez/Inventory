<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (fake()->boolean(50)) {
            $expiration_date = fake()->dateTimeBetween('now', '+1 year');
        } else {
            $expiration_date = null;
        }
        return [
            'name' => fake()->name(),
            'description' => fake()->sentence(3),
            'item_quantity' => fake()->randomNumber(3),
            'price' => fake()->randomFloat(2),
            'supplier_id' => fake()->numberBetween(1, 10),
            'item_category_id' => fake()->numberBetween(1, 10),
            'expiration_date' => $expiration_date,
            'created_at' => now(),
            'created_by' => fake()->numberBetween(1,10),
        ];
    }
}
