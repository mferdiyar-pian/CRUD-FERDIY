<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id() ?? 1;
        $query = Peminjaman::where('user_id', $userId);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('keperluan', 'like', "%{$search}%")
                  ->orWhere('ruang', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('user.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        return view('user.peminjaman.create');
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
            'user_id'   => auth()->id() ?? 1,
            'tanggal'   => $request->tanggal,
            'ruang'     => $request->ruang,
            'proyektor' => $request->proyektor,
            'keperluan' => $request->keperluan,
            'status'    => 'pending',
        ]);

        return redirect()->route('user.peminjaman.index')->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        $userId = auth()->id() ?? 1;
        $peminjaman = Peminjaman::where('user_id', $userId)->findOrFail($id);
        return view('user.peminjaman.show', compact('peminjaman'));
    }

    public function edit($id)
    {
        $userId = auth()->id() ?? 1;
        $peminjaman = Peminjaman::where('user_id', $userId)->findOrFail($id);
        return view('user.peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'ruang'     => 'required|string|max:100',
            'proyektor' => 'required|boolean',
            'keperluan' => 'required|string|max:255',
        ]);

        $userId = auth()->id() ?? 1;
        $peminjaman = Peminjaman::where('user_id', $userId)->findOrFail($id);

        $peminjaman->update([
            'tanggal'   => $request->tanggal,
            'ruang'     => $request->ruang,
            'proyektor' => $request->proyektor,
            'keperluan' => $request->keperluan,
        ]);

        return redirect()->route('user.peminjaman.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $userId = auth()->id() ?? 1;
        $peminjaman = Peminjaman::where('user_id', $userId)->findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('user.peminjaman.index')->with('success', 'Data berhasil dihapus');
    }

    public function riwayat(Request $request)
    {
        $userId = auth()->id() ?? 1;
        $query = Peminjaman::where('user_id', $userId);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('keperluan', 'like', "%{$search}%")
                  ->orWhere('ruang', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $riwayat = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('user.peminjaman.riwayat', compact('riwayat'));
    }

    public function pengembalianUser(Request $request)
    {
        $userId = auth()->id() ?? 1;
        
        $query = Peminjaman::where('user_id', $userId)
                          ->where('status', 'disetujui')
                          ->whereDate('tanggal', '<=', Carbon::now());

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('keperluan', 'like', "%{$search}%")
                  ->orWhere('ruang', 'like', "%{$search}%");
            });
        }

        $peminjamans = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('user.pengembalian.index', compact('peminjamans'));
    }

    public function ajukanPengembalian($id)
    {
        try {
            $userId = auth()->id() ?? 1;
            $peminjaman = Peminjaman::where('user_id', $userId)
                                   ->where('status', 'disetujui')
                                   ->findOrFail($id);
            
            $peminjaman->update([
                'status' => 'selesai',
                'tanggal_kembali' => Carbon::now()
            ]);

            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tanggal_pengembalian' => Carbon::now(),
                'kondisi_ruangan' => 'baik',
                'kondisi_proyektor' => $peminjaman->proyektor ? 'baik' : 'tidak_ada',
                'keterangan' => 'Pengembalian oleh user',
                'status' => 'dikembalikan',
            ]);

            return redirect()->route('user.pengembalian.index')->with('success', 'Pengembalian berhasil diajukan.');
                
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function showPengembalian($id)
    {
        $userId = auth()->id() ?? 1;
        $peminjaman = Peminjaman::where('user_id', $userId)->findOrFail($id);
        
        return view('user.pengembalian.show', compact('peminjaman'));
    }
}