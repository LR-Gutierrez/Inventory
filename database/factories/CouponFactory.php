<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->sentence(3),
            'coupon_code' => fake()->bothify('??????###'),
            'claimable' => fake()->randomNumber(),
            'created_by' => fake()->numberBetween(1, 10),
            'created_at' => now(),
        ];
    }
}
