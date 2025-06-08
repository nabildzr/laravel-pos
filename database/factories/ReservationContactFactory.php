<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReservationContact>
 */
class ReservationContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(),
            'name' => fake()->name(),
            'email' => fake()->optional(0.7)->safeEmail(),
            'address' => fake()->optional(0.5)->address(),
            'phone_number' => fake()->phoneNumber(),
            'created_by' => User::inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
