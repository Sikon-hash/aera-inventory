<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AERA Frozen Food - @yield('title','Inventory')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f1b35;
            --sidebar-width: 250px;
            --accent: #00b4d8;
            --accent-dark: #0096c7;
        }
        body { background: #f0f4f8; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            width: var(--sidebar-width); background: var(--sidebar-bg);
            min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100;
            display: flex; flex-direction: column;
        }
        .sidebar-brand {
            padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1);
            color: white; font-weight: 700; font-size: 1.1rem;
        }
        .sidebar-brand span { color: var(--accent); }
        .sidebar nav a {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 20px; color: rgba(255,255,255,0.7);
            text-decoration: none; font-size: 0.9rem; transition: all .2s;
        }
        .sidebar nav a:hover, .sidebar nav a.active {
            color: white; background: rgba(0,180,216,0.15);
            border-left: 3px solid var(--accent);
        }
        .sidebar nav a i { width: 18px; text-align: center; }
        .sidebar .nav-label {
            padding: 8px 20px; font-size: 0.7rem; text-transform: uppercase;
            letter-spacing: 1px; color: rgba(255,255,255,0.3); margin-top: 10px;
        }
        .main-content {
            margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column;
        }
        .topbar {
            background: white; padding: 12px 24px; border-bottom: 1px solid #e0e7ef;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }
        .page-content { padding: 24px; flex: 1; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .card-header { background: white; border-bottom: 1px solid #e0e7ef; font-weight: 600; padding: 16px 20px; }
        .stat-card { border-radius: 12px; padding: 20px; color: white; }
        .btn-primary { background: var(--accent-dark); border-color: var(--accent-dark); }
        .btn-primary:hover { background: var(--accent); border-color: var(--accent); }
        .badge-stok-aman { background: #d1fae5; color: #065f46; }
        .badge-stok-kritis { background: #fee2e2; color: #991b1b; }
        .table th { font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: .5px; color: #64748b; }
        .alert { border-radius: 10px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-snowflake me-2" style="color:var(--accent)"></i>
        AERA <span>Frozen</span>
    </div>
    <nav class="mt-2">
        <div class="nav-label">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Data Barang
        </a>

        @if(auth()->user()->isAdmin())
        <div class="nav-label">Transaksi</div>
        <a href="{{ route('barang-masuk.index') }}" class="{{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}">
            <i class="fas fa-arrow-circle-down"></i> Barang Masuk
        </a>
        <a href="{{ route('barang-keluar.index') }}" class="{{ request()->routeIs('barang-keluar.*') ? 'active' : '' }}">
            <i class="fas fa-arrow-circle-up"></i> Barang Keluar
        </a>
        <a href="{{ route('supplier.index') }}" class="{{ request()->routeIs('supplier.*') ? 'active' : '' }}">
            <i class="fas fa-truck"></i> Supplier
        </a>
        <a href="{{ route('stock-opname.index') }}" class="{{ request()->routeIs('stock-opname.*') ? 'active' : '' }}">
            <i class="fas fa-clipboard-check"></i> Stock Opname
        </a>
        @endif

        <div class="nav-label">Laporan</div>
        <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Laporan
        </a>

        @if(auth()->user()->isOwner())
        <div class="nav-label">Manajemen</div>
        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Pengguna
        </a>
        @endif
    </nav>
    <div class="mt-auto p-3" style="border-top:1px solid rgba(255,255,255,.1)">
        <small style="color:rgba(255,255,255,.4)">Login sebagai</small>
        <div style="color:white; font-size:.9rem">{{ auth()->user()->name }}</div>
        <small style="color:var(--accent)">{{ auth()->user()->role->nama_role }}</small>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <h6 class="mb-0 fw-600">@yield('title','Dashboard')</h6>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-user-circle me-1"></i> Profil
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle me-2"></i>
                @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>