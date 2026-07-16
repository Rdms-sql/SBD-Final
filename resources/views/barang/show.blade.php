@extends('layouts.app')
@section('title', 'Detail Barang')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between">
        Detail Barang
        <a href="{{ route('barang.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><th style="width: 200px;">Nama Barang</th><td>: {{ $barang->nama_barang }}</td></tr>
            <tr><th>Supplier</th><td>: {{ $barang->supplier->nama_supplier ?? '-' }}</td></tr>
            <tr><th>Harga Jual</th><td>: Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td></tr>
            <tr><th>Stok</th><td>: {{ $barang->stok }}</td></tr>
        </table>
    </div>
</div>
@endsection