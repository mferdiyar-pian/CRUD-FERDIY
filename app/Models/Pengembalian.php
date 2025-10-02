<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'peminjaman_id',
        'user_id',
        'tanggal_kembali',
        'kondisi_barang',
        'keterangan',
        'status',
        'denda',
        'admin_id'
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
        'denda' => 'decimal:2'
    ];

    // Relasi dengan peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    // Relasi dengan user yang mengembalikan
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan admin yang memproses
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Scope untuk status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    // Accessor untuk status label
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'Menunggu Konfirmasi',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    // Hitung denda otomatis
    public function hitungDenda()
    {
        if (!$this->peminjaman) return 0;

        $tanggalJatuhTempo = $this->peminjaman->tanggal_jatuh_tempo;
        $tanggalKembali = $this->tanggal_kembali;

        if ($tanggalKembali > $tanggalJatuhTempo) {
            $selisihHari = $tanggalJatuhTempo->diffInDays($tanggalKembali);
            // Contoh: denda Rp 10.000 per hari
            return $selisihHari * 10000;
        }

        return 0;
    }
}