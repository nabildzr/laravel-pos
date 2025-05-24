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
        return [
            'name' => fake()->words(3, true),
            'price' => fake()->numberBetween(1, 100000),
            'image' => fake()->optional()->imageUrl(),
            'sku' => strtoupper(fake()->unique()->bothify('SKU-#####')),
            'stock' => fake()->numberBetween(0, 500),
            'is_discount' => fake()->boolean(20),
            'discount' => fake()->optional()->numberBetween(1, 50),
            'discount_type' => fake()->optional()->randomElement(['percent', 'amount']),
            'unit' => fake()->randomElement(['pcs', 'kg', 'box', 'pack']),
            'description' => fake()->optional()->sentence(),
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'is_active' => fake()->boolean(80),
            'created_by' => 1,
        ];
    }
}
