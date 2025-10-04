<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - Sistem Manajemen Peminjaman</title>
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

        .stat-icon.completed {
            background: #66bb6a;
        }

        .stat-icon.cancelled {
            background: #ef5350;
        }

        .stat-icon.ongoing {
            background: #ffb74d;
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

        .status-selesai {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-ditolak {
            background: #ffebee;
            color: #c62828;
        }

        .status-berlangsung {
            background: #e3f2fd;
            color: #1565c0;
        }

        .status-dikembalikan {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-belum-dikembalikan {
            background: #fff8e1;
            color: #ff8f00;
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

        .btn-edit-custom {
            background: #ffc107;
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
        .btn-info-custom:hover,
        .btn-edit-custom:hover {
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

        /* Timeline untuk riwayat */
        .timeline-item {
            border-left: 3px solid var(--primary);
            padding-left: 20px;
            margin-bottom: 20px;
            position: relative;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 0;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--primary);
        }

        .timeline-date {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .timeline-content {
            background: var(--bg-light);
            padding: 15px;
            border-radius: 6px;
            border: 1px solid var(--border-light);
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

        body.dark-mode .timeline-content {
            background: #2a2a2a;
            border-color: var(--border-light);
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
            <a href="/admin/pengembalian" class="menu-item">
                <i class="fas fa-undo"></i>
                <span>Pengembalian</span>
            </a>
            <a href="/admin/riwayat" class="menu-item active">
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
            <form id="searchForm" method="GET" action="{{ route('admin.riwayat') }}" class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Cari riwayat peminjaman..." value="{{ request('search') }}">
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
                <h1>Riwayat Peminjaman</h1>
                <p>Lihat dan kelola riwayat peminjaman barang Lab Teknologi Informasi</p>
            </div>
            <div class="action-buttons">
                <button class="btn btn-outline">
                    <i class="fas fa-file-export"></i> Ekspor
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fas fa-filter"></i> Filter Lanjutan
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon completed">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="completed-count">{{ $completedCount ?? 0 }}</h3>
                    <p>Selesai</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon cancelled">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="cancelled-count">{{ $cancelledCount ?? 0 }}</h3>
                    <p>Dibatalkan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon ongoing">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3 id="ongoing-count">{{ $ongoingCount ?? 0 }}</h3>
                    <p>Berlangsung</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div class="stat-info">
                    <h3 id="total-count">{{ $totalCount ?? 0 }}</h3>
                    <p>Total Riwayat</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form id="filterForm" method="GET" action="{{ route('admin.riwayat') }}">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="search">Cari Peminjam/Keperluan</label>
                        <input type="text" id="search" name="search" placeholder="Cari..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="filter-group">
                        <label for="status_filter">Status Peminjaman</label>
                        <select id="status_filter" name="status">
                            <option value="">Semua Status</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Berlangsung</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="date_from">Dari Tanggal</label>
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    <div class="filter-group">
                        <label for="date_to">Sampai Tanggal</label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-filter me-1"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('admin.riwayat') }}" class="btn btn-outline btn-sm">
                        <i class="fas fa-refresh me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabs untuk tampilan berbeda -->
        <ul class="nav nav-tabs mb-4" id="viewTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="table-tab" data-bs-toggle="tab" data-bs-target="#table-view" type="button" role="tab">
                    <i class="fas fa-table me-1"></i> Tabel
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline-view" type="button" role="tab">
                    <i class="fas fa-stream me-1"></i> Timeline
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="viewTabsContent">
            <!-- Table View -->
            <div class="tab-pane fade show active" id="table-view" role="tabpanel">
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Peminjam</th>
                                    <th>Tanggal</th>
                                    <th>Ruang</th>
                                    <th>Proyektor</th>
                                    <th>Keperluan</th>
                                    <th>Status</th>
                                    <th>Status Pengembalian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="riwayat-table-body">
                                @forelse($riwayat as $item)
                                    <tr data-status="{{ $item->status }}" data-id="{{ $item->id }}">
                                        <td>{{ ($riwayat->currentPage() - 1) * $riwayat->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-2"
                                                    style="width: 30px; height: 30px; font-size: 0.8rem;">
                                                    {{ substr($item->user->name ?? 'G', 0, 1) }}
                                                </div>
                                                {{ $item->user->name ?? 'Guest' }}
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                        <td>{{ $item->ruang }}</td>
                                        <td>
                                            @if ($item->proyektor)
                                                <span class="badge bg-success">Ya</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak</span>
                                            @endif
                                        </td>
                                        <td title="{{ $item->keperluan }}">
                                            {{ \Illuminate\Support\Str::limit($item->keperluan, 40) }}
                                        </td>
                                        <td>
                                            @if ($item->status == 'disetujui')
                                                <span class="badge status-badge status-selesai">Selesai</span>
                                            @elseif($item->status == 'ditolak')
                                                <span class="badge status-badge status-ditolak">Ditolak</span>
                                            @else
                                                <span class="badge status-badge status-berlangsung">Berlangsung</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->tanggal_kembali)
                                                <span class="badge status-badge status-dikembalikan">Dikembalikan</span>
                                            @else
                                                <span class="badge status-badge status-belum-dikembalikan">Belum Dikembalikan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 action-buttons">
                                                <!-- Tombol Detail -->
                                                <button class="btn btn-info-custom btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal" 
                                                    data-id="{{ $item->id }}"
                                                    data-peminjam="{{ $item->user->name ?? 'Guest' }}"
                                                    data-tanggal="{{ $item->tanggal }}"
                                                    data-ruang="{{ $item->ruang }}"
                                                    data-proyektor="{{ $item->proyektor ? 'Ya' : 'Tidak' }}"
                                                    data-keperluan="{{ $item->keperluan }}"
                                                    data-status="{{ $item->status }}"
                                                    data-status-pengembalian="{{ $item->tanggal_kembali ? 'Dikembalikan' : 'Belum Dikembalikan' }}"
                                                    data-keterangan="{{ $item->catatan ?? '-' }}">
                                                    <i class="fas fa-eye me-1"></i> Detail
                                                </button>

                                                <!-- Tombol Edit -->
                                                <button class="btn btn-edit-custom btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editModal" 
                                                    data-id="{{ $item->id }}"
                                                    data-peminjam="{{ $item->user->name ?? 'Guest' }}"
                                                    data-tanggal="{{ $item->tanggal }}"
                                                    data-ruang="{{ $item->ruang }}"
                                                    data-proyektor="{{ $item->proyektor ? '1' : '0' }}"
                                                    data-keperluan="{{ $item->keperluan }}"
                                                    data-status="{{ $item->status }}"
                                                    data-status-pengembalian="{{ $item->tanggal_kembali ? '1' : '0' }}"
                                                    data-keterangan="{{ $item->catatan ?? '' }}">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </button>

                                                <!-- Tombol Hapus -->
                                                <button class="btn btn-danger-custom btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal" 
                                                    data-id="{{ $item->id }}"
                                                    data-peminjam="{{ $item->user->name ?? 'Guest' }}"
                                                    data-tanggal="{{ $item->tanggal }}">
                                                    <i class="fas fa-trash me-1"></i> Hapus
                                                </button>

                                                <!-- Tombol Cetak -->
                                                <button class="btn btn-warning-custom btn-sm" onclick="cetakRiwayat({{ $item->id }})">
                                                    <i class="fas fa-print me-1"></i> Cetak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="empty-state">
                                            <i class="fas fa-inbox"></i><br>
                                            Belum ada data riwayat peminjaman
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($riwayat->hasPages())
                    <div class="pagination-container">
                        <nav>
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($riwayat->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Sebelumnya</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $riwayat->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">Sebelumnya</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
                                    @if ($page == $riwayat->currentPage())
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
                                @if ($riwayat->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $riwayat->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">Selanjutnya</a>
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

            <!-- Timeline View -->
            <div class="tab-pane fade" id="timeline-view" role="tabpanel">
                <div class="table-container p-4">
                    @forelse($riwayat as $item)
                        <div class="timeline-item">
                            <div class="timeline-date">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </div>
                            <div class="timeline-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Peminjam:</strong> {{ $item->user->name ?? 'Guest' }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Ruang:</strong> {{ $item->ruang }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Proyektor:</strong> {{ $item->proyektor ? 'Ya' : 'Tidak' }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Status:</strong> 
                                        @if ($item->status == 'disetujui')
                                            <span class="badge status-badge status-selesai">Selesai</span>
                                        @elseif($item->status == 'ditolak')
                                            <span class="badge status-badge status-ditolak">Ditolak</span>
                                        @else
                                            <span class="badge status-badge status-berlangsung">Berlangsung</span>
                                        @endif
                                    </div>
                                    <div class="col-12 mt-2">
                                        <strong>Keperluan:</strong> {{ $item->keperluan }}
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="d-flex gap-2 action-buttons">
                                            <button class="btn btn-info-custom btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#detailModal" 
                                                data-id="{{ $item->id }}"
                                                data-peminjam="{{ $item->user->name ?? 'Guest' }}"
                                                data-tanggal="{{ $item->tanggal }}"
                                                data-ruang="{{ $item->ruang }}"
                                                data-proyektor="{{ $item->proyektor ? 'Ya' : 'Tidak' }}"
                                                data-keperluan="{{ $item->keperluan }}"
                                                data-status="{{ $item->status }}"
                                                data-status-pengembalian="{{ $item->tanggal_kembali ? 'Dikembalikan' : 'Belum Dikembalikan' }}"
                                                data-keterangan="{{ $item->catatan ?? '-' }}">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </button>
                                            <button class="btn btn-edit-custom btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal" 
                                                data-id="{{ $item->id }}"
                                                data-peminjam="{{ $item->user->name ?? 'Guest' }}"
                                                data-tanggal="{{ $item->tanggal }}"
                                                data-ruang="{{ $item->ruang }}"
                                                data-proyektor="{{ $item->proyektor ? '1' : '0' }}"
                                                data-keperluan="{{ $item->keperluan }}"
                                                data-status="{{ $item->status }}"
                                                data-status-pengembalian="{{ $item->tanggal_kembali ? '1' : '0' }}"
                                                data-keterangan="{{ $item->catatan ?? '' }}">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </button>
                                            <button class="btn btn-danger-custom btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" 
                                                data-id="{{ $item->id }}"
                                                data-peminjam="{{ $item->user->name ?? 'Guest' }}"
                                                data-tanggal="{{ $item->tanggal }}">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                            <button class="btn btn-warning-custom btn-sm" onclick="cetakRiwayat({{ $item->id }})">
                                                <i class="fas fa-print me-1"></i> Cetak
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i><br>
                            Belum ada data riwayat peminjaman
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Modal Detail Riwayat -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel"><i class="fas fa-eye me-2"></i> Detail Riwayat Peminjaman</h5>
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
                                <label class="form-label fw-bold">Tanggal Peminjaman</label>
                                <p id="detail_tanggal"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ruang</label>
                                <p id="detail_ruang"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Proyektor</label>
                                <p id="detail_proyektor"></p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Keperluan</label>
                                <p id="detail_keperluan"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status Peminjaman</label>
                                <p id="detail_status"></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status Pengembalian</label>
                                <p id="detail_status_pengembalian"></p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Keterangan</label>
                                <p id="detail_keterangan"></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="cetakDetail()">
                            <i class="fas fa-print me-1"></i> Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Riwayat -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel"><i class="fas fa-edit me-2"></i> Edit Riwayat Peminjaman</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Peminjam</label>
                                    <input type="text" class="form-control" id="edit_peminjam" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Peminjaman</label>
                                    <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ruang</label>
                                    <input type="text" class="form-control" id="edit_ruang" name="ruang" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Proyektor</label>
                                    <select class="form-control" id="edit_proyektor" name="proyektor" required>
                                        <option value="0">Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Keperluan</label>
                                    <textarea class="form-control" id="edit_keperluan" name="keperluan" rows="3" required></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Status Peminjaman</label>
                                    <select class="form-control" id="edit_status" name="status" required>
                                        <option value="pending">Berlangsung</option>
                                        <option value="disetujui">Selesai</option>
                                        <option value="ditolak">Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Status Pengembalian</label>
                                    <select class="form-control" id="edit_status_pengembalian" name="tanggal_kembali">
                                        <option value="0">Belum Dikembalikan</option>
                                        <option value="1">Dikembalikan</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Keterangan</label>
                                    <textarea class="form-control" id="edit_keterangan" name="catatan" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Hapus Riwayat -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-trash me-2"></i> Hapus Riwayat Peminjaman</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus riwayat peminjaman ini?</p>
                            <div class="alert alert-warning">
                                <strong>Peminjam:</strong> <span id="delete_peminjam"></span><br>
                                <strong>Tanggal:</strong> <span id="delete_tanggal"></span>
                            </div>
                            <p class="text-danger">Tindakan ini tidak dapat dibatalkan!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
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

            // Handler untuk modal detail
            const detailModal = document.getElementById('detailModal');
            if (detailModal) {
                detailModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const peminjam = button.getAttribute('data-peminjam');
                    const tanggal = button.getAttribute('data-tanggal');
                    const ruang = button.getAttribute('data-ruang');
                    const proyektor = button.getAttribute('data-proyektor');
                    const keperluan = button.getAttribute('data-keperluan');
                    const status = button.getAttribute('data-status');
                    const statusPengembalian = button.getAttribute('data-status-pengembalian');
                    const keterangan = button.getAttribute('data-keterangan');

                    // Isi data detail
                    document.getElementById('detail_peminjam').textContent = peminjam;
                    document.getElementById('detail_tanggal').textContent = formatDate(tanggal);
                    document.getElementById('detail_ruang').textContent = ruang;
                    document.getElementById('detail_proyektor').textContent = proyektor;
                    document.getElementById('detail_keperluan').textContent = keperluan;
                    
                    // Format status
                    let statusText = '';
                    if (status === 'disetujui') {
                        statusText = '<span class="badge status-selesai">Selesai</span>';
                    } else if (status === 'ditolak') {
                        statusText = '<span class="badge status-ditolak">Ditolak</span>';
                    } else {
                        statusText = '<span class="badge status-berlangsung">Berlangsung</span>';
                    }
                    document.getElementById('detail_status').innerHTML = statusText;

                    // Format status pengembalian
                    let statusPengembalianText = '';
                    if (statusPengembalian === 'Dikembalikan') {
                        statusPengembalianText = '<span class="badge status-dikembalikan">Dikembalikan</span>';
                    } else {
                        statusPengembalianText = '<span class="badge status-belum-dikembalikan">Belum Dikembalikan</span>';
                    }
                    document.getElementById('detail_status_pengembalian').innerHTML = statusPengembalianText;

                    document.getElementById('detail_keterangan').textContent = keterangan || '-';
                });
            }

            // Handler untuk modal edit
            const editModal = document.getElementById('editModal');
            if (editModal) {
                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const peminjam = button.getAttribute('data-peminjam');
                    const tanggal = button.getAttribute('data-tanggal');
                    const ruang = button.getAttribute('data-ruang');
                    const proyektor = button.getAttribute('data-proyektor');
                    const keperluan = button.getAttribute('data-keperluan');
                    const status = button.getAttribute('data-status');
                    const statusPengembalian = button.getAttribute('data-status-pengembalian');
                    const keterangan = button.getAttribute('data-keterangan');

                    // Update form action URL
                    const form = document.getElementById('editForm');
                    form.action = `/admin/riwayat/${id}`;

                    // Isi data form
                    document.getElementById('edit_peminjam').value = peminjam;
                    document.getElementById('edit_tanggal').value = tanggal;
                    document.getElementById('edit_ruang').value = ruang;
                    document.getElementById('edit_proyektor').value = proyektor;
                    document.getElementById('edit_keperluan').value = keperluan;
                    document.getElementById('edit_status').value = status;
                    document.getElementById('edit_status_pengembalian').value = statusPengembalian;
                    document.getElementById('edit_keterangan').value = keterangan || '';
                });
            }

            // Handler untuk modal hapus
            const deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const peminjam = button.getAttribute('data-peminjam');
                    const tanggal = button.getAttribute('data-tanggal');

                    // Update form action URL
                    const form = document.getElementById('deleteForm');
                    form.action = `/admin/riwayat/${id}`;

                    // Isi data konfirmasi
                    document.getElementById('delete_peminjam').textContent = peminjam;
                    document.getElementById('delete_tanggal').textContent = formatDate(tanggal);
                });
            }

            // Format tanggal
            function formatDate(dateString) {
                if (!dateString) return '-';
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });
            }

            // Fungsi cetak riwayat
            function cetakRiwayat(id) {
                console.log('Mencetak riwayat dengan ID:', id);
                // Implementasi cetak riwayat
                alert(`Fitur cetak untuk riwayat ID ${id} akan segera tersedia!`);
            }

            function cetakDetail() {
                console.log('Mencetak detail riwayat');
                // Implementasi cetak detail
                alert('Fitur cetak detail akan segera tersedia!');
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
                        'disetujui': 'Selesai',
                        'ditolak': 'Ditolak',
                        'pending': 'Berlangsung'
                    }[urlParams.get('status')] || urlParams.get('status');
                    activeFilters.push(`Status: ${statusText}`);
                }
                if (urlParams.get('date_from') || urlParams.get('date_to')) {
                    const dateFrom = urlParams.get('date_from') || '';
                    const dateTo = urlParams.get('date_to') || '';
                    activeFilters.push(`Periode: ${dateFrom} - ${dateTo}`);
                }

                if (activeFilters.length > 0) {
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

                // Terapkan dark mode jika sebelumnya diaktifkan
                if (localStorage.getItem('darkMode') === 'enabled') {
                    document.body.classList.add('dark-mode');
                    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                }
            });
        </script>
    </div>
</body>
</html>