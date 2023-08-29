<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (fake()->boolean(30)) {
            $couponCode = fake()->numberBetween(1, 10);
        } else {
            $couponCode = null;
        }
        return [
            'customer_id' => fake()->numberBetween(1, 10),
            'coupon_id' => $couponCode,
            'total_sale' => fake()->randomFloat(2),
            'status' => fake()->boolean(),
            'created_at' => now(),
            'created_by' => fake()->numberBetween(1,10),
        ];
    }
}
