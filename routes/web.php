<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('peminjaman.index');
});

// Route untuk peminjaman (user)
Route::prefix('peminjaman')->group(function () {
    Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('/{id}', [PeminjamanController::class, 'delete'])->name('peminjaman.delete');
    Route::get('/riwayat/user', [PeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
});

// Routes untuk Admin
Route::prefix('admin')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Halaman pengembalian
    Route::get('/pengembalian', [AdminController::class, 'pengembalian'])->name('admin.pengembalian');
    
    // Riwayat peminjaman
    Route::get('/riwayat', [AdminController::class, 'riwayat'])->name('admin.riwayat');
    
    // Manajemen peminjaman
    Route::prefix('peminjaman')->group(function () {
        Route::post('/', [AdminController::class, 'store'])->name('admin.peminjaman.store');
        Route::put('/{id}/approve', [AdminController::class, 'approve'])->name('admin.peminjaman.approve');
        Route::put('/{id}/reject', [AdminController::class, 'reject'])->name('admin.peminjaman.reject');
        Route::put('/{id}', [AdminController::class, 'update'])->name('admin.peminjaman.update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.peminjaman.destroy');
        // Di web.php
// Ganti dari PUT menjadi POST
Route::post('/admin/peminjaman/{id}/complete', [AdminController::class, 'complete'])
    ->name('admin.peminjaman.complete');
    
        // Route untuk memindahkan ke riwayat
        Route::post('/{id}/complete', [AdminController::class, 'complete'])->name('admin.peminjaman.complete');
        Route::post('/{id}/return', [AdminController::class, 'return'])->name('admin.peminjaman.return');
        Route::post('/{id}/cancel', [AdminController::class, 'cancel'])->name('admin.peminjaman.cancel');
    });
    
    // Manajemen pengembalian
    Route::prefix('pengembalian')->group(function () {
        Route::post('/', [AdminController::class, 'storePengembalian'])->name('admin.pengembalian.store');
        Route::put('/{id}/kembalikan', [AdminController::class, 'prosesPengembalian'])->name('admin.pengembalian.kembalikan');
        Route::delete('/{id}', [AdminController::class, 'destroyPengembalian'])->name('admin.pengembalian.destroy');
    });
    
    // Manajemen riwayat
    Route::prefix('riwayat')->group(function () {
        Route::post('/{id}/overdue', [AdminController::class, 'markOverdue'])->name('admin.riwayat.overdue');
    });
});