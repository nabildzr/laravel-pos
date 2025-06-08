<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes, HasTimestamps, HasFactory;

    protected $fillable = [
        // 'member_id',
        'guest_count',
        'reservation_datetime',
        'status',
        'down_payment_amount',
        'created_by',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // public function member()
    // {
    //     return $this->belongsTo(Member::class, 'member_id');
    // }

    public function reservationContact()
    {
        return $this->hasOne(ReservationContact::class);
    }


    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // public function diningTable()
    // {
    //     return $this->belongsTo(DiningTable::class, 'dining_table_id');
    // }

    public function diningTables()
    {
        return $this->belongsToMany(DiningTable::class, 'dining_table_reservation');
    }
}
