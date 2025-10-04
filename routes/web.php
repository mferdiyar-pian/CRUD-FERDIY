<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('peminjaman.index');
});

// Route untuk pengembalian user - DI LUAR PREFIX
Route::get('/pengembalian', [PeminjamanController::class, 'pengembalianUser'])->name('pengembalian.user');
Route::post('/pengembalian/{id}/ajukan', [PeminjamanController::class, 'ajukanPengembalian'])->name('pengembalian.ajukan');
Route::get('/pengembalian/{id}', [PeminjamanController::class, 'showPengembalian'])->name('pengembalian.show');

// Route untuk peminjaman (user)
Route::prefix('peminjaman')->group(function () {
    Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::post('/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update.post');
    Route::delete('/{id}', [PeminjamanController::class, 'delete'])->name('peminjaman.delete');
    Route::get('/riwayat/user', [PeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
});

// Routes untuk Admin
Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.home');
    
    // Route peminjaman admin
    Route::prefix('peminjaman')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.peminjaman.index');
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
    
    
    // Route riwayat admin dengan CRUD
   Route::prefix('riwayat')->group(function () {
        Route::get('/', [AdminController::class, 'riwayat'])->name('admin.riwayat');
        Route::put('/{id}', [AdminController::class, 'updateRiwayat'])->name('admin.riwayat.update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.riwayat.destroy');
   
        // Route lainnya
    Route::get('/riwayat', [AdminController::class, 'riwayat'])->name('admin.riwayat');
    });
});