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
    
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }


    public function diningTable()
    {
        return $this->belongsTo(DiningTable::class);
    }
}