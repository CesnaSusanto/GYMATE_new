<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika tidak mengikuti konvensi jamak (plural)
    protected $table = 'catatan';

    // Menentukan nama primary key jika bukan 'id'
    protected $primaryKey = 'id_catatan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_pelanggan',
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

    // Hubungan Many-to-One (Inverse) dengan Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}