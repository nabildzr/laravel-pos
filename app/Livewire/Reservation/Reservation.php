<?php

namespace App\Livewire\Reservation;

use Livewire\Component;

class Reservation extends Component
{
    public function render()
    {


        $reservations = \App\Models\Reservation::query()
            ->with(['user', 'diningTables', 'reservationContact']) 
            ->latest()
            ->get();

        return view('livewire.reservation.reservation', [
            'reservations' => $reservations,
        ]);
    }

    public $statuses = [];

    public function mount()
    {
        $this->statuses = \App\Models\Reservation::pluck('status', 'id')->toArray();
    }

    public function updateStatus($reservationId)
    {
        $reservation = \App\Models\Reservation::findOrFail($reservationId);
        $newStatus = $this->statuses[$reservationId];

        // Update reservation status
        $reservation->status = $newStatus;
        $reservation->save();

        // Update dining table status
        $table = \App\Models\DiningTable::find($reservation->dining_table_id);
        if ($table) {
            if ($newStatus == 'reserved') {
                $table->status = 'reserved';
            } elseif ($newStatus == 'occupied') {
                $table->status = 'occupied';
            } elseif ($newStatus == 'completed') {
                $table->status = 'available';
            }
            $table->save();
        }

        session()->flash('success', 'Status berhasil diupdate!');
    }
}
