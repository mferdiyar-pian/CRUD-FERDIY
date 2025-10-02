<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_pengembalian');
            $table->enum('kondisi_ruangan', ['baik', 'rusak_ringan', 'rusak_berat']);
            $table->enum('kondisi_proyektor', ['baik', 'rusak_ringan', 'rusak_berat', 'tidak_ada']);
            $table->text('keterangan')->nullable();
            $table->enum('status', ['dikembalikan', 'terlambat', 'belum_dikembalikan'])->default('belum_dikembalikan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};