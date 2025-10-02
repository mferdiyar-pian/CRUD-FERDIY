<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Pengembalian - Sistem Manajemen Peminjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== VARIABEL CSS ===== */
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --border-radius: 12px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        /* ===== STYLING UMUM ===== */
        body {
            background-color: #f5f7fb;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            padding-bottom: 2rem;
        }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
        }

        /* ===== KARTU ===== */
        .card-custom {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
            transition: transform 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .card-custom:hover {
            transform: translateY(-3px);
        }

        /* ===== TOMBOL ===== */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(67, 97, 238, 0.4);
        }

        .btn-action {
            padding: 6px 10px;
            border-radius: 6px;
            margin: 0 2px;
            font-size: 0.85rem;
        }

        /* ===== STATUS BADGE ===== */
        .status-badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            white-space: nowrap;
            display: inline-block;
            min-width: 100px;
            text-align: center;
        }

        .status-dikembalikan {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-belum-dikembalikan {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-terlambat {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
            100% {
                opacity: 1;
            }
        }

        /* ===== TABEL ===== */
        .table-container {
            background-color: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            margin-bottom: 1.5rem;
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .table th {
            border: none;
            padding: 16px 12px;
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .table td {
            padding: 14px 12px;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
            transition: background-color 0.2s ease;
        }

        /* ===== FORM ===== */
        .form-container {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        /* ===== PAGINATION ===== */
        .pagination-custom .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .pagination-custom .page-link {
            color: var(--primary);
            border-radius: 8px;
            margin: 0 2px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            padding: 8px 14px;
        }

        /* ===== STATE KOSONG ===== */
        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 60px;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        /* ===== RESPONSIVITAS ===== */
        @media (max-width: 768px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            .table-container {
                overflow-x: auto;
                border-radius: 8px;
            }

            .table {
                min-width: 800px;
            }

            .btn-action {
                margin-bottom: 5px;
                display: inline-block;
                width: auto;
                margin: 2px;
            }

            .action-buttons {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .table th, .table td {
                padding: 10px 8px;
                font-size: 0.85rem;
            }

            .status-badge {
                font-size: 0.75rem;
                padding: 4px 8px;
                min-width: 80px;
            }

            .card-body {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('peminjaman.index') }}">
                <i class="fas fa-calendar-check me-2"></i>
                <strong>Sistem Peminjaman</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('peminjaman.index') }}"><i class="fas fa-list me-1"></i> Daftar Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('pengembalian.index') }}"><i class="fas fa-undo me-1"></i> Pengembalian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('peminjaman.create') }}"><i class="fas fa-plus-circle me-1"></i> Tambah Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('peminjaman.riwayat') }}">
                            <i class="fas fa-history me-1"></i> Riwayat
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===== KONTEN UTAMA ===== -->
    <div class="container mb-5">
        <!-- Header -->
        <div class="row mb-4 page-header">
            <div class="col-md-6">
                <h2 class="mb-1"><i class="fas fa-undo text-primary me-2"></i> Pengelolaan Pengembalian</h2>
                <p class="text-muted mb-0">Kelola pengembalian ruangan dan proyektor</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#tambahPengembalianModal">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Pengembalian
                </button>
            </div>
        </div>

        <!-- Alert Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tabel Pengembalian -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Kondisi Ruangan</th>
                            <th>Kondisi Proyektor</th>
                            <th>Keterangan</th>
                            <th width="130" class="text-center">Status</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $pengembalian)
                            <tr>
                                <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div>
                                        <i class="fas fa-door-open text-info me-1"></i>
                                        {{ $pengembalian->peminjaman->ruang }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal)->format('d M Y') }}
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-calendar-day text-primary me-1"></i>
                                    {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d M Y') }}
                                </td>
                                <td>
                                    <span class="badge {{ $pengembalian->kondisi_ruangan == 'baik' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($pengembalian->kondisi_ruangan) }}
                                    </span>
                                </td>
                                <td>
                                    @if($pengembalian->peminjaman->proyektor)
                                        <span class="badge {{ $pengembalian->kondisi_proyektor == 'baik' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($pengembalian->kondisi_proyektor) }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Ada</span>
                                    @endif
                                </td>
                                <td>
                                    {{ \Illuminate\Support\Str::limit($pengembalian->keterangan, 30) }}
                                </td>
                                <td class="text-center">
                                    @if($pengembalian->status == 'dikembalikan')
                                        <span class="badge status-badge status-dikembalikan">
                                            <i class="fas fa-check-circle me-1"></i> Dikembalikan
                                        </span>
                                    @elseif($pengembalian->status == 'terlambat')
                                        <span class="badge status-badge status-terlambat">
                                            <i class="fas fa-exclamation-circle me-1"></i> Terlambat
                                        </span>
                                    @else
                                        <span class="badge status-badge status-belum-dikembalikan">
                                            <i class="fas fa-clock me-1"></i> Belum Dikembalikan
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <!-- Tombol Detail -->
                                        <button class="btn btn-info btn-action btn-detail" title="Lihat Detail"
                                            data-id="{{ $pengembalian->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <!-- Tombol Edit -->
                                        <button class="btn btn-warning btn-action btn-edit" title="Edit Pengembalian"
                                            data-id="{{ $pengembalian->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button class="btn btn-danger btn-action btn-delete" title="Hapus Pengembalian"
                                            data-id="{{ $pengembalian->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="no-data-row">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h4 class="mt-3">Belum ada data pengembalian</h4>
                                        <p class="text-muted">Silahkan tambah data pengembalian baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($pengembalians->count() > 0)
            <div class="d-flex justify-content-center mt-4">
                <nav>
                    <ul class="pagination pagination-custom">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        @endif
    </div>

    <!-- Modal Tambah Pengembalian -->
    <div class="modal fade" id="tambahPengembalianModal" tabindex="-1" aria-labelledby="tambahPengembalianModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPengembalianModalLabel">Tambah Pengembalian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahPengembalian" action="{{ route('pengembalian.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="peminjaman_id" class="form-label">Pilih Peminjaman</label>
                                <select class="form-select" id="peminjaman_id" name="peminjaman_id" required>
                                    <option value="">-- Pilih Peminjaman --</option>
                                    @foreach($peminjamans as $peminjaman)
                                        <option value="{{ $peminjaman->id }}">
                                            {{ $peminjaman->ruang }} - {{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d M Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                                <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kondisi_ruangan" class="form-label">Kondisi Ruangan</label>
                                <select class="form-select" id="kondisi_ruangan" name="kondisi_ruangan" required>
                                    <option value="baik">Baik</option>
                                    <option value="rusak_ringan">Rusak Ringan</option>
                                    <option value="rusak_berat">Rusak Berat</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kondisi_proyektor" class="form-label">Kondisi Proyektor</label>
                                <select class="form-select" id="kondisi_proyektor" name="kondisi_proyektor">
                                    <option value="baik">Baik</option>
                                    <option value="rusak_ringan">Rusak Ringan</option>
                                    <option value="rusak_berat">Rusak Berat</option>
                                    <option value="tidak_ada">Tidak Ada</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary-custom">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pengembalian -->
    <div class="modal fade" id="editPengembalianModal" tabindex="-1" aria-labelledby="editPengembalianModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPengembalianModalLabel">Edit Pengembalian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditPengembalian" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_peminjaman_id" class="form-label">Peminjaman</label>
                                <input type="text" class="form-control" id="edit_peminjaman_id" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                                <input type="date" class="form-control" id="edit_tanggal_pengembalian" name="tanggal_pengembalian" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_kondisi_ruangan" class="form-label">Kondisi Ruangan</label>
                                <select class="form-select" id="edit_kondisi_ruangan" name="kondisi_ruangan" required>
                                    <option value="baik">Baik</option>
                                    <option value="rusak_ringan">Rusak Ringan</option>
                                    <option value="rusak_berat">Rusak Berat</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_kondisi_proyektor" class="form-label">Kondisi Proyektor</label>
                                <select class="form-select" id="edit_kondisi_proyektor" name="kondisi_proyektor">
                                    <option value="baik">Baik</option>
                                    <option value="rusak_ringan">Rusak Ringan</option>
                                    <option value="rusak_berat">Rusak Berat</option>
                                    <option value="tidak_ada">Tidak Ada</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary-custom">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pengembalian -->
    <div class="modal fade" id="detailPengembalianModal" tabindex="-1" aria-labelledby="detailPengembalianModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailPengembalianModalLabel">Detail Pengembalian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailPengembalianBody">
                    <!-- Konten detail akan diisi oleh JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data pengembalian ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Data dummy untuk simulasi
        const pengembalianData = {
            1: {
                peminjaman_id: "Ruang A - 15 Jun 2023",
                tanggal_pengembalian: "2023-06-15",
                kondisi_ruangan: "baik",
                kondisi_proyektor: "baik",
                keterangan: "Pengembalian tepat waktu, kondisi ruangan dan proyektor baik."
            },
            2: {
                peminjaman_id: "Ruang B - 20 Jun 2023",
                tanggal_pengembalian: "2023-06-21",
                kondisi_ruangan: "rusak_ringan",
                kondisi_proyektor: "rusak_ringan",
                keterangan: "Terlambat 1 hari, terdapat kerusakan ringan pada kursi dan proyektor."
            }
        };

        // Event listener untuk tombol edit
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const data = pengembalianData[id];
                
                if (data) {
                    document.getElementById('formEditPengembalian').action = `/pengembalian/${id}`;
                    document.getElementById('edit_peminjaman_id').value = data.peminjaman_id;
                    document.getElementById('edit_tanggal_pengembalian').value = data.tanggal_pengembalian;
                    document.getElementById('edit_kondisi_ruangan').value = data.kondisi_ruangan;
                    document.getElementById('edit_kondisi_proyektor').value = data.kondisi_proyektor;
                    document.getElementById('edit_keterangan').value = data.keterangan;
                    
                    const modal = new bootstrap.Modal(document.getElementById('editPengembalianModal'));
                    modal.show();
                }
            });
        });

        // Event listener untuk tombol detail
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const data = pengembalianData[id];
                
                if (data) {
                    const detailContent = `
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Peminjaman:</strong><br>
                                ${data.peminjaman_id}
                            </div>
                            <div class="col-md-6">
                                <strong>Tanggal Pengembalian:</strong><br>
                                ${new Date(data.tanggal_pengembalian).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Kondisi Ruangan:</strong><br>
                                <span class="badge ${data.kondisi_ruangan === 'baik' ? 'bg-success' : 'bg-warning'}">
                                    ${data.kondisi_ruangan === 'baik' ? 'Baik' : data.kondisi_ruangan === 'rusak_ringan' ? 'Rusak Ringan' : 'Rusak Berat'}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <strong>Kondisi Proyektor:</strong><br>
                                <span class="badge ${data.kondisi_proyektor === 'baik' ? 'bg-success' : data.kondisi_proyektor === 'tidak_ada' ? 'bg-secondary' : 'bg-warning'}">
                                    ${data.kondisi_proyektor === 'baik' ? 'Baik' : data.kondisi_proyektor === 'rusak_ringan' ? 'Rusak Ringan' : data.kondisi_proyektor === 'rusak_berat' ? 'Rusak Berat' : 'Tidak Ada'}
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Keterangan:</strong><br>
                            ${data.keterangan}
                        </div>
                    `;
                    
                    document.getElementById('detailPengembalianBody').innerHTML = detailContent;
                    
                    const modal = new bootstrap.Modal(document.getElementById('detailPengembalianModal'));
                    modal.show();
                }
            });
        });

        // Event listener untuk tombol hapus
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('deleteForm').action = `/pengembalian/${id}`;
                
                const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
                modal.show();
            });
        });

        // Validasi form tambah
        document.getElementById('formTambahPengembalian').addEventListener('submit', function(e) {
            const peminjamanId = document.getElementById('peminjaman_id').value;
            const tanggalPengembalian = document.getElementById('tanggal_pengembalian').value;
            
            if (!peminjamanId || !tanggalPengembalian) {
                e.preventDefault();
                alert('Harap lengkapi semua field yang wajib diisi!');
            }
        });

        // Validasi form edit
        document.getElementById('formEditPengembalian').addEventListener('submit', function(e) {
            const tanggalPengembalian = document.getElementById('edit_tanggal_pengembalian').value;
            
            if (!tanggalPengembalian) {
                e.preventDefault();
                alert('Harap lengkapi semua field yang wajib diisi!');
            }
        });

        // Set tanggal default untuk form tambah
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal_pengembalian').value = today;
        });
    </script>
</body>

</html>