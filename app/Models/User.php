<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'user_id'; // Pastikan ini sudah benar
    protected $fillable = [
        'username',
        'password',
        'role',
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


    
    public function customerService()
    {
        return $this->hasOne(CustomerService::class, 'user_id', 'user_id');
    }

    // Hubungan One-to-One dengan PersonalTrainer
    public function personalTrainer()
    {
        return $this->hasOne(PersonalTrainer::class, 'user_id', 'user_id');
    }

    // Hubungan One-to-One dengan Pelanggan
    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'user_id', 'user_id');
    }
    // App\Models\Pelanggan.php
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
