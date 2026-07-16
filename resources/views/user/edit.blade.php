@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">Edit User</div>
    <div class="card-body">
        <form action="{{ route('user.update', $user) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @if ($user->id === auth()->id())
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <small class="text-muted">Anda tidak bisa mengubah role akun sendiri.</small>
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection