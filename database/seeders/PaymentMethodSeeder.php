<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::updateOrCreate(
            [
                'name' => 'Cash',
            ],
            [
                'description' => 'Payment transfer',
                'is_active' => true,
                'created_by' => 1
            ]
        );
        PaymentMethod::updateOrCreate(
            [
                'name' => 'Transfer',
            ],
            [
                'description' => 'Payment cash',
                'is_active' => true,
                'created_by' => 1
            ]
        );
    }
}
