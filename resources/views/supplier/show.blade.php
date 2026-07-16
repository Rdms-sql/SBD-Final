@extends('layouts.app')
@section('title', 'Detail Supplier')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white d-flex justify-content-between">
        Detail Supplier
        <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><th style="width: 200px;">Nama Supplier</th><td>: {{ $supplier->nama_supplier }}</td></tr>
            <tr><th>No HP</th><td>: {{ $supplier->no_hp ?? '-' }}</td></tr>
            <tr><th>Alamat</th><td>: {{ $supplier->alamat ?? '-' }}</td></tr>
        </table>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">Barang dari Supplier Ini</div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Nama Barang</th><th>Harga Jual</th><th>Stok</th></tr>
            </thead>
            <tbody>
                @forelse ($supplier->barangs as $barang)
                    <tr>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        <td>{{ $barang->stok }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Belum ada barang</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection