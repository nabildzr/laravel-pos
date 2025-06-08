<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionDetail>
 */
class TransactionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $product = Product::inRandomOrder()->first();
        $quantity = fake()->numberBetween(1, 5);
        $price = $product->price;

        // has one
        if ($product->is_discount) {
            if ($product->discount_type === 'percentage') {
                $price = $price * (1 - ($product->discount / 100));
            } else {
                $price = $price - $product->discount;
            }
        }

        $total = $price * $quantity;

        return [
            'transaction_id' => Transaction::factory(),
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'price' => $price,
            'total' => $total,
        ];
    }
}
