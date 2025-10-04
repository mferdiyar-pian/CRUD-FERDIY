<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('user.peminjaman.index');
});

// ================================
// ROUTES UNTUK USER
// ================================

// Route untuk peminjaman user
Route::prefix('peminjaman')->group(function () {
    Route::get('/', [PeminjamanController::class, 'index'])->name('user.peminjaman.index');
    Route::get('/create', [PeminjamanController::class, 'create'])->name('user.peminjaman.create');
    Route::post('/', [PeminjamanController::class, 'store'])->name('user.peminjaman.store');
    Route::get('/{id}', [PeminjamanController::class, 'show'])->name('user.peminjaman.show');
    Route::get('/{id}/edit', [PeminjamanController::class, 'edit'])->name('user.peminjaman.edit');
    Route::put('/{id}', [PeminjamanController::class, 'update'])->name('user.peminjaman.update');
    Route::delete('/{id}', [PeminjamanController::class, 'destroy'])->name('user.peminjaman.destroy');
    Route::get('/riwayat/user', [PeminjamanController::class, 'riwayat'])->name('user.peminjaman.riwayat');
});

// Route untuk pengembalian user
Route::prefix('pengembalian')->group(function () {
    Route::get('/', [PeminjamanController::class, 'pengembalianUser'])->name('user.pengembalian.index');
    Route::get('/{id}', [PeminjamanController::class, 'showPengembalian'])->name('user.pengembalian.show');
    Route::post('/{id}/ajukan', [PeminjamanController::class, 'ajukanPengembalian'])->name('user.pengembalian.ajukan');
});

// ================================
// ROUTES UNTUK ADMIN
// ================================

Route::prefix('admin')->group(function () {
    // Dashboard - redirect ke peminjaman
    Route::get('/dashboard', [AdminController::class, 'peminjaman'])->name('admin.dashboard');
    Route::get('/', [AdminController::class, 'peminjaman'])->name('admin.home');
    
    // Route peminjaman admin
    Route::prefix('peminjaman')->group(function () {
        Route::get('/', [AdminController::class, 'peminjaman'])->name('admin.peminjaman.index');
        Route::post('/', [AdminController::class, 'store'])->name('admin.peminjaman.store');
        Route::put('/{id}/approve', [AdminController::class, 'approve'])->name('admin.peminjaman.approve');
        Route::put('/{id}/reject', [AdminController::class, 'reject'])->name('admin.peminjaman.reject');
        Route::put('/{id}/complete', [AdminController::class, 'complete'])->name('admin.peminjaman.complete');
        Route::put('/{id}', [AdminController::class, 'update'])->name('admin.peminjaman.update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.peminjaman.destroy');
    });
    
    // Route pengembalian admin
    Route::prefix('pengembalian')->group(function () {
        Route::get('/', [AdminController::class, 'pengembalian'])->name('admin.pengembalian');
        Route::post('/', [AdminController::class, 'storePengembalian'])->name('admin.pengembalian.store');
        Route::put('/{id}/kembalikan', [AdminController::class, 'prosesPengembalian'])->name('admin.pengembalian.kembalikan');
        Route::delete('/{id}', [AdminController::class, 'destroyPengembalian'])->name('admin.pengembalian.destroy');
    });
    
    // Route riwayat admin
    Route::prefix('riwayat')->group(function () {
        Route::get('/', [AdminController::class, 'riwayat'])->name('admin.riwayat');
        Route::put('/{id}', [AdminController::class, 'updateRiwayat'])->name('admin.riwayat.update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.riwayat.destroy');
    });
});