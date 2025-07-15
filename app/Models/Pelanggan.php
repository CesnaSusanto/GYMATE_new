<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'id_personal_trainer',
        'nama_pelanggan',
        'jenis_kelamin',
        'no_telp',
        'tanggal_bergabung',
        'paket_layanan',
        'berat_badan',
        'tinggi_badan',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_bergabung' => 'date', // Otomatis cast ke objek Carbon
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function personalTrainer()
    {
        return $this->belongsTo(PersonalTrainer::class, 'id_personal_trainer', 'id_personal_trainer');
    }

    public function catatan()
    {
        return $this->hasMany(Catatan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function kartu()
    {
        return $this->hasMany(Kartu::class, 'id_pelanggan', 'id_pelanggan');
    }

}
