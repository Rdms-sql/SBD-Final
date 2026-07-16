@extends('layouts.app')
@section('title', 'Detail Pembelian')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white d-flex justify-content-between">
    Detail Transaksi Pembelian
        <div>
            <a href="{{ route('pembelian.cetak', $pembelian) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-printer"></i> Cetak Nota
            </a>
            <a href="{{ route('pembelian.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><th style="width: 200px;">Supplier</th><td>: {{ $pembelian->supplier->nama_supplier ?? '-' }}</td></tr>
            <tr><th>Tanggal</th><td>: {{ $pembelian->tgl_pembelian }}</td></tr>
            <tr><th>Diinput Oleh</th><td>: {{ $pembelian->user->nama_lengkap ?? '-' }}</td></tr>
            <tr><th>Status Bayar</th>
                <td>:
                    <span class="badge {{ $pembelian->status_bayar == 'lunas' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst(str_replace('_', ' ', $pembelian->status_bayar)) }}
                    </span>
                </td>
            </tr>
            <tr><th>Total Pembelian</th><td>: <strong>Rp {{ number_format($pembelian->total_beli, 0, ',', '.') }}</strong></td></tr>
        </table>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-header bg-white">Daftar Barang</div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Nama Barang</th><th>Jumlah</th><th>Harga Satuan</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
                @foreach ($pembelian->detail as $item)
                    <tr>
                        <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if ($pembelian->hutang)
<div class="card shadow-sm">
    <div class="card-header bg-white">Info Hutang Terkait</div>
    <div class="card-body">
        <p><strong>Sisa Hutang:</strong> Rp {{ number_format($pembelian->hutang->sisa_hutang, 0, ',', '.') }}</p>
        <p><strong>Jatuh Tempo:</strong> {{ $pembelian->hutang->jatuh_tempo ?? '-' }}</p>
        <a href="{{ route('hutang.show', $pembelian->hutang) }}" class="btn btn-sm btn-primary">Kelola Pembayaran Hutang</a>
    </div>
</div>
@endif
@endsection