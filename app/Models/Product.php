<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'price',
        'image',
        'sku',
        'stock',
        'unit',
        'is_discount',
        'discount_type',
        'discount',
        'category_id',
        'description',
        'is_active',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function transactionDetail()
    {
        return $this->belongsTo(TransactionDetail::class);
    }
    // public function scopeActive($query)
    // {
    //     return $query->where('is_active', 1);
    // }
}
