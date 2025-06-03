<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiningTable extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'status',
        'name',
        'capacity',
        'created_by'
    ];

    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function reeservation_contact() {
        return $this->belongsTo(ReservationContact::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'created_by')
;    }
}
