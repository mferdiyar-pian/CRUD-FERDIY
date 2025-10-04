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
        'ruang',
        'proyektor',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'catatan'
    ];

    protected $casts = [
        'proyektor' => 'boolean',
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}