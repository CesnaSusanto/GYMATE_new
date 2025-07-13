<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalTrainer extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika tidak mengikuti konvensi jamak (plural)
    protected $table = 'personal_trainer';

    // Menentukan nama primary key jika bukan 'id'
    protected $primaryKey = 'id_personal_trainer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nama_personal_trainer',
        'jenis_kelamin',
        'no_telp',
    ];

    // Hubungan One-to-One (Inverse) dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Hubungan One-to-Many dengan Kartu
    public function kartu()
    {
        return $this->hasMany(kartu::class, 'id_personal_trainer', 'id_personal_trainer');
    }
}