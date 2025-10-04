<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Pengembalian - Sistem Peminjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('peminjaman.index') }}">
                <i class="fas fa-calendar-check me-2"></i>
                Sistem Peminjaman
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-undo me-2"></i> Ajukan Pengembalian</h4>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Peminjaman -->
                        <div class="alert alert-info">
                            <h5>Informasi Peminjaman</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Ruang:</strong> {{ $peminjaman->ruang }}</p>
                                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d M Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Waktu:</strong> {{ $peminjaman->waktu_mulai }} - {{ $peminjaman->waktu_selesai }}</p>
                                    <p><strong>Proyektor:</strong> {{ $peminjaman->proyektor ? 'Ya' : 'Tidak' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Pengembalian -->
                        <form action="{{ route('pengembalian.ajukan', $peminjaman->id) }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Kondisi Ruang Setelah Digunakan</label>
                                <select class="form-select" name="kondisi_ruang" required>
                                    <option value="">Pilih Kondisi Ruang</option>
                                    <option value="baik">Baik</option>
                                    <option value="rusak-ringan">Rusak Ringan</option>
                                    <option value="rusak-berat">Rusak Berat</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan Pengembalian</label>
                                <textarea class="form-control" name="catatan" rows="3" 
                                          placeholder="Tambahkan catatan mengenai kondisi ruang/proyektor setelah digunakan..."></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('pengembalian.user') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane me-1"></i> Ajukan Pengembalian
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>