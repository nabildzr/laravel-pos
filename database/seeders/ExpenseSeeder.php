<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (ExpenseCategory::count() == 0) {
            $this->call(ExpenseCategorySeeder::class);
        }

        Expense::factory(15)->pending()->create();
        Expense::factory(10)->approved()->create();
        Expense::factory(5)->state([
            'status' => 'rejected',
            'approved_by' => User::where('role', 'admin')
                ->orWhere('role', 'super_admin')
                ->inRandomOrder()
                ->first()->id,
            'approved_at' => now(),
        ])->create();
    }
}
