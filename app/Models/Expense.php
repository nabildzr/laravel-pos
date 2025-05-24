<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'amount',
        'date',
        'proof',
        'category',
        'description',
        'amount',
        'created_by',
        'is_approved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
