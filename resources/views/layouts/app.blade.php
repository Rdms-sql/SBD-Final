<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Grosir Sembako</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS (nanti diisi/diganti di sini) -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>

<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-dark text-white" id="sidebar" style="width: 240px; min-height: 100vh;">
        <div class="p-3 border-bottom border-secondary">
            <h5 class="mb-0"><i class="bi bi-shop"></i> Grosir Sembako</h5>
        </div>
        <nav class="nav flex-column p-2">
            <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="text-secondary small px-2 mt-3 mb-1 text-uppercase">Master Data</div>
            <a href="{{ route('supplier.index') }}" class="nav-link text-white {{ request()->routeIs('supplier.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-truck"></i> Supplier
            </a>
            <a href="{{ route('konsumen.index') }}" class="nav-link text-white {{ request()->routeIs('konsumen.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-people"></i> Konsumen
            </a>
            <a href="{{ route('barang.index') }}" class="nav-link text-white {{ request()->routeIs('barang.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-box-seam"></i> Barang
            </a>

            <div class="text-secondary small px-2 mt-3 mb-1 text-uppercase">Pemesanan</div>
            <a href="{{ route('pemesanan-supplier.index') }}" class="nav-link text-white {{ request()->routeIs('pemesanan-supplier.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-cart-plus"></i> Pesan ke Supplier
            </a>
            <a href="{{ route('pemesanan-konsumen.index') }}" class="nav-link text-white {{ request()->routeIs('pemesanan-konsumen.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-cart-check"></i> Pesanan Konsumen
            </a>

            <div class="text-secondary small px-2 mt-3 mb-1 text-uppercase">Transaksi</div>
            <a href="{{ route('pembelian.index') }}" class="nav-link text-white {{ request()->routeIs('pembelian.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-bag-plus"></i> Pembelian
            </a>
            <a href="{{ route('penjualan.index') }}" class="nav-link text-white {{ request()->routeIs('penjualan.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-bag-check"></i> Penjualan
            </a>

            <div class="text-secondary small px-2 mt-3 mb-1 text-uppercase">Keuangan</div>
            <a href="{{ route('hutang.index') }}" class="nav-link text-white {{ request()->routeIs('hutang.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-graph-down-arrow"></i> Hutang
            </a>
            <a href="{{ route('piutang.index') }}" class="nav-link text-white {{ request()->routeIs('piutang.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-graph-up-arrow"></i> Piutang
            </a>

            <div class="text-secondary small px-2 mt-3 mb-1 text-uppercase">Retur</div>
            <a href="{{ route('retur-pembelian.index') }}" class="nav-link text-white {{ request()->routeIs('retur-pembelian.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-arrow-counterclockwise"></i> Retur Pembelian
            </a>
            <a href="{{ route('retur-penjualan.index') }}" class="nav-link text-white {{ request()->routeIs('retur-penjualan.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-arrow-clockwise"></i> Retur Penjualan
            </a>
            @if (Auth::user()->role === 'admin')
            <div class="text-secondary small px-2 mt-3 mb-1 text-uppercase">Laporan (Admin)</div>
                <a href="{{ route('user.index') }}" class="nav-link text-white {{ request()->routeIs('user.*') ? 'active bg-primary rounded' : '' }}">
                    <i class="bi bi-people-fill"></i> Manajemen User
                </a>
                <a href="{{ route('laporan.penjualan') }}" class="nav-link text-white {{ request()->routeIs('laporan.penjualan') ? 'active bg-primary rounded' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i> Laporan Penjualan
                </a>
                <a href="{{ route('laporan.pembelian') }}" class="nav-link text-white {{ request()->routeIs('laporan.pembelian') ? 'active bg-primary rounded' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i> Laporan Pembelian
                </a>
                <a href="{{ route('laporan.hutang-piutang') }}" class="nav-link text-white {{ request()->routeIs('laporan.hutang-piutang') ? 'active bg-primary rounded' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> Laporan Hutang/Piutang
                </a>
                <a href="{{ route('laporan.stok') }}" class="nav-link text-white {{ request()->routeIs('laporan.stok') ? 'active bg-primary rounded' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> Laporan Stok
                </a>
            @endif
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white border-bottom px-3">
            <span class="navbar-text fw-semibold">@yield('title', 'Dashboard')</span>
            <div class="ms-auto dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i> {{ Auth::user()->nama_lengkap }}
                    <span class="badge bg-secondary">{{ Auth::user()->role }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-gear"></i> Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>