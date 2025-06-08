<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $total_amount = fake()->numberBetween(10000, 500000);
        $paid_amount = fake()->numberBetween($total_amount, $total_amount + 100000);
        $return_amount = $paid_amount - $total_amount;

        $users = User::where('is_active', 1)->pluck('id')->toArray();
        $cashier = fake()->randomElement($users) ?? 1;

        return [
            'member_id' => fake()->boolean(70) ?
                Member::inRandomOrder()->first()->id : null,
            'cashier' => 'Cashier',
            'total_amount' => $total_amount,
            'paid_amount' => $paid_amount,
            'return_amount' => $return_amount,
            'status' => fake()->randomElement(['paid', 'pending']),
            'payment_method_id' => PaymentMethod::where('is_active', 1)
                ->inRandomOrder()->first()->id ?? 1,
            'created_by' => $cashier,
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function paid()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'paid',
            ];
        });
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'paid_amount' => 0,
                'return_amount' => 0,
            ];
        });
    }
}
