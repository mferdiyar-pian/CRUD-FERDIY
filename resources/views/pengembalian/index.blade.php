<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian - Sistem Manajemen Peminjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --warning: #f8961e;
            --danger: #f94144;
            --light: #f8f9fa;
            --dark: #212529;
            --border-radius: 12px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            background-color: #f5f7fb;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            padding-bottom: 2rem;
        }

        /* Navbar */
        .navbar-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
        }

        /* Cards */
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

        /* Buttons */
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

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            white-space: nowrap;
            display: inline-block;
            min-width: 120px;
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
            0% { opacity: 1; }
            50% { opacity: 0.8; }
            100% { opacity: 1; }
        }

        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
            background: white;
            border-radius: var(--border-radius);
            padding: 10px;
            box-shadow: var(--box-shadow);
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: var(--transition);
            font-weight: 500;
            border-radius: 6px;
            margin-right: 5px;
            flex: 1;
            text-align: center;
            min-width: 120px;
            margin-bottom: 5px;
        }

        .filter-tab.active {
            border-bottom-color: var(--primary);
            color: var(--primary);
            background-color: rgba(67, 97, 238, 0.1);
        }

        .filter-tab:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        /* Table */
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

        /* Search */
        .search-container {
            position: relative;
            margin-bottom: 0;
        }

        .search-container i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #6c757d;
            z-index: 10;
        }

        .search-input {
            padding-left: 40px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        /* Empty State */
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

        /* Time Badge */
        .time-badge {
            background-color: #e9ecef;
            color: #495057;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
            margin-top: 4px;
        }

        /* Alert */
        .alert-custom {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .filter-tab {
                min-width: 100px;
                padding: 8px 10px;
                font-size: 0.85rem;
            }
            
            .table-container {
                overflow-x: auto;
            }
            
            .table {
                min-width: 800px;
            }
            
            .action-buttons {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .btn-action {
                margin-bottom: 5px;
            }
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            text-align: center;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.pending {
            background: linear-gradient(135deg, var(--warning), #e76f51);
        }

        .stat-icon.returned {
            background: linear-gradient(135deg, var(--success), #2a9d8f);
        }

        .stat-icon.overdue {
            background: linear-gradient(135deg, var(--danger), #e63946);
        }

        .stat-icon.total {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Modal */
        .modal-detail {
            max-width: 600px;
        }

        .detail-item {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .detail-value {
            color: #212529;
            font-size: 1rem;
        }

        /* Text Truncate */
        .text-truncate-custom {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
        }

        /* Tooltip */
        .info-tooltip {
            position: relative;
            display: inline-block;
            cursor: help;
        }

        .info-tooltip .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            position: absolute;
            z-index: 100;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.85rem;
        }

        .info-tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
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
                        <a class="nav-link" href="{{ route('peminjaman.index') }}">
                            <i class="fas fa-list me-1"></i> Peminjaman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('peminjaman.create') }}">
                            <i class="fas fa-plus-circle me-1"></i> Pinjam Baru
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-undo me-1"></i> Pengembalian
                        </a>
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

    <!-- Main Content -->
    <div class="container mb-5">
        <!-- Header -->
        <div class="row mb-4 page-header">
            <div class="col-md-6">
                <h2 class="mb-1"><i class="fas fa-undo text-primary me-2"></i> Pengembalian Saya</h2>
                <p class="text-muted mb-0">Kelola pengembalian barang yang telah dipinjam</p>
            </div>
        </div>

        <!-- Alert Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">{{ $pendingReturns ?? 0 }}</div>
                <div class="stat-label">Belum Dikembalikan</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon returned">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number">{{ $returnedCount ?? 0 }}</div>
                <div class="stat-label">Sudah Dikembalikan</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon overdue">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-number">{{ $overdueCount ?? 0 }}</div>
                <div class="stat-label">Terlambat</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div class="stat-number">{{ $totalReturns ?? 0 }}</div>
                <div class="stat-label">Total Pengembalian</div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <div class="filter-tab active" data-status="semua">Semua</div>
            <div class="filter-tab" data-status="belum_dikembalikan">
                <i class="fas fa-clock me-1"></i> Belum Dikembalikan
            </div>
            <div class="filter-tab" data-status="dikembalikan">
                <i class="fas fa-check-circle me-1"></i> Sudah Dikembalikan
            </div>
            <div class="filter-tab" data-status="terlambat">
                <i class="fas fa-exclamation-triangle me-1"></i> Terlambat
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card card-custom">
            <div class="card-body py-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="search-container">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control search-input" 
                                   placeholder="Cari berdasarkan ruang atau barang...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="ruang-filter">
                            <option value="semua">Semua Ruang</option>
                            <option value="Ruang A">Ruang A</option>
                            <option value="Ruang B">Ruang B</option>
                            <option value="Ruang C">Ruang C</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="sort-filter">
                            <option value="terbaru">Terbaru</option>
                            <option value="terlama">Terlama</option>
                            <option value="tanggal_pinjam">Tanggal Pinjam</option>
                            <option value="tanggal_kembali">Tanggal Kembali</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Barang yang Dipinjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Kondisi</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $pengembalian)
                            @php
                                $isOverdue = $pengembalian->status == 'terlambat';
                                $isReturned = $pengembalian->status == 'dikembalikan';
                                
                                // Hitung waktu relatif
                                $waktuPengajuan = \Carbon\Carbon::parse($pengembalian->created_at);
                                $sekarang = \Carbon\Carbon::now();
                                $selisih = $waktuPengajuan->diffForHumans($sekarang, true);
                            @endphp

                            <tr data-status="{{ $pengembalian->status }}" 
                                data-ruang="{{ $pengembalian->ruang }}"
                                data-id="{{ $pengembalian->id }}"
                                class="{{ $isOverdue ? 'table-warning' : '' }}">
                                <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold">
                                        <i class="fas fa-door-open text-primary me-1"></i>
                                        {{ $pengembalian->ruang }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fas fa-projector me-1"></i>
                                        {{ $pengembalian->proyektor ? 'Dengan Proyektor' : 'Tanpa Proyektor' }}
                                    </div>
                                    <div class="time-indicator small text-muted mt-1">
                                        <i class="fas fa-paper-plane me-1"></i>
                                        Diajukan {{ $selisih }} yang lalu
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-calendar-day text-info me-1"></i>
                                        {{ \Carbon\Carbon::parse($pengembalian->tanggal_pinjam)->format('d M Y') }}
                                    </div>
                                </td>
                                <td>
                                    @if($pengembalian->tanggal_kembali)
                                        <div>
                                            <i class="fas fa-calendar-check text-success me-1"></i>
                                            {{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d M Y') }}
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($pengembalian->status == 'dikembalikan')
                                        <span class="badge status-badge status-dikembalikan">
                                            <i class="fas fa-check-circle me-1"></i> Dikembalikan
                                        </span>
                                    @elseif($pengembalian->status == 'terlambat')
                                        <span class="badge status-badge status-terlambat">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Terlambat
                                        </span>
                                    @else
                                        <span class="badge status-badge status-belum-dikembalikan">
                                            <i class="fas fa-clock me-1"></i> Belum Dikembalikan
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $kondisi = '';
                                        if (str_contains($pengembalian->catatan ?? '', 'Kondisi: Baik')) {
                                            $kondisi = 'Baik';
                                        } elseif (str_contains($pengembalian->catatan ?? '', 'Kondisi: Rusak Ringan')) {
                                            $kondisi = 'Rusak Ringan';
                                        } elseif (str_contains($pengembalian->catatan ?? '', 'Kondisi: Rusak Berat')) {
                                            $kondisi = 'Rusak Berat';
                                        }
                                    @endphp
                                    @if($kondisi)
                                        <span class="badge bg-success">{{ $kondisi }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <!-- Tombol Detail -->
                                        <button class="btn btn-info btn-action btn-detail" 
                                                title="Lihat Detail"
                                                data-id="{{ $pengembalian->id }}"
                                                data-ruang="{{ $pengembalian->ruang }}"
                                                data-proyektor="{{ $pengembalian->proyektor ? 'Dengan Proyektor' : 'Tanpa Proyektor' }}"
                                                data-tanggal-pinjam="{{ $pengembalian->tanggal_pinjam }}"
                                                data-tanggal-kembali="{{ $pengembalian->tanggal_kembali }}"
                                                data-status="{{ $pengembalian->status }}"
                                                data-kondisi="{{ $kondisi }}"
                                                data-keterangan="{{ $pengembalian->catatan ?? '-' }}">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <!-- Tombol Ajukan Pengembalian (hanya untuk yang belum dikembalikan) -->
                                        @if ($pengembalian->status != 'dikembalikan')
                                            <button class="btn btn-success btn-action btn-return" 
                                                    title="Ajukan Pengembalian"
                                                    data-id="{{ $pengembalian->id }}"
                                                    data-ruang="{{ $pengembalian->ruang }}">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h4 class="mt-3">Belum ada data pengembalian</h4>
                                        <p class="text-muted">Data pengembalian akan muncul setelah Anda melakukan peminjaman</p>
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
                    <ul class="pagination">
                        @if ($pengembalians->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Sebelumnya</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $pengembalians->previousPageUrl() }}">Sebelumnya</a>
                            </li>
                        @endif

                        @foreach ($pengembalians->getUrlRange(1, $pengembalians->lastPage()) as $page => $url)
                            @if ($page == $pengembalians->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        @if ($pengembalians->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $pengembalians->nextPageUrl() }}">Selanjutnya</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Selanjutnya</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>

    <!-- Modal Detail Pengembalian -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-detail">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">
                        <i class="fas fa-info-circle me-2"></i>Detail Pengembalian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Konten akan diisi oleh JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ajukan Pengembalian -->
    <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel">
                        <i class="fas fa-undo me-2"></i>Ajukan Pengembalian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="returnForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Barang yang Dikembalikan</label>
                            <input type="text" class="form-control" id="return_ruang" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kondisi_barang" class="form-label">Kondisi Barang</label>
                            <select class="form-select" id="kondisi_barang" name="kondisi_barang" required>
                                <option value="">Pilih Kondisi Barang</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" 
                                      placeholder="Berikan keterangan tambahan jika diperlukan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ajukan Pengembalian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter Table
        function filterTable() {
            const searchText = document.querySelector('.search-input').value.toLowerCase();
            const activeTab = document.querySelector('.filter-tab.active');
            const statusFilter = activeTab ? activeTab.getAttribute('data-status') : 'semua';
            const ruangFilter = document.getElementById('ruang-filter').value;

            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const rowStatus = row.getAttribute('data-status');
                const rowRuang = row.getAttribute('data-ruang');

                const textMatch = text.includes(searchText);
                const statusMatch = statusFilter === 'semua' || rowStatus === statusFilter;
                const ruangMatch = ruangFilter === 'semua' || rowRuang === ruangFilter;

                if (textMatch && statusMatch && ruangMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Show Detail Modal
        function showDetailModal(data) {
            const modalContent = `
                <div class="detail-item">
                    <div class="detail-label">Barang yang Dipinjam</div>
                    <div class="detail-value">${data.ruang} - ${data.proyektor}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Tanggal Pinjam</div>
                    <div class="detail-value">${formatDate(data.tanggalPinjam)}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Tanggal Kembali</div>
                    <div class="detail-value">${data.tanggalKembali ? formatDate(data.tanggalKembali) : '-'}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        ${getStatusBadge(data.status)}
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Kondisi Barang</div>
                    <div class="detail-value">${data.kondisi || '-'}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Keterangan</div>
                    <div class="detail-value">${data.keterangan}</div>
                </div>
            `;

            document.getElementById('modalBody').innerHTML = modalContent;
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }

        // Show Return Modal
        function showReturnModal(id, ruang) {
            document.getElementById('return_ruang').value = ruang;
            document.getElementById('returnForm').action = `/pengembalian/${id}/ajukan`;
            
            const modal = new bootstrap.Modal(document.getElementById('returnModal'));
            modal.show();
        }

        // Format Date
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
        }

        // Get Status Badge
        function getStatusBadge(status) {
            const badges = {
                'dikembalikan': '<span class="badge status-badge status-dikembalikan"><i class="fas fa-check-circle me-1"></i> Dikembalikan</span>',
                'belum_dikembalikan': '<span class="badge status-badge status-belum-dikembalikan"><i class="fas fa-clock me-1"></i> Belum Dikembalikan</span>',
                'terlambat': '<span class="badge status-badge status-terlambat"><i class="fas fa-exclamation-triangle me-1"></i> Terlambat</span>'
            };
            return badges[status] || status;
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Filter Tabs
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    document.querySelectorAll('.filter-tab').forEach(t => {
                        t.classList.remove('active');
                    });
                    this.classList.add('active');
                    filterTable();
                });
            });

            // Search Input
            document.querySelector('.search-input').addEventListener('keyup', filterTable);

            // Ruang Filter
            document.getElementById('ruang-filter').addEventListener('change', filterTable);

            // Sort Filter
            document.getElementById('sort-filter').addEventListener('change', function() {
                // Logic untuk sorting bisa ditambahkan di sini
                filterTable();
            });

            // Detail Buttons
            document.querySelectorAll('.btn-detail').forEach(button => {
                button.addEventListener('click', function() {
                    const data = {
                        id: this.getAttribute('data-id'),
                        ruang: this.getAttribute('data-ruang'),
                        proyektor: this.getAttribute('data-proyektor'),
                        tanggalPinjam: this.getAttribute('data-tanggal-pinjam'),
                        tanggalKembali: this.getAttribute('data-tanggal-kembali'),
                        status: this.getAttribute('data-status'),
                        kondisi: this.getAttribute('data-kondisi'),
                        keterangan: this.getAttribute('data-keterangan')
                    };
                    showDetailModal(data);
                });
            });

            // Return Buttons
            document.querySelectorAll('.btn-return').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const ruang = this.getAttribute('data-ruang');
                    showReturnModal(id, ruang);
                });
            });

            // Return Form Submission
            document.getElementById('returnForm').addEventListener('submit', function(e) {
                const kondisi = document.getElementById('kondisi_barang').value;
                if (!kondisi) {
                    e.preventDefault();
                    alert('Pilih kondisi barang terlebih dahulu');
                    return false;
                }
                
                if (!confirm('Apakah Anda yakin ingin mengajukan pengembalian?')) {
                    e.preventDefault();
                    return false;
                }
            });

            // Initial filter
            filterTable();
        });
    </script>
</body>

</html>