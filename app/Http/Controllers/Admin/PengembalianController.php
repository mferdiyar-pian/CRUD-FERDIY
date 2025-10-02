<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengembalian::with(['user', 'peminjaman', 'admin'])
            ->latest();

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('peminjaman', function($q) use ($search) {
                $q->where('ruang', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter tanggal
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('tanggal_kembali', $request->date);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'due_date':
                $query->orderBy('tanggal_kembali');
                break;
            default:
                $query->latest();
        }

        $pengembalians = $query->paginate(10);

        // Stats untuk dashboard
        $stats = [
            'pending' => Pengembalian::pending()->count(),
            'disetujui' => Pengembalian::disetujui()->count(),
            'ditolak' => Pengembalian::ditolak()->count(),
            'total' => Pengembalian::count(),
        ];

        // Peminjaman aktif untuk form tambah
        $peminjamansAktif = Peminjaman::where('status', 'disetujui')
            ->whereDoesntHave('pengembalian')
            ->with('user')
            ->get();

        return view('admin.pengembalian', compact('pengembalians', 'stats', 'peminjamansAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'kondisi_barang' => 'required|in:baik,rusak_ringan,rusak_berat',
            'keterangan' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

            $pengembalian = Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'user_id' => $peminjaman->user_id,
                'tanggal_kembali' => now(),
                'kondisi_barang' => $request->kondisi_barang,
                'keterangan' => $request->keterangan,
                'status' => 'pending',
                'denda' => 0, // Akan dihitung otomatis nanti
            ]);

            // Update status peminjaman
            $peminjaman->update(['status' => 'diproses_pengembalian']);

            DB::commit();

            return redirect()->route('admin.pengembalian')
                ->with('success', 'Pengembalian berhasil diajukan dan menunggu konfirmasi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $pengembalian = Pengembalian::with('peminjaman')->findOrFail($id);
            
            // Hitung denda
            $denda = $pengembalian->hitungDenda();

            $pengembalian->update([
                'status' => 'disetujui',
                'denda' => $denda,
                'admin_id' => auth()->id(),
                'catatan_admin' => 'Pengembalian disetujui secara otomatis'
            ]);

            // Update status peminjaman menjadi selesai
            $pengembalian->peminjaman->update(['status' => 'selesai']);

            DB::commit();

            return redirect()->route('admin.pengembalian')
                ->with('success', 'Pengembalian berhasil disetujui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $pengembalian = Pengembalian::with('peminjaman')->findOrFail($id);

            $pengembalian->update([
                'status' => 'ditolak',
                'admin_id' => auth()->id(),
                'catatan_admin' => $request->catatan_admin
            ]);

            // Kembalikan status peminjaman ke disetujui
            $pengembalian->peminjaman->update(['status' => 'disetujui']);

            DB::commit();

            return redirect()->route('admin.pengembalian')
                ->with('success', 'Pengembalian berhasil ditolak.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pengembalian = Pengembalian::with(['user', 'peminjaman', 'admin'])->findOrFail($id);
        
        return response()->json($pengembalian);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kondisi_barang' => 'required|in:baik,rusak_ringan,rusak_berat',
            'keterangan' => 'nullable|string|max:500',
            'tanggal_kembali' => 'required|date',
        ]);

        try {
            $pengembalian = Pengembalian::findOrFail($id);

            $pengembalian->update([
                'kondisi_barang' => $request->kondisi_barang,
                'keterangan' => $request->keterangan,
                'tanggal_kembali' => $request->tanggal_kembali,
            ]);

            return redirect()->route('admin.pengembalian')
                ->with('success', 'Data pengembalian berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $pengembalian = Pengembalian::with('peminjaman')->findOrFail($id);

            // Kembalikan status peminjaman ke semula
            if ($pengembalian->peminjaman) {
                $pengembalian->peminjaman->update(['status' => 'disetujui']);
            }

            $pengembalian->delete();

            DB::commit();

            return redirect()->route('admin.pengembalian')
                ->with('success', 'Data pengembalian berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // API untuk mendapatkan detail pengembalian
    public function getDetail($id)
    {
        $pengembalian = Pengembalian::with(['user', 'peminjaman', 'admin'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $pengembalian
        ]);
    }
}