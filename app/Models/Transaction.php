<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'member_id',
        'cashier',
        'total_amount',
        'paid_amount',
        'return_amount',
        'status',
        'payment_method_id',
        'created_by',
    ];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}
