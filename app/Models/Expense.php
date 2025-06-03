<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasTimestamps, SoftDeletes;

    protected $fillable = [
        'expense_category_id',
        'amount',
        'date',
        'proof',
        'description',
        'created_by',
        'approved_by',
        'rejection_reason',
        'approved_at',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }


    // approve //

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // scope buat filter berdasarkan status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
