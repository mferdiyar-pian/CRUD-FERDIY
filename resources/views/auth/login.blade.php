<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lab TIK</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="auth-container">
        <!-- Sidebar -->
        <div class="auth-sidebar">
            <div class="auth-logo">
                <div class="auth-logo-icon">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <div class="auth-logo-text">Lab TIK</div>
            </div>
            
            <div class="auth-features">
                <div class="auth-feature">
                    <i class="fas fa-laptop"></i>
                    <span>Kelola inventaris barang lab</span>
                </div>
                <div class="auth-feature">
                    <i class="fas fa-hand-holding"></i>
                    <span>Pantau peminjaman barang</span>
                </div>
                <div class="auth-feature">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan lengkap dan terperinci</span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="auth-content">
            <div class="auth-card">
                <div class="auth-title">
                    <h1>Login</h1>
                    <p>Masuk ke sistem peminjaman barang Lab TIK</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-error" style="background: #fee; color: #c33; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #fcc;">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success" style="background: #efe; color: #363; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #cfc;">
                        {{ session('success') }}
                    </div>
                @endif

                <form class="auth-form" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', 'admin@labtik.com') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Masukkan password">
                    </div>
                    
                    <button type="submit" class="auth-btn">Login</button>
                </form>
                
                <div class="auth-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle theme functionality
        const themeToggle = document.createElement('div');
        themeToggle.innerHTML = '<div style="position: fixed; top: 20px; right: 20px; width: 40px; height: 40px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000;"><i class="fas fa-moon"></i></div>';
        document.body.appendChild(themeToggle);
        
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            
            if (document.body.classList.contains('dark-mode')) {
                themeToggle.innerHTML = '<div style="position: fixed; top: 20px; right: 20px; width: 40px; height: 40px; border-radius: 50%; background: #2c3e50; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000;"><i class="fas fa-sun" style="color: #fff;"></i></div>';
                localStorage.setItem('darkMode', 'enabled');
            } else {
                themeToggle.innerHTML = '<div style="position: fixed; top: 20px; right: 20px; width: 40px; height: 40px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000;"><i class="fas fa-moon"></i></div>';
                localStorage.setItem('darkMode', 'disabled');
            }
        });
        
        // Terapkan dark mode jika sebelumnya diaktifkan
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
            themeToggle.innerHTML = '<div style="position: fixed; top: 20px; right: 20px; width: 40px; height: 40px; border-radius: 50%; background: #2c3e50; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000;"><i class="fas fa-sun" style="color: #fff;"></i></div>';
        }
    </script>
</body>
</html>