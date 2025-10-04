<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengembalian;
use Carbon\Carbon;

class PengembalianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengembalian::create([
            'user_id' => 1,
            'ruang' => 'Ruang A',
            'proyektor' => true,
            'tanggal_pinjam' => Carbon::now()->subDays(2),
            'tanggal_kembali' => null,
            'status' => 'belum_dikembalikan',
            'catatan' => 'Kondisi: Baik'
        ]);
        
        Pengembalian::create([
            'user_id' => 1,
            'ruang' => 'Ruang B',
            'proyektor' => false,
            'tanggal_pinjam' => Carbon::now()->subDays(5),
            'tanggal_kembali' => Carbon::now()->subDays(1),
            'status' => 'dikembalikan',
            'catatan' => 'Kondisi: Baik. Pengembalian tepat waktu'
        ]);

        Pengembalian::create([
            'user_id' => 1,
            'ruang' => 'Ruang C',
            'proyektor' => true,
            'tanggal_pinjam' => Carbon::now()->subDays(10),
            'tanggal_kembali' => Carbon::now()->subDays(8),
            'status' => 'terlambat',
            'catatan' => 'Kondisi: Rusak Ringan. Terlambat 2 hari'
        ]);
    }
}