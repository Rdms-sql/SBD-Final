@extends('layouts.public')
@section('title', 'Login Pelanggan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-box-arrow-in-right"></i> Login Pelanggan</h5>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('konsumen.login.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    <button class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right"></i> Login</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    Belum punya akun? <a href="{{ route('konsumen.register') }}">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection