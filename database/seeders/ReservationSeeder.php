<?php

namespace Database\Seeders;

use App\Models\DiningTable;
use App\Models\Reservation;
use App\Models\ReservationContact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DiningTable::count() == 0) {
            $this->call(DiningTableSeeder::class);
        }

        $reservations = [
            Reservation::factory(10)->reserved()->create(),
            Reservation::factory(15)->completed()->create(),
            Reservation::factory(5)->state(['status' => 'cancelled'])->create(),
        ];

        $allReservations = collect($reservations)->flatten();

        foreach ($allReservations as $reservation) {
            ReservationContact::factory()->create([
                'reservation_id' => $reservation->id,
                'created_by' => $reservation->created_by,
            ]);

            $tables = DiningTable::inRandomOrder()->take(rand(1, 3))->get();

            foreach ($tables as $table) {
                DB::table('dining_table_reservation')->insert([
                    'reservation_id' => $reservation->id,
                    'dining_table_id' => $table->id,
                    'table_name' => $table->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($reservation->status === 'reserved') {
                    $table->update(['status' => 'reserved']);
                } elseif ($reservation->status === 'occupied') {
                    $table->update(['status' => 'occupied']);
                }
            }
        }
    }
}
