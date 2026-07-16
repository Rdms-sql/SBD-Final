@extends('layouts.app')
@section('title', 'Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Data Barang</h4>
    <a href="{{ route('barang.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Barang
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Supplier</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $barang)
                    <tr>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->supplier->nama_supplier ?? '-' }}</td>
                        <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $barang->stok <= 10 ? 'bg-warning text-dark' : 'bg-success' }}">
                                {{ $barang->stok }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('barang.show', $barang) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('barang.edit', $barang) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('barang.destroy', $barang) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus barang ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada data barang</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $barangs->links() }}
</div>
@endsection