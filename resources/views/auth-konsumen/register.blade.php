@extends('layouts.public')
@section('title', 'Daftar Akun')

@section('content')
<div class="container py-2"> <!-- py-5 diubah ke py-2 untuk hemat ruang -->
    <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
        <div class="col-md-6 col-lg-4"> <!-- Lebar dipersempit agar lebih padat -->
            
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4"> <!-- p-sm-5 dipadatkan menjadi p-4 -->
                    
                    <!-- Header -->
                    <div class="text-center mb-3">
                        <h5 class="fw-bold text-dark mb-1">Daftar Akun</h5>
                        <p class="text-muted small m-0">Bergabung dengan sistem kami</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 small py-2 mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('konsumen.register.store') }}" method="POST">
                        @csrf
                        
                        <!-- Input fields dimampatkan (mb-3 jadi mb-2) -->
                        <div class="mb-2">
                            <label class="form-label fw-bold text-secondary small mb-0">Nama</label>
                            <input type="text" name="nama_konsumen" value="{{ old('nama_konsumen') }}" class="form-control form-control-sm bg-light border-0 rounded-3 shadow-none" required autofocus>
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-label fw-bold text-secondary small mb-0">No HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control form-control-sm bg-light border-0 rounded-3 shadow-none" required>
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-label fw-bold text-secondary small mb-0">Alamat</label>
                            <textarea name="alamat" class="form-control form-control-sm bg-light border-0 rounded-3 shadow-none" rows="1">{{ old('alamat') }}</textarea>
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-label fw-bold text-secondary small mb-0">Password</label>
                            <input type="password" name="password" class="form-control form-control-sm bg-light border-0 rounded-3 shadow-none" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small mb-0">Konfirmasi</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-sm bg-light border-0 rounded-3 shadow-none" required>
                        </div>
                        
                        <button class="btn btn-primary w-100 fw-bold rounded-3 shadow-sm py-2">
                            DAFTAR
                        </button>
                    </form>

                    <div class="text-center mt-3 pt-2 border-top">
                        <p class="text-muted small mb-0">
                            Sudah punya akun? <a href="{{ route('konsumen.login') }}" class="text-primary fw-bold text-decoration-none">Login</a>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection