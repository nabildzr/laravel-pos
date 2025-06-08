<?php

namespace Database\Seeders;

use App\Models\DiningTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiningTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DiningTable::factory(15)->available()->create();
        DiningTable::factory(5)->create();

        $tableTypes = [
            ['name' => 'Bar 1', 'capacity' => 2],
            ['name' => 'Bar 2', 'capacity' => 2],
            ['name' => 'VIP Table', 'capacity' => 8],
            ['name' => 'Family Table 1', 'capacity' => 6],
            ['name' => 'Family Table 2', 'capacity' => 6],
            ['name' => 'Counter 1', 'capacity' => 1],
            ['name' => 'Counter 2', 'capacity' => 1],
            ['name' => 'Counter 3', 'capacity' => 1],
        ];

        foreach ($tableTypes as $table) {
            DiningTable::factory()->create([
                'name' => $table['name'],
                'capacity' => $table['capacity'],
                'status' => 'available',
            ]);
        }
    }
}
