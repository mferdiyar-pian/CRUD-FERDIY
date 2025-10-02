<?php
// app/Http/Controllers/Admin/PeminjamanController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar dengan eager loading
        $query = Peminjaman::with('user');
        
        // Pencarian berdasarkan nama peminjam
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })->orWhere('keperluan', 'like', "%{$search}%")
                  ->orWhere('ruang', 'like', "%{$search}%");
            });
        }
        
        // Filter berdasarkan status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('tanggal', $request->date);
        }
        
        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('tanggal', 'asc')->orderBy('created_at', 'asc');
                break;
            case 'return':
                $query->orderBy('tanggal_pengembalian', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc')->orderBy('tanggal', 'desc');
                break;
        }
        
        // Debug query (bisa dihapus setelah testing)
        // \Log::info('Filter parameters:', $request->all());
        // \Log::info('SQL Query:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
        
        $peminjamans = $query->paginate(10)->appends($request->except('page'));
        
        // Hitung statistik (harus sesuai dengan filter juga)
        $statsQuery = Peminjaman::query();
        
        // Terapkan filter yang sama untuk statistik
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $statsQuery->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })->orWhere('keperluan', 'like', "%{$search}%")
                  ->orWhere('ruang', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('date') && !empty($request->date)) {
            $statsQuery->whereDate('tanggal', $request->date);
        }
        
        $pendingCount = clone $statsQuery;
        $approvedCount = clone $statsQuery;
        $rejectedCount = clone $statsQuery;
        $totalCount = clone $statsQuery;
        
        $pendingCount = $pendingCount->where('status', 'pending')->count();
        $approvedCount = $approvedCount->where('status', 'disetujui')->count();
        $rejectedCount = $rejectedCount->where('status', 'ditolak')->count();
        $totalCount = $totalCount->count();
        
        return view('admin.peminjaman.index', compact(
            'peminjamans', 
            'pendingCount', 
            'approvedCount', 
            'rejectedCount', 
            'totalCount'
        ));
    }
}