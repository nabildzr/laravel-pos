<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'address',
        'logo',
        'receipt_footer',
        'tax_number',
    ];

 
    public static function getSettings()
    {
        return self::first();
    }
}
