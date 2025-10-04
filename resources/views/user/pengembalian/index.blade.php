<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian - Sistem Peminjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --border-radius: 12px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
        }

        .card-custom {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
            margin-bottom: 1.5rem;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(67, 97, 238, 0.4);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .status-belum_dikembalikan {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-dikembalikan {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-terlambat {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .condition-baik {
            background-color: #d4edda;
            color: #155724;
        }

        .condition-rusak-ringan {
            background-color: #fff3cd;
            color: #856404;
        }

        .condition-rusak-berat {
            background-color: #f8d7da;
            color: #721c24;
        }

        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }

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

        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 8px;
            }
            
            .btn-sm {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
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
                        <a class="nav-link" href="{{ route('user.peminjaman.index') }}">
                            <i class="fas fa-list me-1"></i> Daftar Peminjaman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.peminjaman.create') }}">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Peminjaman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.peminjaman.riwayat') }}">
                            <i class="fas fa-history me-1"></i> Riwayat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('user.pengembalian.index') }}">
                            <i class="fas fa-undo me-1"></i> Pengembalian
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-undo text-primary me-2"></i> Pengembalian Peminjaman</h2>
                <p class="text-muted">Ajukan pengembalian ruangan dan proyektor yang telah digunakan</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('user.peminjaman.index') }}" class="btn btn-primary-custom">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Alert Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistik Ringkas -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                        <h4 class="mb-1">{{ $peminjamans->count() }}</h4>
                        <p class="text-muted mb-0">Peminjaman Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <h4 class="mb-1">{{ $pendingReturns ?? 0 }}</h4>
                        <p class="text-muted mb-0">Menunggu Pengembalian</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <i class="fas fa-undo fa-2x text-info mb-2"></i>
                        <h4 class="mb-1">{{ $returnedCount ?? 0 }}</h4>
                        <p class="text-muted mb-0">Telah Dikembalikan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                        <h4 class="mb-1">{{ $overdueCount ?? 0 }}</h4>
                        <p class="text-muted mb-0">Terlambat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peminjaman Aktif yang Bisa Dikembalikan -->
        <div class="card card-custom mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i> Peminjaman Aktif yang Dapat Dikembalikan</h5>
            </div>
            <div class="card-body">
                @if($peminjamans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="50">#</th>
                                    <th>Tanggal</th>
                                    <th>Ruang</th>
                                    <th>Waktu</th>
                                    <th width="100" class="text-center">Proyektor</th>
                                    <th>Keperluan</th>
                                    <th width="150" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjamans as $peminjaman)
                                    <tr>
                                        <td class="fw-bold">{{ $loop->iteration }}</td>
                                        <td>
                                            <i class="fas fa-calendar me-1 text-primary"></i>
                                            {{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d M Y') }}
                                        </td>
                                        <td>
                                            <i class="fas fa-door-open me-1 text-info"></i>
                                            {{ $peminjaman->ruang }}
                                        </td>
                                        <td>
                                            <i class="fas fa-clock me-1 text-success"></i>
                                            {{ $peminjaman->waktu_mulai ?? '08:00' }} - {{ $peminjaman->waktu_selesai ?? '17:00' }}
                                        </td>
                                        <td class="text-center">
                                            @if($peminjaman->proyektor)
                                                <span class="badge bg-success">Ya</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak</span>
                                            @endif
                                        </td>
                                        <td>{{ \Illuminate\Support\Str::limit($peminjaman->keperluan, 50) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('user.pengembalian.show', $peminjaman->id) }}" 
                                               class="btn btn-success btn-sm">
                                                <i class="fas fa-undo me-1"></i> Ajukan
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <h5 class="mt-3">Tidak ada peminjaman aktif</h5>
                        <p class="text-muted">Semua peminjaman sudah dikembalikan atau belum ada yang disetujui</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Riwayat Pengembalian -->
        <div class="card card-custom">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i> Riwayat Pengembalian</h5>
            </div>
            <div class="card-body">
                @if(isset($pengembalians) && $pengembalians->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="50">#</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Ruang</th>
                                    <th>Tanggal Kembali</th>
                                    <th width="100" class="text-center">Proyektor</th>
                                    <th width="120" class="text-center">Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengembalians as $pengembalian)
                                    <tr>
                                        <td class="fw-bold">{{ $loop->iteration }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($pengembalian->tanggal)->format('d M Y') }}
                                        </td>
                                        <td>{{ $pengembalian->ruang }}</td>
                                        <td>
                                            @if($pengembalian->tanggal_kembali)
                                                {{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d M Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($pengembalian->proyektor)
                                                <span class="badge bg-success">Ya</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($pengembalian->status == 'selesai')
                                                <span class="badge status-dikembalikan">Dikembalikan</span>
                                            @elseif($pengembalian->status == 'terlambat')
                                                <span class="badge status-terlambat">Terlambat</span>
                                            @else
                                                <span class="badge status-belum_dikembalikan">Belum Dikembalikan</span>
                                            @endif
                                        </td>
                                        <td>{{ $pengembalian->keterangan ? \Illuminate\Support\Str::limit($pengembalian->keterangan, 30) : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h5 class="mt-3">Belum ada riwayat pengembalian</h5>
                        <p class="text-muted">Riwayat pengembalian akan muncul di sini setelah Anda mengajukan pengembalian</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>