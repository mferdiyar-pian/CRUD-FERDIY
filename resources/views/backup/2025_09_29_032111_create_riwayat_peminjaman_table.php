<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('riwayat_peminjaman', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');
    $table->date('tanggal');
    $table->string('ruang');
    $table->boolean('proyektor')->default(false);
    $table->text('keperluan');
    $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_peminjaman');
    }
};
