@extends('layouts.app')
@section('title', 'Konsumen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Data Konsumen</h4>
    <a href="{{ route('konsumen.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Konsumen
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Nama Konsumen</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($konsumens as $konsumen)
                    <tr>
                        <td>{{ $konsumen->nama_konsumen }}</td>
                        <td>{{ $konsumen->no_hp ?? '-' }}</td>
                        <td>{{ $konsumen->alamat ?? '-' }}</td>
                        <td>
                            <a href="{{ route('konsumen.show', $konsumen) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('konsumen.edit', $konsumen) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('konsumen.destroy', $konsumen) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus konsumen ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data konsumen</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $konsumens->links() }}
</div>
@endsection