<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peminjaman - Sistem Manajemen Peminjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --warning: #f9c74f;
            --warning-dark: #f8961e;
            --light: #f8f9fa;
            --dark: #212529;
            --border-radius: 12px;
            --box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        body {
            background-color: #f5f7fb;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 2rem;
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
        }
        
        .btn-warning-custom {
            background: linear-gradient(135deg, var(--warning), var(--warning-dark));
            color: #000;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-warning-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(249, 199, 79, 0.4);
            color: #000;
        }
        
        .btn-secondary-custom {
            background: #6c757d;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-secondary-custom:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .input-icon .form-control, .input-icon .form-select {
            padding-left: 45px;
        }
        
        .header-section {
            background: linear-gradient(135deg, var(--warning), var(--warning-dark));
            color: #000;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        @media (max-width: 768px) {
            .card-custom {
                margin: 0 10px;
            }
            
            .header-section {
                border-radius: 0;
                margin: 0 -12px 2rem;
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
                        <a class="nav-link" href="{{ route('user.peminjaman.index') }}"><i class="fas fa-list me-1"></i> Daftar Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.peminjaman.create') }}"><i class="fas fa-plus-circle me-1"></i> Tambah Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-edit me-1"></i> Edit Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.peminjaman.riwayat') }}">
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

    <div class="container">
        <!-- Header -->
        <div class="header-section">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Data Peminjaman</h2>
                    <p class="mb-0">Perbarui informasi peminjaman sesuai kebutuhan</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('user.peminjaman.index') }}" class="btn btn-dark">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Notifikasi -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Form Edit Peminjaman -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-custom">
                    <div class="card-body p-4">
                        <form action="{{ route('user.peminjaman.update', $peminjaman->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- Info Status -->
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="fas fa-info-circle fa-2x me-3"></i>
                                <div>
                                    <h6 class="mb-1">Status Peminjaman: 
                                        @if($peminjaman->status == 'pending')
                                            <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                                        @elseif($peminjaman->status == 'disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif($peminjaman->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </h6>
                                    <p class="mb-0">Terakhir diubah: {{ \Carbon\Carbon::parse($peminjaman->updated_at)->format('d M Y H:i') }}</p>
                                </div>
                            </div>

                            @if($peminjaman->status != 'pending')
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Perhatian:</strong> Hanya peminjaman dengan status "Menunggu" yang dapat diedit.
                                </div>
                            @endif
                            
                            <div class="mb-4">
                                <label class="form-label">Tanggal Peminjaman</label>
                                <div class="input-icon">
                                    <i class="fas fa-calendar-day"></i>
                                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $peminjaman->tanggal) }}" 
                                           {{ $peminjaman->status != 'pending' ? 'disabled' : '' }} required>
                                </div>
                                @error('tanggal')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Ruang</label>
                                <div class="input-icon">
                                    <i class="fas fa-door-open"></i>
                                    <input type="text" name="ruang" class="form-control" value="{{ old('ruang', $peminjaman->ruang) }}" 
                                           {{ $peminjaman->status != 'pending' ? 'disabled' : '' }} required>
                                </div>
                                @error('ruang')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Proyektor</label>
                                <div class="input-icon">
                                    <i class="fas fa-video"></i>
                                    <select name="proyektor" class="form-select" {{ $peminjaman->status != 'pending' ? 'disabled' : '' }} required>
                                        <option value="1" {{ old('proyektor', $peminjaman->proyektor) == '1' ? 'selected' : '' }}>Ya, butuh proyektor</option>
                                        <option value="0" {{ old('proyektor', $peminjaman->proyektor) == '0' ? 'selected' : '' }}>Tidak butuh proyektor</option>
                                    </select>
                                </div>
                                @error('proyektor')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Keperluan</label>
                                <div class="input-icon">
                                    <i class="fas fa-clipboard-list"></i>
                                    <textarea name="keperluan" class="form-control" rows="4" 
                                              {{ $peminjaman->status != 'pending' ? 'disabled' : '' }} required>{{ old('keperluan', $peminjaman->keperluan) }}</textarea>
                                </div>
                                @error('keperluan')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('user.peminjaman.index') }}" class="btn btn-secondary-custom me-md-2">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                @if($peminjaman->status == 'pending')
                                    <button type="submit" class="btn btn-warning-custom">
                                        <i class="fas fa-save me-2"></i>Perbarui Data
                                    </button>
                                @else
                                    <button type="button" class="btn btn-warning-custom" disabled>
                                        <i class="fas fa-ban me-2"></i>Tidak Dapat Edit
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Info Box -->
                <div class="card card-custom mt-4">
                    <div class="card-body">
                        <h5><i class="fas fa-history text-warning me-2"></i> Riwayat Peminjaman</h5>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle p-3 me-3">
                                <i class="fas fa-plus text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Data dibuat</h6>
                                <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($peminjaman->created_at)->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-3 me-3">
                                <i class="fas fa-edit text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Terakhir diubah</h6>
                                <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($peminjaman->updated_at)->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set tanggal minimum ke hari ini
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            const dateInput = document.querySelector('input[type="date"]');
            
            if (dateInput) {
                dateInput.setAttribute('min', today);
            }
            
            // Validasi form
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const ruang = document.querySelector('input[name="ruang"]').value;
                    const keperluan = document.querySelector('textarea[name="keperluan"]').value;
                    
                    if (ruang.trim() === '') {
                        e.preventDefault();
                        alert('Nama ruang tidak boleh kosong');
                        return false;
                    }
                    
                    if (keperluan.trim() === '') {
                        e.preventDefault();
                        alert('Keperluan tidak boleh kosong');
                        return false;
                    }

                    // Cek status peminjaman
                    const status = "{{ $peminjaman->status }}";
                    if (status !== 'pending') {
                        e.preventDefault();
                        alert('Tidak dapat mengedit peminjaman yang sudah disetujui atau ditolak');
                        return false;
                    }
                });
            }
        });
    </script>
</body>
</html>