<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableReservation extends Model
{
    protected $table = 'table_reservations';
    
    protected $fillable = [
        'reservation_id',
        'dining_table_id',
        'reservation_datetime',
    ];
    
    protected $casts = [
        'reservation_datetime' => 'datetime',
    ];
    
    /**
     * Get the reservation that owns this table reservation.
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Get the dining table for this reservation.
     */
    public function diningTable()
    {
        return $this->belongsTo(DiningTable::class);
    }
}