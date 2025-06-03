<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class ReservationContact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone_number',
        'created_by',
    ];


    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
