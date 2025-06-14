<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class ReservationContact extends Model
{
    use HasFactory, HasTimestamps;
    protected $fillable = [
        'reservation_id',
        'name',
        'email',
        'address',
        'phone_number', 
        'created_by',
    ];


    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
