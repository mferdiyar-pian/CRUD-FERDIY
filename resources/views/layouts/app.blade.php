<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Peminjaman Barang - Lab TIK')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h2>Lab TIK</h2>
            </div>
            
            <div class="sidebar-menu">
                <a href="{{ url('/dashboard') }}" class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ url('/items') }}" class="menu-item {{ Request::is('items*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <span>Inventaris Barang</span>
                </a>
                <a href="{{ url('/loans') }}" class="menu-item {{ Request::is('loans*') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding"></i>
                    <span>Peminjaman</span>
                </a>
                <a href="{{ url('/returns') }}" class="menu-item {{ Request::is('returns*') ? 'active' : '' }}">
                    <i class="fas fa-undo"></i>
                    <span>Pengembalian</span>
                </a>
                
                @auth
                <a href="{{ url('/users') }}" class="menu-item {{ Request::is('users*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Pengguna</span>
                </a>
                @endauth
                
                <a href="{{ url('/reports') }}" class="menu-item {{ Request::is('reports*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
                <a href="{{ url('/settings') }}" class="menu-item {{ Request::is('settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari barang, peminjam, atau lainnya...">
                </div>
                
                <div class="user-actions">
                    <div class="notification-btn">
                        <i class="fas fa-bell"></i>
                    </div>
                    
                    <div class="theme-toggle" id="theme-toggle">
                        <i class="fas fa-moon"></i>
                    </div>
                    
                    <div class="user-profile">
                        <div class="user-avatar">
                            @auth
                                {{ substr(Auth::user()->name, 0, 2) }}
                            @else
                                GU
                            @endauth
                        </div>
                        <div>
                            @auth
                                <div>{{ Auth::user()->name }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-light);">Administrator</div>
                            @else
                                <div>Guest User</div>
                                <div style="font-size: 0.8rem; color: var(--text-light);">Silakan login</div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <div class="menu-toggle" id="menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>