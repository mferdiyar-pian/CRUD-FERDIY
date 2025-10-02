<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        Peminjaman::create([
           'user_id' => 1, // sesuaikan dengan ID user yang ada
            'tanggal' => now(),
            'ruang' => 'Lab Komputer',
            'proyektor' => true,
            'keperluan' => 'Presentasi Proyek',
            'status' => 'pending',
        ]);
        $this->call(PeminjamanSeeder::class);
    }
}
