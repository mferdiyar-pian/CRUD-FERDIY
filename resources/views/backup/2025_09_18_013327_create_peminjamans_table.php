<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('riwayat_peminjaman', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->date('tanggal_pinjam');
        $table->date('tanggal_kembali')->nullable();
        $table->string('ruang');
        $table->boolean('proyektor')->default(false);
        $table->text('keperluan');
        $table->enum('status', ['selesai', 'dikembalikan', 'terlambat', 'batal']);
        $table->text('catatan')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
