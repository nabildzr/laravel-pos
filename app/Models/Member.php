<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'address',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transactionAll()
    {
        return $this->hasMany(Transaction::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'member_id');
    }
}
