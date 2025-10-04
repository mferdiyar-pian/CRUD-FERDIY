<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - Sistem Manajemen Peminjaman</title>
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

        .status-menunggu {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-disetujui {
            background-color: #d1edff;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .status-ditolak {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-selesai {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-berlangsung {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
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

        /* ===== FILTER TABS ===== */
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

        /* ===== PENCARIAN ===== */
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

        /* ===== INDIKATOR VISUAL ===== */
        .today-indicator {
            position: relative;
            background-color: rgba(25, 135, 84, 0.05);
        }

        .today-indicator::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: #198754;
            border-radius: 2px;
        }

        /* ===== TOOLTIP ===== */
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

        /* ===== BADGE WAKTU ===== */
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

        /* ===== PERBAIKAN VISUAL ===== */
        .page-header {
            margin-bottom: 1.5rem;
        }

        .form-select,
        .form-control {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
        }

        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 1.5rem;
        }

        .table th:first-child {
            border-radius: 10px 0 0 0;
        }

        .table th:last-child {
            border-radius: 0 10px 0 0;
        }

        .table td:last-child {
            width: 150px;
            min-width: 150px;
        }

        .text-truncate-custom {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
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

            .table th,
            .table td {
                padding: 10px 8px;
                font-size: 0.85rem;
            }

            .status-badge {
                font-size: 0.75rem;
                padding: 4px 8px;
                min-width: 80px;
            }

            .filter-tabs {
                flex-wrap: wrap;
                overflow-x: auto;
                padding-bottom: 5px;
            }

            .filter-tab {
                flex: 1 0 auto;
                min-width: 120px;
                text-align: center;
                padding: 8px 10px;
                font-size: 0.85rem;
                white-space: nowrap;
            }

            .page-header .col-md-6 {
                margin-bottom: 15px;
            }

            .page-header .text-md-end {
                text-align: left !important;
            }
        }

        /* ===== PERBAIKAN TAMBAHAN ===== */
        .table-row-highlight {
            transition: background-color 0.2s ease;
        }

        .table-row-highlight:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: nowrap;
        }

        .table-responsive-custom {
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .no-data-row td {
            padding: 30px !important;
            text-align: center;
        }

        .text-truncate-custom {
            max-width: 250px;
        }

        .filter-controls {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-controls>div {
            flex: 1;
            min-width: 200px;
        }

        /* ===== STYLING UNTUK WAKTU PENGIRIMAN ===== */
        .time-indicator {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .time-indicator i {
            margin-right: 5px;
        }

        .time-indicator.recent {
            color: #198754;
            font-weight: 500;
        }

        .time-indicator.old {
            color: #6c757d;
        }
    </style>
</head>

<body>
    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('user.peminjaman.index') }}">
                <i class="fas fa-calendar-check me-2"></i>
                <strong>Sistem Peminjaman</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.peminjaman.index') }}"><i
                                class="fas fa-list me-1"></i> Daftar Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.peminjaman.create') }}"><i
                                class="fas fa-plus-circle me-1"></i> Tambah Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('user.peminjaman.riwayat') }}">
                            <i class="fas fa-history me-1"></i> Riwayat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.pengembalian.index') }}">
                            <i class="fas fa-undo me-1"></i> Pengembalian
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===== KONTEN UTAMA ===== -->
    <div class="container mb-5">
        <!-- Header dan Tambah Peminjaman -->
        <div class="row mb-4 page-header">
            <div class="col-md-6">
                <h2 class="mb-1"><i class="fas fa-history text-primary me-2"></i> Riwayat Peminjaman</h2>
                <p class="text-muted mb-0">Lihat riwayat semua peminjaman yang telah Anda ajukan</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('user.peminjaman.index') }}" class="btn btn-primary-custom me-2">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                </a>
                <a href="{{ route('user.peminjaman.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Peminjaman
                </a>
            </div>
        </div>

        <!-- Alert Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistik Ringkas -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <i class="fas fa-list-alt fa-2x text-primary mb-2"></i>
                        <h4 class="mb-1">{{ $riwayat->total() }}</h4>
                        <p class="text-muted mb-0">Total Peminjaman</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <h4 class="mb-1">{{ $riwayat->where('status', 'disetujui')->count() }}</h4>
                        <p class="text-muted mb-0">Disetujui</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                        <h4 class="mb-1">{{ $riwayat->where('status', 'pending')->count() }}</h4>
                        <p class="text-muted mb-0">Menunggu</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                        <h4 class="mb-1">{{ $riwayat->where('status', 'ditolak')->count() }}</h4>
                        <p class="text-muted mb-0">Ditolak</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Filter -->
        <div class="filter-tabs">
            <div class="filter-tab active" data-status="semua">Semua</div>
            <div class="filter-tab" data-status="pending">
                <i class="fas fa-clock me-1"></i> Menunggu
            </div>
            <div class="filter-tab" data-status="disetujui">
                <i class="fas fa-check-circle me-1"></i> Disetujui
            </div>
            <div class="filter-tab" data-status="ditolak">
                <i class="fas fa-times-circle me-1"></i> Ditolak
            </div>
            <div class="filter-tab" data-status="selesai">
                <i class="fas fa-check-double me-1"></i> Selesai
            </div>
        </div>

        <!-- Card Filter dan Pencarian -->
        <div class="card card-custom">
            <div class="card-body py-3">
                <div class="filter-controls">
                    <div class="search-container">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control search-input"
                            placeholder="Cari berdasarkan ruang, keperluan, atau tanggal...">
                    </div>
                    <div>
                        <select class="form-select" id="ruang-filter">
                            <option value="semua">Semua Ruang</option>
                            <option value="Ruang A">Ruang A</option>
                            <option value="Ruang B">Ruang B</option>
                            <option value="Ruang C">Ruang C</option>
                        </select>
                    </div>
                    <div>
                        <input type="date" class="form-control" id="tanggal-filter" placeholder="Filter Tanggal">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat Peminjaman -->
        <div class="table-container">
            <div class="table-responsive table-responsive-custom">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Tanggal & Waktu</th>
                            <th>Ruang</th>
                            <th width="100" class="text-center">Proyektor</th>
                            <th>Keperluan</th>
                            <th width="130" class="text-center">Status</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $peminjaman)
                            @php
                                // Tentukan apakah peminjaman sedang berlangsung
                                $isToday = \Carbon\Carbon::parse($peminjaman->tanggal)->isToday();
                                $isOngoing = $isToday && $peminjaman->status == 'disetujui';

                                // Hitung waktu pengajuan relatif
                                $waktuPengajuan = \Carbon\Carbon::parse($peminjaman->created_at);
                                $sekarang = \Carbon\Carbon::now();
                                $selisih = $waktuPengajuan->diffForHumans($sekarang, true);
                            @endphp

                            <tr data-status="{{ $peminjaman->status }}"
                                class="{{ $isOngoing ? 'today-indicator' : '' }} table-row-highlight"
                                data-ruang="{{ $peminjaman->ruang }}" data-id="{{ $peminjaman->id }}"
                                data-tanggal="{{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('Y-m-d') }}"
                                data-waktu-pengajuan="{{ $waktuPengajuan->format('Y-m-d H:i:s') }}">
                                <td class="fw-bold text-center">{{ ($riwayat->currentPage() - 1) * $riwayat->perPage() + $loop->iteration }}</td>
                                <td>
                                    <div>
                                        <i class="fas fa-calendar-day text-primary me-1"></i>
                                        {{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d M Y') }}
                                    </div>
                                    <div>
                                        <span class="time-badge">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $peminjaman->waktu_mulai ?? '08:00' }} -
                                            {{ $peminjaman->waktu_selesai ?? '17:00' }}
                                        </span>
                                    </div>
                                    <div
                                        class="time-indicator {{ $waktuPengajuan->diffInHours($sekarang) < 24 ? 'recent' : 'old' }}">
                                        <i class="fas fa-paper-plane me-1"></i>
                                        Diajukan {{ $selisih }} yang lalu
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-door-open text-info me-1"></i>
                                    {{ $peminjaman->ruang }}
                                </td>
                                <td class="text-center">
                                    @if ($peminjaman->proyektor)
                                        <span class="badge bg-success status-badge"><i class="fas fa-check me-1"></i>
                                            Ya</span>
                                    @else
                                        <span class="badge bg-secondary status-badge"><i
                                                class="fas fa-times me-1"></i> Tidak</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="info-tooltip">
                                        <span
                                            class="text-truncate-custom">{{ \Illuminate\Support\Str::limit($peminjaman->keperluan, 40) }}</span>
                                        @if (strlen($peminjaman->keperluan) > 40)
                                            <span class="tooltip-text">{{ $peminjaman->keperluan }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($isOngoing)
                                        <span class="badge status-badge status-berlangsung">
                                            <i class="fas fa-play-circle me-1"></i> Berlangsung
                                        </span>
                                    @elseif($peminjaman->status == 'disetujui')
                                        <span class="badge status-badge status-disetujui">
                                            <i class="fas fa-check-circle me-1"></i> Disetujui
                                        </span>
                                    @elseif($peminjaman->status == 'ditolak')
                                        <span class="badge status-badge status-ditolak">
                                            <i class="fas fa-times-circle me-1"></i> Ditolak
                                        </span>
                                    @elseif($peminjaman->status == 'selesai')
                                        <span class="badge status-badge status-selesai">
                                            <i class="fas fa-check-double me-1"></i> Selesai
                                        </span>
                                    @else
                                        <span class="badge status-badge status-menunggu">
                                            <i class="fas fa-clock me-1"></i> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="{{ route('user.peminjaman.show', $peminjaman->id) }}" 
                                           class="btn btn-info btn-action" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="no-data-row">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h4 class="mt-3">Belum ada riwayat peminjaman</h4>
                                        <p class="text-muted">Silahkan tambah data peminjaman baru dengan menekan
                                            tombol "Tambah Peminjaman"</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($riwayat->hasPages())
            <div class="d-flex justify-content-center mt-4">
                <nav>
                    <ul class="pagination pagination-custom">
                        {{-- Previous Page Link --}}
                        @if ($riwayat->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $riwayat->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $riwayat->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($riwayat->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $riwayat->nextPageUrl() }}">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ===== FILTER TABEL =====
        function filterTable() {
            const searchText = document.querySelector('.search-input').value.toLowerCase();
            const activeTab = document.querySelector('.filter-tab.active');
            const statusFilter = activeTab ? activeTab.getAttribute('data-status') : 'semua';
            const ruangFilter = document.getElementById('ruang-filter').value;
            const tanggalFilter = document.getElementById('tanggal-filter').value;

            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const rowStatus = row.getAttribute('data-status');
                const rowRuang = row.getAttribute('data-ruang');
                const rowTanggal = row.getAttribute('data-tanggal');

                // Filter berdasarkan pencarian, status, ruang, dan tanggal
                const textMatch = text.includes(searchText);
                const statusMatch = statusFilter === 'semua' ||
                    (statusFilter === 'berlangsung' ? row.classList.contains('today-indicator') : rowStatus ===
                        statusFilter);
                const ruangMatch = ruangFilter === 'semua' || rowRuang === ruangFilter;
                const tanggalMatch = !tanggalFilter || rowTanggal === tanggalFilter;

                if (textMatch && statusMatch && ruangMatch && tanggalMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // ===== FUNGSI UNTUK MEMPERBARUI WAKTU RELATIF =====
        function updateRelativeTimes() {
            const timeIndicators = document.querySelectorAll('.time-indicator');
            const now = new Date();

            timeIndicators.forEach(indicator => {
                const row = indicator.closest('tr');
                const waktuPengajuan = row.getAttribute('data-waktu-pengajuan');
                const waktuPengajuanObj = new Date(waktuPengajuan);

                // Hitung selisih waktu
                const diffMs = now - waktuPengajuanObj;
                const diffSec = Math.floor(diffMs / 1000);
                const diffMin = Math.floor(diffSec / 60);
                const diffHour = Math.floor(diffMin / 60);
                const diffDay = Math.floor(diffHour / 24);

                let relativeTime;

                if (diffSec < 60) {
                    relativeTime = `${diffSec} detik`;
                } else if (diffMin < 60) {
                    relativeTime = `${diffMin} menit`;
                } else if (diffHour < 24) {
                    relativeTime = `${diffHour} jam`;
                } else if (diffDay < 7) {
                    relativeTime = `${diffDay} hari`;
                } else if (diffDay < 30) {
                    const weeks = Math.floor(diffDay / 7);
                    relativeTime = `${weeks} minggu`;
                } else if (diffDay < 365) {
                    const months = Math.floor(diffDay / 30);
                    relativeTime = `${months} bulan`;
                } else {
                    const years = Math.floor(diffDay / 365);
                    relativeTime = `${years} tahun`;
                }

                // Update teks dan kelas
                indicator.textContent = `Diajukan ${relativeTime} yang lalu`;
                indicator.className = `time-indicator ${diffDay < 1 ? 'recent' : 'old'}`;
            });
        }

        // ===== INISIALISASI EVENT LISTENER =====
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk pencarian
            const searchInput = document.querySelector('.search-input');
            searchInput.addEventListener('keyup', filterTable);

            // Event listener untuk filter tab
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    // Hapus kelas active dari semua tab
                    document.querySelectorAll('.filter-tab').forEach(t => {
                        t.classList.remove('active');
                    });

                    // Tambah kelas active ke tab yang diklik
                    this.classList.add('active');

                    filterTable();
                });
            });

            // Event listener untuk filter ruang
            document.getElementById('ruang-filter').addEventListener('change', filterTable);

            // Event listener untuk filter tanggal
            document.getElementById('tanggal-filter').addEventListener('change', filterTable);

            // Perbarui waktu relatif setiap menit
            updateRelativeTimes();
            setInterval(updateRelativeTimes, 60000); // Update setiap 1 menit

            // Inisialisasi filter saat halaman dimuat
            filterTable();
        });
    </script>
</body>

</html>