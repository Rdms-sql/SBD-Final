@extends('layouts.app')
@section('title', 'Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Data Supplier</h4>
    <a href="{{ route('supplier.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Supplier
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Nama Supplier</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->nama_supplier }}</td>
                        <td>{{ $supplier->no_hp ?? '-' }}</td>
                        <td>{{ $supplier->alamat ?? '-' }}</td>
                        <td>
                            <a href="{{ route('supplier.show', $supplier) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('supplier.edit', $supplier) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('supplier.destroy', $supplier) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus supplier ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data supplier</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $suppliers->links() }}
</div>
@endsection