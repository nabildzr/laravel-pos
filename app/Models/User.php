<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function product()
    {
        return $this->hasMany(Product::class, 'created_by');
    }

    protected function category()
    {
        return $this->hasMany(Category::class, 'created_by');
    }

    protected function member()
    {
        return $this->hasMany(Member::class, 'created_by');
    }

    protected function transaction()
    {
        return $this->hasMany(Transaction::class, 'created_by');
    }
    
    protected function paymentMethod()
    {
        return $this->hasMany(PaymentMethod::class, 'created_by');
    }
}
