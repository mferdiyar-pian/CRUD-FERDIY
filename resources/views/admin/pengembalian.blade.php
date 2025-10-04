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
            --primary: #3b5998;
            --secondary: #6d84b4;
            --success: #4caf50;
            --info: #2196f3;
            --warning: #ff9800;
            --danger: #f44336;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray: #6c757d;
            --sidebar-width: 250px;
            --text-light: #6c757d;
            --text-dark: #495057;
            --bg-light: #f5f8fa;
            --bg-card: #ffffff;
            --border-light: #e9ecef;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100%;
            background: linear-gradient(180deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .sidebar-logo {
            font-size: 2.5rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 20px 0;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menu-item:hover,
        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid white;
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            opacity: 0.8;
            flex-shrink: 0;
        }

        .menu-item span {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s;
            min-height: 100vh;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--bg-card);
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            border: 1px solid var(--border-light);
        }

        .search-bar {
            position: relative;
            width: 300px;
        }

        .search-bar i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        .search-bar input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid var(--border-light);
            border-radius: 30px;
            outline: none;
            transition: all 0.3s;
            background-color: var(--bg-light);
        }

        .search-bar input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(59, 89, 152, 0.1);
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification-btn,
        .theme-toggle {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-light);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--text-dark);
        }

        .notification-btn:hover,
        .theme-toggle:hover {
            background: #e4e6eb;
            color: var(--primary);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Page Title */
        .page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .page-title h1 {
            color: var(--dark);
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 1.8rem;
        }

        .page-title p {
            color: var(--text-light);
            margin: 0;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(59, 89, 152, 0.2);
        }

        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(59, 89, 152, 0.3);
        }

        .btn-outline {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: 8px;
            padding: 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            border: 1px solid var(--border-light);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.5rem;
            color: white;
            opacity: 0.9;
        }

        .stat-icon.pending {
            background: #ffb74d;
        }

        .stat-icon.returned {
            background: #66bb6a;
        }

        .stat-icon.overdue {
            background: #ef5350;
        }

        .stat-icon.total {
            background: var(--primary);
        }

        .stat-info h3 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .stat-info p {
            margin: 0;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* Filter Section */
        .filter-section {
            background: var(--bg-card);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-light);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark);
        }

        .filter-group input,
        .filter-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-light);
            border-radius: 4px;
            outline: none;
            transition: all 0.3s;
            background-color: var(--bg-light);
        }

        .filter-group input:focus,
        .filter-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(59, 89, 152, 0.1);
        }

        /* Table */
        .table-container {
            background: var(--bg-card);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-light);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            margin: 0;
        }

        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid var(--border-light);
            font-weight: 600;
            color: var(--dark);
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-color: var(--border-light);
        }

        .table tbody tr {
            transition: all 0.3s;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        /* Status Badges */
        .badge {
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .status-dikembalikan {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-belum-dikembalikan {
            background: #fff8e1;
            color: #ff8f00;
        }

        .status-terlambat {
            background: #ffebee;
            color: #c62828;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-success-custom {
            background: #4caf50;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .btn-danger-custom {
            background: #f44336;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .btn-warning-custom {
            background: #ff9800;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .btn-info-custom {
            background: #2196f3;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .btn-success-custom:hover,
        .btn-danger-custom:hover,
        .btn-warning-custom:hover,
        .btn-info-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            opacity: 0.9;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-light);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination .page-link {
            color: var(--primary);
            border: 1px solid var(--border-light);
            padding: 8px 15px;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* Modal */
        .modal-header {
            background: var(--primary);
            color: white;
            border-bottom: none;
        }

        .btn-close-white {
            filter: invert(1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }

            .sidebar-header h2,
            .menu-item span {
                display: none;
            }

            .menu-item {
                justify-content: center;
                padding: 15px;
            }

            .menu-item i {
                margin-right: 0;
            }

            .main-content {
                margin-left: 70px;
            }

            .header {
                flex-direction: column;
                gap: 15px;
            }

            .search-bar {
                width: 100%;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Dark Mode */
        body.dark-mode {
            --bg-light: #121212;
            --bg-card: #1e1e1e;
            --text-dark: #e0e0e0;
            --text-light: #a0a0a0;
            --border-light: #333;
            --dark: #f0f0f0;
        }

        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
        }

        body.dark-mode .header,
        body.dark-mode .stat-card,
        body.dark-mode .filter-section,
        body.dark-mode .table-container {
            background: var(--bg-card);
            color: var(--text-dark);
            border-color: var(--border-light);
        }

        body.dark-mode .table thead th {
            background: #252525;
            color: var(--text-dark);
            border-color: var(--border-light);
        }

        body.dark-mode .table tbody tr {
            border-color: var(--border-light);
        }

        body.dark-mode .table tbody tr:hover {
            background: #2a2a2a;
        }

        body.dark-mode .search-bar input,
        body.dark-mode .filter-group input,
        body.dark-mode .filter-group select {
            background: #2a2a2a;
            border-color: var(--border-light);
            color: var(--text-dark);
        }

        body.dark-mode .notification-btn,
        body.dark-mode .theme-toggle {
            background: #2a2a2a;
            color: var(--text-dark);
        }

        body.dark-mode .page-title h1 {
            color: var(--text-dark);
        }

        body.dark-mode .page-title p {
            color: var(--text-light);
        }

        body.dark-mode .stat-info p {
            color: var(--text-light);
        }

        body.dark-mode .filter-group label {
            color: var(--text-dark);
        }

        .menu-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            display: none;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-laptop-code"></i>
            </div>
            <h2>Admin TI</h2>
        </div>

        <div class="sidebar-menu">
            <a href="/admin/dashboard" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.dashboard') }}" class="menu-item">
                <i class="fas fa-hand-holding"></i>
                <span>Peminjaman</span>
            </a>
            <a href="/admin/pengembalian" class="menu-item active">
                <i class="fas fa-undo"></i>
                <span>Pengembalian</span>
            </a>
            <a href="/admin/riwayat" class="menu-item">
                <i class="fas fa-history"></i>
                <span>Riwayat Peminjaman</span>
            </a>
            <a href="/admin/feedback" class="menu-item">
                <i class="fas fa-comment"></i>
                <span>Feedback</span>
            </a>
            <a href="/admin/proyektor" class="menu-item">
                <i class="fas fa-video"></i>
                <span>Proyektor</span>
            </a>
            <a href="/admin/jadwalperkuliahan" class="menu-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Jadwal Perkuliahan</span>
            </a>
            <a href="/admin/ruangan" class="menu-item">
                <i class="fas fa-door-open"></i>
                <span>Ruangan</span>
            </a>
            <a href="/admin/slotwaktu" class="menu-item">
                <i class="fas fa-clock"></i>
                <span>Slot Waktu</span>
            </a>
            <a href="/admin/matakuliah" class="menu-item">
                <i class="fas fa-book"></i>
                <span>Matakuliah</span>
            </a>
            <a href="/admin/kelas" class="menu-item">
                <i class="fas fa-users"></i>
                <span>Kelas</span>
            </a>
            <a href="/admin/pengguna" class="menu-item">
                <i class="fas fa-users"></i>
                <span>Pengguna</span>
            </a>
            <a href="/admin/laporan" class="menu-item">
                <i class="fas fa-chart-bar"></i>
                <span>Statistik</span>
            </a>
            <a href="/admin/pengaturan" class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <form id="searchForm" method="GET" action="{{ route('admin.pengembalian') }}" class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Cari pengembalian..." value="{{ request('search') }}">
                <button type="submit" style="display: none;"></button>
            </form>

            <div class="user-actions">
                <div class="notification-btn">
                    <i class="fas fa-bell"></i>
                </div>

                <div class="theme-toggle" id="theme-toggle">
                    <i class="fas fa-moon"></i>
                </div>

                <div class="user-profile">
                    <div class="user-avatar">A</div>
                    <div>
                        <div>Admin Lab</div>
                        <div style="font-size: 0.8rem; color: var(--text-light);">Teknologi Informasi</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Title -->
        <div class="page-title">
            <div>
                <h1>Dashboard Pengembalian</h1>
                <p>Kelola proses pengembalian barang Lab Teknologi Informasi</p>
            </div>
            <div class="action-buttons">
                <button class="btn btn-outline">
                    <i class="fas fa-file-export"></i> Ekspor
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReturnModal">
                    <i class="fas fa-plus"></i> Tambah Pengembalian
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3 id="pending-count">{{ $pendingReturns ?? 0 }}</h3>
                    <p>Belum Dikembalikan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon returned">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="returned-count">{{ $returnedCount ?? 0 }}</h3>
                    <p>Sudah Dikembalikan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon overdue">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="overdue-count">{{ $overdueCount ?? 0 }}</h3>
                    <p>Terlambat</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div class="stat-info">
                    <h3 id="total-count">{{ $totalReturns ?? 0 }}</h3>
                    <p>Total Pengembalian</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form id="filterForm" method="GET" action="{{ route('admin.pengembalian') }}">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="search">Cari Peminjam/Barang</label>
                        <input type="text" id="search" name="search" placeholder="Cari..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="filter-group">
                        <label for="status_filter">Status Pengembalian</label>
                        <select id="status_filter" name="status">
                            <option value="">Semua Status</option>
                            <option value="belum_dikembalikan" {{ request('status') == 'belum_dikembalikan' ? 'selected' : '' }}>Belum Dikembalikan</option>
                            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="date_filter">Tanggal Pengembalian</label>
                        <input type="date" id="date_filter" name="date" value="{{ request('date') }}">
                    </div>
                    <div class="filter-group">
                        <label for="sort_filter">Urutkan</label>
                        <select id="sort_filter" name="sort">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="due_date" {{ request('sort') == 'due_date' ? 'selected' : '' }}>Tanggal Jatuh Tempo</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-filter me-1"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('admin.pengembalian') }}" class="btn btn-outline btn-sm">
                        <i class="fas fa-refresh me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Peminjam</th>
                            <th>Ruang & Barang</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Kondisi</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pengembalian-table-body">
                        @if(isset($pengembalians) && $pengembalians->count() > 0)
                            @foreach($pengembalians as $pengembalian)
                                <tr data-status="{{ $pengembalian->status }}" data-id="{{ $pengembalian->id }}">
                                    <td>{{ ($pengembalians->currentPage() - 1) * $pengembalians->perPage() + $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2"
                                                style="width: 30px; height: 30px; font-size: 0.8rem;">
                                                {{ substr($pengembalian->user->name ?? 'G', 0, 1) }}
                                            </div>
                                            {{ $pengembalian->user->name ?? 'Guest' }}
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $pengembalian->ruang }}</strong><br>
                                        <small class="text-muted">
                                            {{ $pengembalian->proyektor ? 'Dengan Proyektor' : 'Tanpa Proyektor' }}
                                        </small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($pengembalian->tanggal_pinjam)->format('d M Y') }}</td>
                                    <td>
                                        @if($pengembalian->tanggal_kembali)
                                            {{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d M Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($pengembalian->status == 'dikembalikan')
                                            <span class="badge status-badge status-dikembalikan">Dikembalikan</span>
                                        @elseif($pengembalian->status == 'terlambat')
                                            <span class="badge status-badge status-terlambat">Terlambat</span>
                                        @else
                                            <span class="badge status-badge status-belum-dikembalikan">Belum Dikembalikan</span>
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
                                    <td title="{{ $pengembalian->catatan ?? '-' }}">
                                        {{ \Illuminate\Support\Str::limit($pengembalian->catatan ?? '-', 30) }}
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 action-buttons">
                                            @if ($pengembalian->status != 'dikembalikan')
                                                <button class="btn btn-success-custom btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#returnModal" 
                                                    data-id="{{ $pengembalian->id }}"
                                                    data-peminjam="{{ $pengembalian->user->name ?? 'Guest' }}"
                                                    data-barang="{{ $pengembalian->ruang }} - {{ $pengembalian->proyektor ? 'Dengan Proyektor' : 'Tanpa Proyektor' }}"
                                                    data-tanggal-pinjam="{{ $pengembalian->tanggal_pinjam }}"
                                                    data-tanggal-jatuh-tempo="{{ $pengembalian->tanggal_pinjam }}">
                                                    <i class="fas fa-undo me-1"></i> Kembalikan
                                                </button>
                                            @endif

                                            <!-- Tombol Detail -->
                                            <button class="btn btn-info-custom btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#detailModal" 
                                                data-id="{{ $pengembalian->id }}"
                                                data-peminjam="{{ $pengembalian->user->name ?? 'Guest' }}"
                                                data-barang="{{ $pengembalian->ruang }} - {{ $pengembalian->proyektor ? 'Dengan Proyektor' : 'Tanpa Proyektor' }}"
                                                data-tanggal-pinjam="{{ $pengembalian->tanggal_pinjam }}"
                                                data-tanggal-jatuh-tempo="{{ $pengembalian->tanggal_pinjam }}"
                                                data-tanggal-kembali="{{ $pengembalian->tanggal_kembali }}"
                                                data-kondisi="{{ $kondisi }}"
                                                data-keterangan="{{ $pengembalian->catatan }}"
                                                data-status="{{ $pengembalian->status }}">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.pengembalian.destroy', $pengembalian->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger-custom btn-sm">
                                                    <i class="fas fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="empty-state">
                                    <i class="fas fa-inbox"></i><br>
                                    Belum ada data pengembalian
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if(isset($pengembalians) && $pengembalians->hasPages())
            <div class="pagination-container">
                <nav>
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($pengembalians->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Sebelumnya</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $pengembalians->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">Sebelumnya</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($pengembalians->getUrlRange(1, $pengembalians->lastPage()) as $page => $url)
                            @if ($page == $pengembalians->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $url }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($pengembalians->hasMorePages())
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $pengembalians->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">Selanjutnya</a>
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

        <!-- Modal Kembalikan Barang -->
        <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="returnModalLabel"><i class="fas fa-undo me-2"></i> Proses Pengembalian</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form id="returnForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Peminjam</label>
                                <input type="text" class="form-control" id="return_peminjam" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Barang</label>
                                <input type="text" class="form-control" id="return_barang" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pinjam</label>
                                <input type="text" class="form-control" id="return_tanggal_pinjam" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Jatuh Tempo</label>
                                <input type="text" class="form-control" id="return_tanggal_jatuh_tempo" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="kondisi_barang" class="form-label">Kondisi Barang</label>
                                <select class="form-select" id="kondisi_barang" name="kondisi_barang" required>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Pengembalian</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Detail Pengembalian -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel"><i class="fas fa-eye me-2"></i> Detail Pengembalian</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Peminjam</label>
                                <p id="detail_peminjam"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Barang</label>
                                <p id="detail_barang"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Pinjam</label>
                                <p id="detail_tanggal_pinjam"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Jatuh Tempo</label>
                                <p id="detail_tanggal_jatuh_tempo"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Kembali</label>
                                <p id="detail_tanggal_kembali"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <p id="detail_status"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kondisi Barang</label>
                                <p id="detail_kondisi"></p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Keterangan</label>
                                <p id="detail_keterangan"></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Pengembalian -->
        <div class="modal fade" id="addReturnModal" tabindex="-1" aria-labelledby="addReturnModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addReturnModalLabel"><i class="fas fa-plus me-2"></i> Tambah Pengembalian</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.pengembalian.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="peminjaman_id" class="form-label">Pilih Peminjaman</label>
                                <select class="form-select" id="peminjaman_id" name="peminjaman_id" required>
                                    <option value="">-- Pilih Peminjaman --</option>
                                    <!-- Data peminjaman akan diisi dari backend -->
                                    @if(isset($peminjamansAktif) && $peminjamansAktif->count() > 0)
                                        @foreach($peminjamansAktif as $peminjaman)
                                            <option value="{{ $peminjaman->id }}">
                                                {{ $peminjaman->user->name ?? 'Guest' }} - {{ $peminjaman->ruang }} ({{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d M Y') }})
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>Tidak ada peminjaman aktif</option>
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="add_kondisi_barang" class="form-label">Kondisi Barang</label>
                                <select class="form-select" id="add_kondisi_barang" name="kondisi_barang" required>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="add_keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="add_keterangan" name="keterangan" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Pengembalian</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="menu-toggle" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Toggle theme
            const themeToggle = document.getElementById('theme-toggle');
            themeToggle.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');

                if (document.body.classList.contains('dark-mode')) {
                    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                    localStorage.setItem('darkMode', 'enabled');
                } else {
                    themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                    localStorage.setItem('darkMode', 'disabled');
                }
            });

            // Toggle sidebar on mobile
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.querySelector('.sidebar');

            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });

            // Auto-submit form search ketika mengetik (dengan debounce)
            let searchTimeout;
            const searchInputs = document.querySelectorAll('input[name="search"]');

            searchInputs.forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        console.log('Auto-submitting search:', this.value);
                        // Submit form yang sesuai
                        const form = this.closest('form');
                        if (form) {
                            form.submit();
                        }
                    }, 800);
                });
            });

            // Auto-submit filter ketika perubahan select box
            const filterSelects = document.querySelectorAll('#filterForm select');
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    console.log('Filter changed:', this.name, this.value);
                    document.getElementById('filterForm').submit();
                });
            });

            // Tangani date filter change
            const dateFilter = document.getElementById('date_filter');
            if (dateFilter) {
                dateFilter.addEventListener('change', function() {
                    console.log('Date filter changed:', this.value);
                    document.getElementById('filterForm').submit();
                });
            }

            // Handler untuk modal pengembalian
            const returnModal = document.getElementById('returnModal');
            if (returnModal) {
                returnModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const peminjam = button.getAttribute('data-peminjam');
                    const barang = button.getAttribute('data-barang');
                    const tanggalPinjam = button.getAttribute('data-tanggal-pinjam');
                    const tanggalJatuhTempo = button.getAttribute('data-tanggal-jatuh-tempo');

                    // Update form action
                    const form = document.getElementById('returnForm');
                    form.action = `/admin/pengembalian/${id}/kembalikan`;

                    // Isi form dengan data yang ada
                    document.getElementById('return_peminjam').value = peminjam;
                    document.getElementById('return_barang').value = barang;
                    document.getElementById('return_tanggal_pinjam').value = formatDate(tanggalPinjam);
                    document.getElementById('return_tanggal_jatuh_tempo').value = formatDate(tanggalJatuhTempo);
                });
            }

            // Handler untuk modal detail
            const detailModal = document.getElementById('detailModal');
            if (detailModal) {
                detailModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const peminjam = button.getAttribute('data-peminjam');
                    const barang = button.getAttribute('data-barang');
                    const tanggalPinjam = button.getAttribute('data-tanggal-pinjam');
                    const tanggalJatuhTempo = button.getAttribute('data-tanggal-jatuh-tempo');
                    const tanggalKembali = button.getAttribute('data-tanggal-kembali');
                    const kondisi = button.getAttribute('data-kondisi');
                    const keterangan = button.getAttribute('data-keterangan');
                    const status = button.getAttribute('data-status');

                    // Isi data detail
                    document.getElementById('detail_peminjam').textContent = peminjam;
                    document.getElementById('detail_barang').textContent = barang;
                    document.getElementById('detail_tanggal_pinjam').textContent = formatDate(tanggalPinjam);
                    document.getElementById('detail_tanggal_jatuh_tempo').textContent = formatDate(tanggalJatuhTempo);
                    document.getElementById('detail_tanggal_kembali').textContent = tanggalKembali ? formatDate(tanggalKembali) : '-';
                    document.getElementById('detail_kondisi').textContent = kondisi || '-';
                    document.getElementById('detail_keterangan').textContent = keterangan || '-';
                    
                    // Format status
                    let statusText = '';
                    if (status === 'dikembalikan') {
                        statusText = '<span class="badge status-dikembalikan">Dikembalikan</span>';
                    } else if (status === 'terlambat') {
                        statusText = '<span class="badge status-terlambat">Terlambat</span>';
                    } else {
                        statusText = '<span class="badge status-belum-dikembalikan">Belum Dikembalikan</span>';
                    }
                    document.getElementById('detail_status').innerHTML = statusText;
                });
            }

            // Konfirmasi untuk semua aksi (kecuali form filter dan search)
            document.querySelectorAll('form').forEach(form => {
                if (form.id !== 'filterForm' && form.id !== 'searchForm') {
                    form.addEventListener('submit', function(e) {
                        const button = this.querySelector('button[type="submit"]');
                        const actionText = button.textContent.trim();

                        if (!confirm(`Apakah Anda yakin ingin ${actionText.toLowerCase()} data ini?`)) {
                            e.preventDefault();
                        }
                    });
                }
            });

            // Terapkan dark mode jika sebelumnya diaktifkan
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            }

            // Format tanggal
            function formatDate(dateString) {
                if (!dateString) return '-';
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }

            // Tampilkan parameter filter yang aktif
            function showActiveFilters() {
                const urlParams = new URLSearchParams(window.location.search);
                const activeFilters = [];

                if (urlParams.get('search')) {
                    activeFilters.push(`Pencarian: "${urlParams.get('search')}"`);
                }
                if (urlParams.get('status')) {
                    const statusText = {
                        'belum_dikembalikan': 'Belum Dikembalikan',
                        'dikembalikan': 'Dikembalikan',
                        'terlambat': 'Terlambat'
                    } [urlParams.get('status')] || urlParams.get('status');
                    activeFilters.push(`Status: ${statusText}`);
                }
                if (urlParams.get('date')) {
                    activeFilters.push(`Tanggal: ${urlParams.get('date')}`);
                }
                if (urlParams.get('sort')) {
                    const sortText = {
                        'newest': 'Terbaru',
                        'oldest': 'Terlama',
                        'due_date': 'Tanggal Jatuh Tempo'
                    } [urlParams.get('sort')] || urlParams.get('sort');
                    activeFilters.push(`Urutan: ${sortText}`);
                }

                if (activeFilters.length > 0) {
                    // Hapus alert existing jika ada
                    const existingAlert = document.querySelector('.filter-alert');
                    if (existingAlert) {
                        existingAlert.remove();
                    }

                    const filterInfo = document.createElement('div');
                    filterInfo.className = 'alert alert-info alert-dismissible fade show mt-3 filter-alert';
                    filterInfo.innerHTML = `
                        <strong>Filter Aktif:</strong> ${activeFilters.join(', ')}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.querySelector('.filter-section').appendChild(filterInfo);
                }
            }

            // Panggil fungsi saat halaman dimuat
            document.addEventListener('DOMContentLoaded', function() {
                showActiveFilters();

                // Debug: Tampilkan jumlah data yang difilter
                const tableRows = document.querySelectorAll('tbody tr');
                console.log('Jumlah data yang ditampilkan:', tableRows.length);
            });
        </script>
    </div>
</body>
</html>