<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Nama tabel di database (supaya tidak salah jadi 'peminjamen')
    protected $table = 'peminjamans';

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

    // Scope untuk riwayat
    public function scopeRiwayat($query)
    {
        return $query->whereIn('status', ['disetujui', 'ditolak', 'selesai'])
                    ->orWhereNotNull('returned_at');
    }

    // Scope untuk peminjaman aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'disetujui')
                    ->whereNull('returned_at');
    }
}
