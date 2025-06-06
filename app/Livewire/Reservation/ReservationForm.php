<?php

namespace App\Livewire\Reservation;

use App\Models\dining_table_reservation;
use Livewire\Component;
use App\Models\DiningTable;
use App\Models\Reservation;
use App\Models\ReservationContact;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationForm extends Component
{
    public $contact_name;
    public $contact_phone;
    public $contact_email;
    public $contact_address;
    public $reservation_date;
    public $reservation_time;
    public $down_payment_amount;
    public $guest_count;
    public $selected_tables = [];
    public $tables;

    public function mount()
    {
        $this->tables = DiningTable::where('status', 'available')->get();
    }

    public function save()
    {
        $this->validate([
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'email|max:255',
            'contact_address' => 'string|max:255',
            'down_payment_amount' => 'required|numeric|min:0',
            'reservation_date' => 'required|date_format:Y-m-d',
            'reservation_time' => 'required|date_format:H:i',
            'guest_count' => 'required|integer|min:1',
            'selected_tables' => 'required|array|min:1',
        ]);

        $reservationDatetime = Carbon::parse($this->reservation_date . ' ' . $this->reservation_time);



        Reservation::create([
            // 'member_id' => null,
            'reservation_datetime' => $reservationDatetime,

            'guest_count' => $this->guest_count,
            'down_payment_amount' => $this->down_payment_amount,
            'status' => 'reserved',
            'created_by' => Auth::id(),
        ]);

        $reservation = Reservation::latest()->first();

        ReservationContact::create([
            'reservation_id' => $reservation->id,
            'name' => $this->contact_name,
            'phone_number' => $this->contact_phone,
            'email' => $this->contact_email,
            'address' => $this->contact_address,
            'created_by' => Auth::id(),
        ]);

        foreach ($this->selected_tables as $tableId) {


            $reservation = Reservation::latest()->first();

            $table = DiningTable::find($tableId);
            dining_table_reservation::create([
                'reservation_id' => $reservation->id,
                'dining_table_id' => $tableId,
                'table_name' => $table ? $table->name : null,
            ]);

            // update statues
            $table = DiningTable::find($tableId);
            if ($table) {
                $table->status = 'reserved';
                $table->save();
            }
        }

        session()->flash('success', 'Reservasi berhasil dibuat!');
        $this->reset(['contact_name', 'contact_phone', 'reservation_date', 'reservation_time', 'guest_count', 'selected_tables']);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.reservation.reservation-form', [
            'tables' => $this->tables,
        ]);
    }
}
