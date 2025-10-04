<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::all();
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        return view('peminjaman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'ruang'     => 'required|string|max:100',
            'proyektor' => 'required|boolean',
            'keperluan' => 'required|string|max:255',
        ]);

        Peminjaman::create([
            'user_id'   => auth()->id() ?? 1, // sementara default 1
            'tanggal'   => $request->tanggal,
            'ruang'     => $request->ruang,
            'proyektor' => $request->proyektor,
            'keperluan' => $request->keperluan,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        return view('peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'ruang'     => 'required|string|max:100',
            'proyektor' => 'required|boolean',
            'keperluan' => 'required|string|max:255',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'tanggal'   => $request->tanggal,
            'ruang'     => $request->ruang,
            'proyektor' => $request->proyektor,
            'keperluan' => $request->keperluan,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil dihapus');
    }

    public function riwayat()
    {
        $riwayat = Peminjaman::where('user_id', auth()->id() ?? 1)
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view('peminjaman.riwayat', compact('riwayat'));
    }

    /**
     * Menampilkan halaman pengembalian untuk user
     */
    public function pengembalianUser(Request $request)
    {
        $user = auth()->user();
        $userId = $user ? $user->id : 1; // Fallback untuk testing
        
        $query = Pengembalian::where('user_id', $userId);
        
        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ruang', 'like', "%{$search}%")
                  ->orWhere('catatan', 'like', "%{$search}%");
            });
        }
        
        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter ruang
        if ($request->has('ruang') && $request->ruang != 'semua') {
            $query->where('ruang', $request->ruang);
        }
        
        // Sorting
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;
            case 'tanggal_pinjam':
                $query->orderBy('tanggal_pinjam', 'desc');
                break;
            case 'tanggal_kembali':
                $query->orderBy('tanggal_kembali', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        $pengembalians = $query->paginate(10);
        
        // Hitung statistik
        $pendingReturns = Pengembalian::where('user_id', $userId)
            ->where('status', 'belum_dikembalikan')->count();
        $returnedCount = Pengembalian::where('user_id', $userId)
            ->where('status', 'dikembalikan')->count();
        $overdueCount = Pengembalian::where('user_id', $userId)
            ->where('status', 'terlambat')->count();
        $totalReturns = Pengembalian::where('user_id', $userId)->count();
        
        return view('pengembalian.index', compact(
            'pengembalians',
            'pendingReturns',
            'returnedCount',
            'overdueCount',
            'totalReturns'
        ));
    }

    /**
     * Method untuk mengajukan pengembalian oleh user
     */
    public function ajukanPengembalian(Request $request, $id)
    {
        $request->validate([
            'kondisi_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'keterangan' => 'nullable|string|max:500'
        ]);

        try {
            $pengembalian = Pengembalian::findOrFail($id);
            
            // Pastikan pengembalian milik user yang login
            $userId = auth()->id() ?? 1;
            if ($pengembalian->user_id != $userId) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengajukan pengembalian ini.');
            }
            
            // Update data pengembalian
            $pengembalian->tanggal_kembali = Carbon::now();
            $pengembalian->status = 'dikembalikan';
            $pengembalian->catatan = "Kondisi: {$request->kondisi_barang}. " . ($request->keterangan ?? '');
            $pengembalian->save();
            
            // Update status peminjaman terkait jika ada
            if ($pengembalian->peminjaman) {
                $pengembalian->peminjaman->status = 'selesai';
                $pengembalian->peminjaman->save();
            }

            return redirect()->route('pengembalian.user')
                ->with('success', 'Pengembalian berhasil diajukan. Menunggu konfirmasi admin.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Method untuk melihat detail pengembalian
     */
    public function showPengembalian($id)
    {
        $pengembalian = Pengembalian::with(['user', 'peminjaman'])
            ->findOrFail($id);
            
        // Pastikan user hanya bisa melihat pengembalian miliknya sendiri
        $userId = auth()->id() ?? 1;
        if ($pengembalian->user_id != $userId) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('pengembalian.show', compact('pengembalian'));
    }
}