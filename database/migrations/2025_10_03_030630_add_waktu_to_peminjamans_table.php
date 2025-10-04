<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->time('waktu_mulai')->after('ruang');   // tambahkan kolom setelah 'ruang'
            $table->time('waktu_selesai')->after('waktu_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn(['waktu_mulai', 'waktu_selesai']);
        });
    }
};
