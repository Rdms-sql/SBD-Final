@extends('layouts.app')
@section('title', 'Manajemen User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Manajemen User Staff</h4>
    <a href="{{ route('user.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah User
    </a>
</div>

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            {{ $user->nama_lengkap }}
                            @if ($user->id === auth()->id())
                                <span class="badge bg-info text-dark">Anda</span>
                            @endif
                        </td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role == 'admin' ? 'bg-dark' : 'bg-secondary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('user.edit', $user) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('user.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada user</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $users->links() }}
</div>
@endsection