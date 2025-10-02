<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'riwayat_peminjaman';
    
   // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'user_id',
        'tanggal',
        'ruang',
        'proyektor',
        'keperluan',
        'status',
    ];

    /**
     * Relasi ke User
     * Setiap peminjaman dimiliki oleh 1 user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}