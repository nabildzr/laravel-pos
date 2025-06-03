<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'transaction_id',
        'transaction_detail_id',
        'member_id',
        'status',
        'down_payment_amount',
    ];


    public function user()
    {
        return $this->belongsTo(User::class,' created_by');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
