<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiningTable extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'status',
        'name',
        'capacity',
        'created_by'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function reeservation_contact()
    {
        return $this->belongsTo(ReservationContact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reservations()  
    {
        return $this->belongsToMany(Reservation::class, 'dining_table_reservation', 'dining_table_id', 'reservation_id');
    }
}
