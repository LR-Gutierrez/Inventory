<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'tin' => fake()->numerify('##########'),
            'business_manager_id' => fake()->numberBetween(1, 10),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'website' => fake()->url(),
            'created_at' => now(),
            'created_by' => fake()->numberBetween(1,10),
        ];
    }
}
