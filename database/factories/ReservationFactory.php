<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     public function definition(): array
    {
        $status = fake()->randomElement(['reserved', 'occupied', 'completed', 'cancelled']);
        $reservationDate = fake()->dateTimeBetween('-1 month', '+1 month');
        $completedDate = null;
        
        if ($status === 'completed') {
            $completedDate = (clone $reservationDate)->modify('+2 hours');
        }
        
        return [
            'reservation_datetime' => $reservationDate,
            'completed_reservation_time' => $completedDate,
            'down_payment_amount' => fake()->numberBetween(50000, 200000),
            'guest_count' => fake()->numberBetween(2, 20),
            'status' => $status,
            'created_by' => User::inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
    
    public function reserved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'reserved',
                'completed_reservation_time' => null,
            ];
        });
    }
    
    public function completed()
    {
        return $this->state(function (array $attributes) {
            $reservationDate = $attributes['reservation_datetime'];
            return [
                'status' => 'completed',
                'completed_reservation_time' => (clone $reservationDate)->modify('+2 hours'),
            ];
        });
    }
}
