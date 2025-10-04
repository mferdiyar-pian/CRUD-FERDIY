<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display halaman peminjaman admin (menggantikan dashboard)
     */
    public function peminjaman(Request $request)
    {
        // Query untuk statistik
        $pendingCount = Peminjaman::where('status', 'pending')->count();
        $approvedCount = Peminjaman::where('status', 'disetujui')->count();
        $rejectedCount = Peminjaman::where('status', 'ditolak')->count();
        $totalCount = Peminjaman::count();

        // Query untuk data peminjaman dengan filter
        $query = Peminjaman::with('user');

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('keperluan', 'like', "%{$search}%")
                ->orWhere('ruang', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter tanggal
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('tanggal', $request->date);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'return':
                $query->orderBy('tanggal_kembali', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $peminjamans = $query->paginate(10);

        return view('admin.peminjaman.index', compact(
            'peminjamans',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'totalCount'
        ));
    }

    /**
     * Display halaman pengembalian
     */
    public function pengembalian(Request $request)
    {
        $query = Peminjaman::where('status', 'disetujui')
                          ->whereDate('tanggal', '<=', Carbon::now());

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('keperluan', 'like', "%{$search}%")
                ->orWhere('ruang', 'like', "%{$search}%");
            });
        }

        $peminjamans = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('admin.pengembalian.index', compact('peminjamans'));
    }

    /**
     * Display riwayat peminjaman
     */
    public function riwayat(Request $request)
    {
        $query = Peminjaman::with('user');

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('keperluan', 'like', "%{$search}%")
                ->orWhere('ruang', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter tanggal dari
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('tanggal', '>=', $request->date_from);
        }

        // Filter tanggal sampai
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('tanggal', '<=', $request->date_to);
        }

        // Hitung statistik untuk riwayat
        $completedCount = Peminjaman::where('status', 'disetujui')->count();
        $cancelledCount = Peminjaman::where('status', 'ditolak')->count();
        $ongoingCount = Peminjaman::where('status', 'pending')->count();
        $totalCount = Peminjaman::count();

        $riwayat = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.riwayat.index', compact(
            'riwayat',
            'completedCount',
            'cancelledCount',
            'ongoingCount',
            'totalCount'
        ));
    }

    /**
     * Display daftar peminjaman untuk admin
     */
    public function index(Request $request)
    {
        return $this->peminjaman($request);
    }

    /**
     * Store new peminjaman from admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'peminjam' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'ruang' => 'required|string|max:100',
            'proyektor' => 'required|boolean',
            'keperluan' => 'required|string|max:500',
        ]);

        // Cari user berdasarkan nama atau buat guest user
        $user = User::where('name', $request->peminjam)->first();
        
        if (!$user) {
            // Jika user tidak ditemukan, buat guest user atau gunakan user default
            $user = User::first(); // atau handle sesuai kebutuhan
        }

        Peminjaman::create([
            'user_id' => $user->id,
            'tanggal' => $request->tanggal,
            'ruang' => $request->ruang,
            'proyektor' => $request->proyektor,
            'keperluan' => $request->keperluan,
            'status' => 'disetujui', // Otomatis disetujui jika dibuat admin
        ]);

        return redirect()->route('admin.peminjaman.index')
                        ->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Approve peminjaman
     */
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'disetujui']);

        return redirect()->route('admin.peminjaman.index')
                        ->with('success', 'Peminjaman berhasil disetujui.');
    }

    /**
     * Reject peminjaman
     */
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'ditolak']);

        return redirect()->route('admin.peminjaman.index')
                        ->with('success', 'Peminjaman berhasil ditolak.');
    }

    /**
     * Complete peminjaman (pengembalian)
     */
    public function complete($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'status' => 'selesai',
            'tanggal_kembali' => Carbon::now()
        ]);

        return redirect()->route('admin.pengembalian')
                        ->with('success', 'Peminjaman berhasil diselesaikan.');
    }

    /**
     * Update peminjaman
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'ruang' => 'required|string|max:100',
            'proyektor' => 'required|boolean',
            'keperluan' => 'required|string|max:500',
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->only(['tanggal', 'ruang', 'proyektor', 'keperluan', 'status']));

        return redirect()->route('admin.peminjaman.index')
                        ->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Delete peminjaman
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
                        ->with('success', 'Peminjaman berhasil dihapus.');
    }

    /**
     * Store pengembalian
     */
    public function storePengembalian(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'kondisi' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);
        $peminjaman->update([
            'status' => 'selesai',
            'tanggal_kembali' => Carbon::now(),
            'kondisi_kembali' => $request->kondisi,
            'keterangan_kembali' => $request->keterangan
        ]);

        return redirect()->route('admin.pengembalian')
                        ->with('success', 'Pengembalian berhasil dicatat.');
    }

    /**
     * Proses pengembalian
     */
    public function prosesPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'status' => 'selesai',
            'tanggal_kembali' => Carbon::now()
        ]);

        return redirect()->route('admin.pengembalian')
                        ->with('success', 'Pengembalian berhasil diproses.');
    }

    /**
     * Destroy pengembalian
     */
    public function destroyPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('admin.pengembalian')
                        ->with('success', 'Data pengembalian berhasil dihapus.');
    }

    /**
     * Update riwayat peminjaman
     */
    public function updateRiwayat(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'ruang' => 'required|string|max:100',
            'proyektor' => 'required|boolean',
            'keperluan' => 'required|string|max:500',
            'status' => 'required|in:pending,disetujui,ditolak,selesai',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->only(['tanggal', 'ruang', 'proyektor', 'keperluan', 'status']));

        return redirect()->route('admin.riwayat')
                        ->with('success', 'Riwayat peminjaman berhasil diperbarui.');
    }
}