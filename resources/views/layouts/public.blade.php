<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pesan Barang') - Grosir Sembako</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-3">
    <a href="{{ Auth::guard('konsumen')->check() ? route('pesanan-publik.create') : url('/') }}" class="navbar-brand mb-0 h1 text-decoration-none">
        <i class="bi bi-shop"></i> Grosir Sembako
    </a>

    <div class="ms-auto d-flex align-items-center gap-2">
        @guest('konsumen')
            <a href="{{ route('konsumen.login') }}" class="btn btn-outline-light btn-sm">Login</a>
            <a href="{{ route('konsumen.register') }}" class="btn btn-light btn-sm">Daftar</a>
        @else
            <a href="{{ route('pesanan-publik.create') }}" class="btn btn-outline-light btn-sm {{ request()->routeIs('pesanan-publik.create') ? 'active' : '' }}">
                <i class="bi bi-cart-plus"></i> Pesan Barang
            </a>
            <a href="{{ route('pesanan-saya.index') }}" class="btn btn-outline-light btn-sm {{ request()->routeIs('pesanan-saya.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Pesanan Saya
            </a>
            <span class="text-white ms-2 me-1">
                <i class="bi bi-person-circle"></i> {{ Auth::guard('konsumen')->user()->nama_konsumen }}
            </span>
            <form action="{{ route('konsumen.logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        @endguest
    </div>
</nav>

<div class="container py-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>