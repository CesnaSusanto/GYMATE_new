<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kartu extends Model
{
    use HasFactory;

    protected $table = 'kartu'; // Pastikan sesuai dengan nama tabel Anda
    protected $primaryKey = 'id_kartu'; // Pastikan ini sesuai dengan PK di skema
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_pelanggan',
        'id_personal_trainer',
        'tanggal_latihan',
        'kegiatan_latihan',
        'catatan_latihan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_latihan' => 'date', // Otomatis cast ke objek Carbon
    ];

    // Hubungan Many-to-One (Inverse) dengan PersonalTrainer
    public function personalTrainer()
    {
        return $this->belongsTo(PersonalTrainer::class, 'id_personal_trainer', 'id_personal_trainer');
    }

    // Hubungan Many-to-One (Inverse) dengan Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}
