<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'SuperAdmin',
            'full_name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'profile_image' => '',
            'join_date' => '2025-02-03',
            'phone_number' => '012345678910',
            'password' => bcrypt('12345'),
            'is_active' => true,
            'role' => 'super_admin'
        ]);

        User::factory()->create([
            'full_name' => 'Raman',
            'name' => 'Ramen',
            'profile_image' => '',
            'email' => 'raman@example.com',
            'join_date' => '2025-02-03',
            'phone_number' => '012345678910',
            'password' => bcrypt('12345'),
            'is_active' => true,
            'role' => 'admin'
        ]);


        User::factory()->create([
            'name' => 'Remen',
            'full_name' => 'Ruman',
            'email' => 'remen@example.com',
            'profile_image' => '',
            'join_date' => '2025-02-03',
            'phone_number' => '012345678910',
            'password' => bcrypt('12345'),
            'is_active' => false,
            'role' => 'operator'
        ]);
    }
}
