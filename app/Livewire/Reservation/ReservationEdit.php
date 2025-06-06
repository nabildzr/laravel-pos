<?php

namespace App\Livewire\Reservation;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\DiningTable;
use App\Models\ReservationContact;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReservationEdit extends Component
{
    public $reservation;
    public $reservationId;
    public $contact_name;
    public $contact_phone;
    public $contact_email;
    public $contact_address;
    public $reservation_date;
    public $reservation_time;
    public $down_payment_amount;
    public $guest_count;
    public $status;

    public $selected_tables = [];
    public $tables;
    public $pivot_tables = [];


    public function mount()
    {
        $this->reservation = Reservation::with(['diningTables', 'reservationContact'])->findOrFail($this->reservationId);

        $contact = $this->reservation->reservationContact;
        $this->contact_name = $contact->name ?? '';
        $this->contact_phone = $contact->phone_number ?? '';
        $this->contact_email = $contact->email ?? '';
        $this->contact_address = $contact->address ?? '';
        $reservationDatetime = $this->reservation->reservation_datetime ? Carbon::parse($this->reservation->reservation_datetime) : null;
        $this->reservation_date = $reservationDatetime ? $reservationDatetime->format('Y-m-d') : '';
        $this->reservation_time = $reservationDatetime ? $reservationDatetime->format('H:i') : '';
        $this->down_payment_amount = $this->reservation->down_payment_amount;
        $this->guest_count = $this->reservation->guest_count;
        $this->selected_tables = $this->reservation->diningTables->pluck('id')->toArray();
        $this->status = $this->reservation->status;


        // $this->tables = DiningTable::where(function ($query) {
        //     $query->where('status', 'available')
        //         ->orWhereIn('id', $this->selected_tables);
        // })->get();

        // $this->tables = DiningTable::where(function ($query) {
        //     $query->where('status', 'available')
        //         ->orWhereIn('id', $this->selected_tables);
        // })
        //     ->whereDoesntHave('reservations', function ($q) {
        //         $q->where('reservations.id', '!=', $this->reservationId);
        //     })
        //     ->get();

        //  select dining table from pivot (including deleted tables)
        $this->pivot_tables = DB::table('dining_table_reservation')
            ->where('reservation_id', $this->reservationId)
            ->get();

        if ($this->status === 'completed' || $this->status === 'cancelled') {
            $this->tables = collect(); // set empty tables for tables
        } else {
            // select all data that status are available in master + table in this reservation
            $existingTableIds = collect($this->pivot_tables)->pluck('dining_table_id')->toArray();
            $this->tables = DiningTable::where('status', 'available')
                ->orWhereIn('id', $existingTableIds)
                ->get();

            $this->selected_tables = $this->tables
                ->whereIn('id', $existingTableIds)
                ->pluck('id')
                ->toArray();
        }


        // $allTableIds = $this->reservation->diningTables()->pluck('dining_table_id')->toArray();
        // $existingTableIds = $this->tables->pluck('id')->toArray();
        // $this->deleted_tables = array_diff($allTableIds, $existingTableIds);
    }

    public function save()
    {
        $this->validate([
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'contact_address' => 'nullable|string|max:255',
            'down_payment_amount' => 'required|numeric|min:0',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'guest_count' => 'required|integer|min:1',
            'selected_tables' => 'required|array|min:1',
            'status' => 'required|in:reserved,occupied,cancelled,completed',
        ]);

        $reservationDatetime = Carbon::parse($this->reservation_date . ' ' . $this->reservation_time);

        // update reservation
        $this->reservation->update([
            'reservation_datetime' => $reservationDatetime,
            'guest_count' => $this->guest_count,
            'down_payment_amount' => $this->down_payment_amount,
            'status' => $this->status,
        ]);

        // $data = [];
        // foreach ($this->selected_tables as $tableId) {
        //     $table = DiningTable::find($tableId);
        //     $data[$tableId] = ['table_name' => $table ? $table->name : 'Meja dihapus'];
        // }
        // $this->reservation->diningTables()->sync($data);

        // update contact
        $contact = $this->reservation->reservationContact;
        if ($contact) {
            $contact->update([
                'name' => $this->contact_name,
                'phone_number' => $this->contact_phone,
                'email' => $this->contact_email,
                'address' => $this->contact_address,
            ]);
        }

        // update table
        // update data that previously selected
        $previousTableIds = DB::table('dining_table_reservation')
            ->where('reservation_id', $this->reservationId)
            ->pluck('dining_table_id')
            ->toArray();


        // 2. prepare for sync data
        $syncData = [];
        foreach ($this->selected_tables as $tableId) {
            $table = DiningTable::find($tableId);
            if ($table) { // Pastikan meja masih ada di master
                $syncData[$tableId] = ['table_name' => $table->name];
            }
        }

        // add table that have been deleted from master but previously in the pivot
        foreach ($previousTableIds as $prevId) {
            if (!in_array($prevId, $this->selected_tables)) {
                continue;
            }

            if (!DiningTable::find($prevId)) {
                // add to sync with new name
                $pivotTable = DB::table('dining_table_reservation')
                    ->where('reservation_id', $this->reservationId)
                    ->where('dining_table_id', $prevId)
                    ->first();

                if ($pivotTable) {
                    $syncData[$prevId] = ['table_name' => $pivotTable->table_name];
                }
            }
        }

        // sync with new data
        $this->reservation->diningTables()->sync($syncData);

        $removedTableIds = array_diff($previousTableIds, $this->selected_tables);

        // return back table
        if (!empty($removedTableIds)) {
            DiningTable::whereIn('id', $removedTableIds)->update(['status' => 'available']);
        }

        // Update status meja
        foreach (DiningTable::all() as $table) {
            if (in_array($table->id, $this->selected_tables)) {
                if ($this->status === 'cancelled') {
                    $table->status = 'available';
                } elseif ($this->status === 'occupied') {
                    $table->status = 'occupied';
                } elseif ($this->status === 'reserved') {
                    $table->status = 'reserved';
                } elseif ($this->status === 'completed') {
                    $table->status = 'available';
                }
                $table->save();
            } elseif ($table->reservations()->where('reservation_id', $this->reservation->id)->exists()) {
                $table->status = 'available';
                $table->save();
            }
        }

        if (
            ($this->reservation->status === 'completed' && $this->status !== 'completed') ||
            ($this->reservation->status === 'cancelled' && $this->status !== 'cancelled')
        ) {
            session()->flash('error', 'Status tidak dapat diubah karena reservasi sudah selesai.');
            return;
        }


        if (
            ($this->status === 'completed' || $this->status === 'cancelled')
            && !$this->reservation->completed_reservation_time
        ) {
            $this->reservation->completed_reservation_time = now();
            $this->reservation->save();
        }

        session()->flash('success', 'Reservasi berhasil diupdate!');
    }

    public function render()
    {
        return view('livewire.reservation.reservation-edit', [
            'tables' => $this->tables,
        ]);
    }
}
