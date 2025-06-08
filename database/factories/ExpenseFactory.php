<?php

namespace Database\Factories;

use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'approved', 'rejected']);
        $approvedBy = null;
        $approvedAt = null;

        if ($status !== 'pending') {
            $approvedBy = User::where('role', 'admin')
                ->orWhere('role', 'super_admin')
                ->inRandomOrder()
                ->first()->id;
            $approvedAt = fake()->dateTimeBetween('-1 month', 'now');
        }

        return [
            'expense_category_id' => ExpenseCategory::inRandomOrder()->first()->id ?? ExpenseCategory::factory(),
            'date' => fake()->dateTimeBetween('-3 months', 'now'),
            'proof' => 'expense_proofs/' . fake()->uuid . '.jpg',
            'amount' => fake()->numberBetween(10000, 5000000),
            'description' => fake()->sentence(),
            'created_by' => User::inRandomOrder()->first()->id ?? User::factory(),
            'approved_by' => $approvedBy,
            'approved_at' => $approvedAt,
            'status' => $status,
        ];
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
            ];
        });
    }

    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'approved',
                'approved_by' => User::where('role', 'admin')
                    ->orWhere('role', 'super_admin')
                    ->inRandomOrder()
                    ->first()->id ?? User::factory(),
                'approved_at' => fake()->dateTimeBetween('-1 month', 'now'),
            ];
        });
    }
}
