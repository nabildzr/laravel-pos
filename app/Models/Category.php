<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'created_by'
    ];


    protected $table = 'categories';


    // avoid deleting category
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            if ($category->product()->count() > 0) {
                throw new \Exception('Cannot delete category because it has related products.');
            }
        });
    }


    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
