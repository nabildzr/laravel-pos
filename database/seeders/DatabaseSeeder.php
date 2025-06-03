<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // UserSeeder::class;

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'phone_number' => '012345678910',
        //     'full_name' => 'Test User Ganteng',
        //     'password' => bcrypt('12345'),
        //     'is_active' => true,
        //     'role' => 'admin'
        // ]);

        $this->call([
            UserSeeder::class,
            PaymentMethodSeeder::class,
            MemberSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
