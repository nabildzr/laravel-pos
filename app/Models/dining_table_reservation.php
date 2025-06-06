<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

class dining_table_reservation extends Model
{
    use HasTimestamps;

    protected $table = "dining_table_reservation";

    protected $fillable = [
            'table_name',
            'reservation_id',
            'dining_table_id'
        ];
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'dining_table_reservation');
    }
}
