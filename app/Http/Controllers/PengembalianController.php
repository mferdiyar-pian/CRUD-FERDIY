<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pengembalian::with(['peminjaman', 'peminjaman.user']);

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('peminjaman', function($peminjamanQuery) use ($search) {
                    $peminjamanQuery->where('ruang', 'like', "%{$search}%")
                                   ->orWhere('keperluan', 'like', "%{$search}%")
                                   ->orWhereHas('user', function($userQuery) use ($search) {
                                       $userQuery->where('name', 'like', "%{$search}%");
                                   });
                });
            });
        }

        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pengembalians = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $peminjamans = Peminjaman::where('status', 'disetujui')
                                ->whereDoesntHave('pengembalian')
                                ->get();
        return view('admin.pengembalian.create', compact('peminjamans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tanggal_pengembalian' => 'required|date',
            'kondisi_ruangan' => 'required|in:baik,rusak_ringan,rusak_berat',
            'kondisi_proyektor' => 'required|in:baik,rusak_ringan,rusak_berat,tidak_ada',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Cek apakah peminjaman sudah memiliki pengembalian
        $existingPengembalian = Pengembalian::where('peminjaman_id', $request->peminjaman_id)->first();
        if ($existingPengembalian) {
            return redirect()->back()->with('error', 'Peminjaman ini sudah memiliki data pengembalian.');
        }

        Pengembalian::create([
            'peminjaman_id' => $request->peminjaman_id,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'kondisi_ruangan' => $request->kondisi_ruangan,
            'kondisi_proyektor' => $request->kondisi_proyektor,
            'keterangan' => $request->keterangan,
            'status' => 'dikembalikan',
        ]);

        // Update status peminjaman
        $peminjaman = Peminjaman::find($request->peminjaman_id);
        $peminjaman->update([
            'status' => 'selesai',
            'tanggal_kembali' => $request->tanggal_pengembalian
        ]);

        return redirect()->route('admin.pengembalian.index')->with('success', 'Data pengembalian berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengembalian = Pengembalian::with(['peminjaman', 'peminjaman.user'])->findOrFail($id);
        return view('admin.pengembalian.show', compact('pengembalian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $peminjamans = Peminjaman::where('status', 'disetujui')->get();
        return view('admin.pengembalian.edit', compact('pengembalian', 'peminjamans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pengembalian' => 'required|date',
            'kondisi_ruangan' => 'required|in:baik,rusak_ringan,rusak_berat',
            'kondisi_proyektor' => 'required|in:baik,rusak_ringan,rusak_berat,tidak_ada',
            'keterangan' => 'nullable|string|max:500',
            'status' => 'required|in:dikembalikan,terlambat,belum_dikembalikan',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->update([
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'kondisi_ruangan' => $request->kondisi_ruangan,
            'kondisi_proyektor' => $request->kondisi_proyektor,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        // Update status peminjaman jika status pengembalian berubah
        if ($request->status == 'dikembalikan') {
            $peminjaman = $pengembalian->peminjaman;
            $peminjaman->update([
                'status' => 'selesai',
                'tanggal_kembali' => $request->tanggal_pengembalian
            ]);
        }

        return redirect()->route('admin.pengembalian.index')->with('success', 'Data pengembalian berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        
        // Reset status peminjaman
        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update([
            'status' => 'disetujui',
            'tanggal_kembali' => null
        ]);
        
        $pengembalian->delete();

        return redirect()->route('admin.pengembalian.index')->with('success', 'Data pengembalian berhasil dihapus.');
    }

    /**
     * Proses pengembalian oleh admin
     */
    public function prosesPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Buat record pengembalian
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_pengembalian' => Carbon::now(),
            'kondisi_ruangan' => 'baik',
            'kondisi_proyektor' => $peminjaman->proyektor ? 'baik' : 'tidak_ada',
            'keterangan' => 'Pengembalian diproses oleh admin',
            'status' => 'dikembalikan',
        ]);

        // Update status peminjaman
        $peminjaman->update([
            'status' => 'selesai',
            'tanggal_kembali' => Carbon::now()
        ]);

        return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian berhasil diproses.');
    }
}