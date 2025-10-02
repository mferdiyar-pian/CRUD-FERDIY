<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\RiwayatPeminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Method dashboard untuk peminjaman aktif
    public function dashboard(Request $request)
    {
        $query = Peminjaman::with('user');

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhere('ruang', 'like', "%{$search}%")
                  ->orWhere('keperluan', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('tanggal', $request->date);
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'return':
                    $query->orderBy('tanggal', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $peminjamans = $query->paginate(10);
        
        $pendingCount = Peminjaman::where('status', 'pending')->count();
        $approvedCount = Peminjaman::where('status', 'disetujui')->count();
        $rejectedCount = Peminjaman::where('status', 'ditolak')->count();
        $totalCount = Peminjaman::count();

        return view('admin.dashboard', compact(
            'peminjamans', 
            'pendingCount', 
            'approvedCount', 
            'rejectedCount', 
            'totalCount'
        ));
    }

    // Method untuk halaman pengembalian
    public function pengembalian(Request $request)
    {
        try {
            // Query untuk data pengembalian (riwayat yang sudah dikembalikan)
            $query = RiwayatPeminjaman::with('user')
                ->whereIn('status', ['dikembalikan', 'selesai', 'terlambat']);

            // Filter berdasarkan pencarian
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->whereHas('user', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })->orWhere('ruang', 'like', "%{$search}%")
                      ->orWhere('keperluan', 'like', "%{$search}%")
                      ->orWhere('catatan', 'like', "%{$search}%");
                });
            }

            // Filter berdasarkan status
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            // Filter berdasarkan tanggal pengembalian
            if ($request->has('date') && $request->date != '') {
                $query->whereDate('tanggal_kembali', $request->date);
            }

            // Sorting
            if ($request->has('sort')) {
                switch ($request->sort) {
                    case 'oldest':
                        $query->orderBy('tanggal_kembali', 'asc');
                        break;
                    case 'due_date':
                        $query->orderBy('tanggal_pinjam', 'desc');
                        break;
                    default:
                        $query->orderBy('tanggal_kembali', 'desc');
                        break;
                }
            } else {
                $query->orderBy('tanggal_kembali', 'desc');
            }

            $pengembalians = $query->paginate(10);

            // Data peminjaman aktif untuk dropdown tambah pengembalian
            $peminjamansAktif = Peminjaman::with('user')
                ->where('status', 'disetujui')
                ->get();

            // Statistik untuk dashboard pengembalian
            $pendingReturns = Peminjaman::where('status', 'disetujui')->count();
            $returnedCount = RiwayatPeminjaman::where('status', 'dikembalikan')->count();
            $overdueCount = RiwayatPeminjaman::where('status', 'terlambat')->count();
            $totalReturns = RiwayatPeminjaman::whereIn('status', ['dikembalikan', 'selesai', 'terlambat'])->count();

            Log::info('📊 Halaman pengembalian dimuat - Total data: ' . $totalReturns);

            return view('admin.pengembalian', compact(
                'pengembalians',
                'peminjamansAktif',
                'pendingReturns',
                'returnedCount',
                'overdueCount',
                'totalReturns'
            ));

        } catch (\Exception $e) {
            Log::error('❌ Gagal memuat halaman pengembalian: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal memuat halaman pengembalian: ' . $e->getMessage());
        }
    }

    // Method untuk halaman riwayat peminjaman
    public function riwayat(Request $request)
    {
        try {
            // Debug: Cek total data riwayat
            $totalRiwayat = RiwayatPeminjaman::count();
            Log::info('🔍 DEBUG RIWAYAT - Total data: ' . $totalRiwayat);

            $query = RiwayatPeminjaman::with('user');
            
            // Filter berdasarkan pencarian
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->whereHas('user', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })->orWhere('ruang', 'like', "%{$search}%")
                      ->orWhere('keperluan', 'like', "%{$search}%")
                      ->orWhere('catatan', 'like', "%{$search}%");
                });
            }
            
            // Filter berdasarkan status
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }
            
            // Filter berdasarkan tanggal mulai
            if ($request->has('date_from') && $request->date_from != '') {
                $query->whereDate('tanggal_pinjam', '>=', $request->date_from);
            }
            
            // Filter berdasarkan tanggal selesai
            if ($request->has('date_to') && $request->date_to != '') {
                $query->whereDate('tanggal_pinjam', '<=', $request->date_to);
            }
            
            // Urutkan berdasarkan terbaru
            $riwayat = $query->orderBy('created_at', 'desc')->paginate(10);
            
            // Statistik untuk riwayat
            $completedCount = RiwayatPeminjaman::where('status', 'selesai')->count();
            $returnedCount = RiwayatPeminjaman::where('status', 'dikembalikan')->count();
            $overdueCount = RiwayatPeminjaman::where('status', 'terlambat')->count();
            $cancelledCount = RiwayatPeminjaman::where('status', 'batal')->count();
            $totalCount = RiwayatPeminjaman::count();

            // Debug: Log statistik
            Log::info('📊 STATISTIK RIWAYAT - Selesai: ' . $completedCount . ', Dikembalikan: ' . $returnedCount . ', Total: ' . $totalCount);
            
            return view('admin.riwayat', compact(
                'riwayat', 
                'completedCount', 
                'returnedCount', 
                'overdueCount',
                'cancelledCount',
                'totalCount'
            ));

        } catch (\Exception $e) {
            Log::error('❌ ERROR di halaman riwayat: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal memuat halaman riwayat: ' . $e->getMessage());
        }
    }

    // Method approve peminjaman
    public function approve($id)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id);
            $peminjaman->update(['status' => 'disetujui']);

            Log::info('✅ Peminjaman disetujui - ID: ' . $id);
            return redirect()->route('admin.dashboard')
                ->with('success', 'Peminjaman berhasil disetujui');

        } catch (\Exception $e) {
            Log::error('❌ Gagal menyetujui peminjaman: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal menyetujui peminjaman');
        }
    }

    // Method reject peminjaman
    public function reject($id)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id);
            $peminjaman->update(['status' => 'ditolak']);

            Log::info('❌ Peminjaman ditolak - ID: ' . $id);
            return redirect()->route('admin.dashboard')
                ->with('success', 'Peminjaman berhasil ditolak');

        } catch (\Exception $e) {
            Log::error('❌ Gagal menolak peminjaman: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal menolak peminjaman');
        }
    }

    // Method untuk menyelesaikan peminjaman (pindah ke riwayat)
    public function complete(Request $request, $id)
    {
        try {
            // Cari peminjaman dengan data user
            $peminjaman = Peminjaman::with('user')->findOrFail($id);
            
            // Debug: Log data sebelum dipindahkan
            Log::info('🔄 MEMINDAHKAN KE RIWAYAT - Peminjaman ID: ' . $peminjaman->id);
            Log::info('👤 User ID: ' . $peminjaman->user_id . ', Nama: ' . ($peminjaman->user->name ?? 'Tidak Diketahui'));

            // Validasi
            $request->validate([
                'catatan' => 'nullable|string|max:500'
            ]);

            // Pindahkan ke riwayat
            $riwayat = RiwayatPeminjaman::create([
                'user_id' => $peminjaman->user_id,
                'tanggal_pinjam' => $peminjaman->tanggal,
                'tanggal_kembali' => now(),
                'ruang' => $peminjaman->ruang,
                'proyektor' => $peminjaman->proyektor,
                'keperluan' => $peminjaman->keperluan,
                'status' => 'selesai',
                'catatan' => $request->catatan ?? 'Peminjaman selesai - ' . ($peminjaman->user->name ?? 'Tidak Diketahui')
            ]);

            // Debug: Log data setelah dibuat di riwayat
            Log::info('✅ RIWAYAT DIBUAT - ID: ' . $riwayat->id . ', User ID: ' . $riwayat->user_id);

            // Hapus dari tabel peminjaman aktif
            $peminjaman->delete();

            Log::info('🗑️ Peminjaman dihapus - ID: ' . $id);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Peminjaman telah diselesaikan dan dipindahkan ke riwayat.');

        } catch (\Exception $e) {
            Log::error('❌ Gagal memindahkan ke riwayat: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal memindahkan peminjaman ke riwayat: ' . $e->getMessage());
        }
    }

    // Method untuk mengembalikan barang (pindah ke riwayat dengan status dikembalikan)
    public function return(Request $request, $id)
    {
        try {
            $peminjaman = Peminjaman::with('user')->findOrFail($id);
            
            $request->validate([
                'catatan' => 'nullable|string|max:500'
            ]);

            // Debug
            Log::info('🔄 MENGEMBALIKAN BARANG - Peminjaman ID: ' . $peminjaman->id);

            // Pindahkan ke riwayat dengan status dikembalikan
            $riwayat = RiwayatPeminjaman::create([
                'user_id' => $peminjaman->user_id,
                'tanggal_pinjam' => $peminjaman->tanggal,
                'tanggal_kembali' => now(),
                'ruang' => $peminjaman->ruang,
                'proyektor' => $peminjaman->proyektor,
                'keperluan' => $peminjaman->keperluan,
                'status' => 'dikembalikan',
                'catatan' => $request->catatan ?? 'Barang telah dikembalikan - ' . ($peminjaman->user->name ?? 'Tidak Diketahui')
            ]);

            // Hapus dari tabel peminjaman aktif
            $peminjaman->delete();

            Log::info('✅ Barang dikembalikan - Riwayat ID: ' . $riwayat->id);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Barang telah dikembalikan dan peminjaman dipindahkan ke riwayat.');

        } catch (\Exception $e) {
            Log::error('❌ Gagal mengembalikan barang: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal mengembalikan barang: ' . $e->getMessage());
        }
    }

    // Method update untuk edit peminjaman
    public function update(Request $request, $id)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id);
            
            $request->validate([
                'tanggal' => 'required|date',
                'ruang' => 'required|string',
                'keperluan' => 'required|string',
                'status' => 'required|in:pending,disetujui,ditolak'
            ]);

            $peminjaman->update([
                'tanggal' => $request->tanggal,
                'ruang' => $request->ruang,
                'proyektor' => $request->proyektor == '1',
                'keperluan' => $request->keperluan,
                'status' => $request->status
            ]);

            Log::info('✏️ Peminjaman diperbarui - ID: ' . $id);
            return redirect()->route('admin.dashboard')
                ->with('success', 'Peminjaman berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('❌ Gagal memperbarui peminjaman: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal memperbarui peminjaman');
        }
    }

    // Method destroy untuk hapus peminjaman
    public function destroy($id)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id);
            $peminjaman->delete();

            Log::info('🗑️ Peminjaman dihapus - ID: ' . $id);
            return redirect()->route('admin.dashboard')
                ->with('success', 'Peminjaman berhasil dihapus');

        } catch (\Exception $e) {
            Log::error('❌ Gagal menghapus peminjaman: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal menghapus peminjaman');
        }
    }

    // Method untuk membatalkan peminjaman (pindah ke riwayat dengan status batal)
    public function cancel(Request $request, $id)
    {
        try {
            $peminjaman = Peminjaman::with('user')->findOrFail($id);
            
            $request->validate([
                'catatan' => 'required|string|max:500'
            ]);

            // Pindahkan ke riwayat dengan status batal
            $riwayat = RiwayatPeminjaman::create([
                'user_id' => $peminjaman->user_id,
                'tanggal_pinjam' => $peminjaman->tanggal,
                'tanggal_kembali' => now(),
                'ruang' => $peminjaman->ruang,
                'proyektor' => $peminjaman->proyektor,
                'keperluan' => $peminjaman->keperluan,
                'status' => 'batal',
                'catatan' => $request->catatan . ' - User: ' . ($peminjaman->user->name ?? 'Tidak Diketahui')
            ]);

            // Hapus dari tabel peminjaman aktif
            $peminjaman->delete();

            Log::info('❌ Peminjaman dibatalkan - Riwayat ID: ' . $riwayat->id);
            return redirect()->route('admin.dashboard')
                ->with('success', 'Peminjaman telah dibatalkan dan dipindahkan ke riwayat.');

        } catch (\Exception $e) {
            Log::error('❌ Gagal membatalkan peminjaman: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal membatalkan peminjaman: ' . $e->getMessage());
        }
    }

    // Method untuk menandai peminjaman terlambat di riwayat
    public function markOverdue($id)
    {
        try {
            $riwayat = RiwayatPeminjaman::findOrFail($id);
            $riwayat->update([
                'status' => 'terlambat',
                'catatan' => 'Peminjaman terlambat dikembalikan'
            ]);

            Log::info('⏰ Peminjaman ditandai terlambat - Riwayat ID: ' . $id);
            return redirect()->route('admin.riwayat')
                ->with('success', 'Peminjaman ditandai sebagai terlambat.');

        } catch (\Exception $e) {
            Log::error('❌ Gagal menandai terlambat: ' . $e->getMessage());
            return redirect()->route('admin.riwayat')
                ->with('error', 'Gagal menandai peminjaman sebagai terlambat');
        }
    }

    // Method store untuk tambah peminjaman baru
    public function store(Request $request)
    {
        try {
            $request->validate([
                'peminjam' => 'required|string|max:255',
                'tanggal' => 'required|date',
                'ruang' => 'required|string',
                'keperluan' => 'required|string'
            ]);

            // Cari user berdasarkan nama atau buat baru
            $user = User::where('name', $request->peminjam)->first();
            
            if (!$user) {
                // Buat user baru jika tidak ditemukan
                $user = User::create([
                    'name' => $request->peminjam,
                    'email' => strtolower(str_replace(' ', '', $request->peminjam)) . '@example.com',
                    'password' => bcrypt('password123') // Password default
                ]);
                Log::info('👤 User baru dibuat: ' . $user->name);
            }

            // Buat peminjaman
            $peminjaman = Peminjaman::create([
                'user_id' => $user->id,
                'tanggal' => $request->tanggal,
                'ruang' => $request->ruang,
                'proyektor' => $request->proyektor == '1',
                'keperluan' => $request->keperluan,
                'status' => 'pending'
            ]);

            Log::info('➕ Peminjaman baru dibuat - ID: ' . $peminjaman->id . ', User: ' . $user->name);
            return redirect()->route('admin.dashboard')
                ->with('success', 'Peminjaman berhasil ditambahkan.');

        } catch (\Exception $e) {
            Log::error('❌ Gagal menambah peminjaman: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal menambah peminjaman: ' . $e->getMessage());
        }
    }

    // =============================================
    // METHOD UNTUK FITUR PENGEMBALIAN
    // =============================================

    /**
     * Menyimpan data pengembalian baru
     */
    public function storePengembalian(Request $request)
    {
        try {
            $request->validate([
                'peminjaman_id' => 'required|exists:peminjaman,id',
                'kondisi_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
                'keterangan' => 'nullable|string|max:500'
            ]);

            // Cari data peminjaman
            $peminjaman = Peminjaman::with('user')->findOrFail($request->peminjaman_id);

            // Pindahkan ke riwayat dengan status dikembalikan
            $riwayat = RiwayatPeminjaman::create([
                'user_id' => $peminjaman->user_id,
                'tanggal_pinjam' => $peminjaman->tanggal,
                'tanggal_kembali' => now(),
                'ruang' => $peminjaman->ruang,
                'proyektor' => $peminjaman->proyektor,
                'keperluan' => $peminjaman->keperluan,
                'status' => 'dikembalikan',
                'catatan' => 'Kondisi: ' . $request->kondisi_barang . 
                            ($request->keterangan ? ' - ' . $request->keterangan : '') .
                            ' - User: ' . ($peminjaman->user->name ?? 'Tidak Diketahui')
            ]);

            // Hapus dari tabel peminjaman aktif
            $peminjaman->delete();

            Log::info('✅ Pengembalian baru disimpan - Riwayat ID: ' . $riwayat->id . 
                     ', Kondisi: ' . $request->kondisi_barang);

            return redirect()->route('admin.pengembalian')
                ->with('success', 'Pengembalian berhasil dicatat.');

        } catch (\Exception $e) {
            Log::error('❌ Gagal menyimpan pengembalian: ' . $e->getMessage());
            return redirect()->route('admin.pengembalian')
                ->with('error', 'Gagal menyimpan pengembalian: ' . $e->getMessage());
        }
    }

    /**
     * Memproses pengembalian barang dari halaman pengembalian
     */
    public function prosesPengembalian(Request $request, $id)
    {
        try {
            $request->validate([
                'kondisi_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
                'keterangan' => 'nullable|string|max:500'
            ]);

            // Cari data riwayat (untuk kasus edit pengembalian)
            $riwayat = RiwayatPeminjaman::findOrFail($id);

            // Update data pengembalian
            $riwayat->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now(),
                'catatan' => 'Kondisi: ' . $request->kondisi_barang . 
                            ($request->keterangan ? ' - ' . $request->keterangan : '') .
                            ' - User: ' . ($riwayat->user->name ?? 'Tidak Diketahui')
            ]);

            Log::info('✅ Pengembalian diproses - Riwayat ID: ' . $riwayat->id . 
                     ', Kondisi: ' . $request->kondisi_barang);

            return redirect()->route('admin.pengembalian')
                ->with('success', 'Pengembalian berhasil diproses.');

        } catch (\Exception $e) {
            Log::error('❌ Gagal memproses pengembalian: ' . $e->getMessage());
            return redirect()->route('admin.pengembalian')
                ->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data pengembalian
     */
    public function destroyPengembalian($id)
    {
        try {
            $riwayat = RiwayatPeminjaman::findOrFail($id);
            
            // Hanya bisa menghapus data dengan status terkait pengembalian
            if (!in_array($riwayat->status, ['dikembalikan', 'selesai', 'terlambat'])) {
                return redirect()->route('admin.pengembalian')
                    ->with('error', 'Tidak dapat menghapus data dengan status ini.');
            }

            $riwayat->delete();

            Log::info('🗑️ Data pengembalian dihapus - Riwayat ID: ' . $id);
            return redirect()->route('admin.pengembalian')
                ->with('success', 'Data pengembalian berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('❌ Gagal menghapus data pengembalian: ' . $e->getMessage());
            return redirect()->route('admin.pengembalian')
                ->with('error', 'Gagal menghapus data pengembalian: ' . $e->getMessage());
        }
    }

    /**
     * Method untuk memproses pengembalian dari data peminjaman aktif
     * (Alternatif dari method return yang sudah ada)
     */
    public function processReturnFromActive(Request $request, $id)
    {
        try {
            $request->validate([
                'kondisi_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
                'keterangan' => 'nullable|string|max:500'
            ]);

            $peminjaman = Peminjaman::with('user')->findOrFail($id);

            // Pindahkan ke riwayat dengan status dikembalikan
            $riwayat = RiwayatPeminjaman::create([
                'user_id' => $peminjaman->user_id,
                'tanggal_pinjam' => $peminjaman->tanggal,
                'tanggal_kembali' => now(),
                'ruang' => $peminjaman->ruang,
                'proyektor' => $peminjaman->proyektor,
                'keperluan' => $peminjaman->keperluan,
                'status' => 'dikembalikan',
                'catatan' => 'Kondisi: ' . $request->kondisi_barang . 
                            ($request->keterangan ? ' - ' . $request->keterangan : '') .
                            ' - User: ' . ($peminjaman->user->name ?? 'Tidak Diketahui')
            ]);

            // Hapus dari tabel peminjaman aktif
            $peminjaman->delete();

            Log::info('✅ Pengembalian dari peminjaman aktif - Riwayat ID: ' . $riwayat->id);

            return redirect()->route('admin.pengembalian')
                ->with('success', 'Pengembalian berhasil diproses dan dipindahkan ke riwayat.');

        } catch (\Exception $e) {
            Log::error('❌ Gagal memproses pengembalian dari peminjaman aktif: ' . $e->getMessage());
            return redirect()->route('admin.pengembalian')
                ->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }
}