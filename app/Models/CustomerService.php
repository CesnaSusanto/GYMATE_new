<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika tidak mengikuti konvensi jamak (plural)
    protected $table = 'customer_service';

    // Menentukan nama primary key jika bukan 'id'
    protected $primaryKey = 'id_cs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nama_cs',
    ];

    // Hubungan One-to-One (Inverse) dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
