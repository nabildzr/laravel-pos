
<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

  public function run()
  {
    User::factory()->create([
      'name' => 'Test User',
      'email' => 'test@example.com',
      'phone_number' => '012345678910',
      'full_name' => 'Test User Ganteng',
      'password' => bcrypt('12345'),
      'is_active' => true,
      'role' => 'admin'
    ]);
  }
}
