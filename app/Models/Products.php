<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'sku',
        'price',
        'cost',
        'stock',
        'unit',
        'description',
        'is_active',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // public function scopeActive($query)
    // {
    //     return $query->where('is_active', 1);
    // }
}
