@extends('layouts.public')
@section('title', 'Login Pelanggan')

@section('content')
<div class="container py-3">

    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    
                    <!-- Header -->
                    <div class="text-center mb-3">
                        <h5 class="fw-bold text-dark mb-1">Masuk</h5>
                        <p class="text-muted small mb-0">Sistem Grosir</p>
                    </div>

                    <!-- Error Handling-->
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 border-start border-4 border-danger rounded-0 mb-3 py-2 shadow-sm">
                            <ul class="mb-0 text-start small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('konsumen.login.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small mb-1">No HP</label>
                           
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control bg-light border-0 rounded-3 shadow-none" required autofocus>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small mb-1">Password</label>
                            <input type="password" name="password" class="form-control bg-light border-0 rounded-3 shadow-none" required>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input border-secondary shadow-none" id="remember">
                            <label class="form-check-label text-secondary small" for="remember">Ingat saya</label>
                        </div>
                        
                        <!-- Tombol -->
                        <button type="submit" class="btn btn-primary w-100 fw-bold rounded- shadow-sm py-2">
                            LOGIN
                        </button>
                    </form>

                    <!-- Footer-->
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted small mb-0">
                            Belum punya akun? <a href="{{ route('konsumen.register') }}" class="text-primary fw-bold text-decoration-none">Daftar</a>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection