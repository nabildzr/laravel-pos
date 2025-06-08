<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        $categories = [
            'Rent',
            'Utilities',
            'Salaries',
            'Food Supplies',
            'Beverages',
            'Equipment',
            'Maintenance',
            'Marketing',
            'Office Supplies',
            'Transportation',
            'Insurance',
            'Taxes',
            'Miscellaneous'
        ];

        foreach ($categories as $category) {
            ExpenseCategory::create([
                'name' => $category,
                'created_by' => $user->id,
            ]);
        }

        ExpenseCategory::factory(5)->create();
    }
}
