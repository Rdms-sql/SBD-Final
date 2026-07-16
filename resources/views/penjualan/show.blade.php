@extends('layouts.app')
@section('title', 'Detail Penjualan')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white d-flex justify-content-between">
    Detail Transaksi Penjualan
    <div>
        <a href="{{ route('penjualan.cetak', $penjualan) }}" target="_blank" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-printer"></i> Cetak Nota
        </a>
        <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
</div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><th style="width: 200px;">Konsumen</th><td>: {{ $penjualan->konsumen->nama_konsumen ?? '-' }}</td></tr>
            <tr><th>Tanggal</th><td>: {{ $penjualan->tgl_penjualan }}</td></tr>
            <tr><th>Diinput Oleh</th><td>: {{ $penjualan->user->nama_lengkap ?? '-' }}</td></tr>
            <tr><th>Status Bayar</th>
                <td>:
                    <span class="badge {{ $penjualan->status_bayar == 'lunas' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst(str_replace('_', ' ', $penjualan->status_bayar)) }}
                    </span>
                </td>
            </tr>
            <tr><th>Total Penjualan</th><td>: <strong>Rp {{ number_format($penjualan->total_jual, 0, ',', '.') }}</strong></td></tr>
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
                @foreach ($penjualan->detail as $item)
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

@if ($penjualan->piutang)
<div class="card shadow-sm">
    <div class="card-header bg-white">Info Piutang Terkait</div>
    <div class="card-body">
        <p><strong>Sisa Piutang:</strong> Rp {{ number_format($penjualan->piutang->sisa_piutang, 0, ',', '.') }}</p>
        <p><strong>Jatuh Tempo:</strong> {{ $penjualan->piutang->jatuh_tempo ?? '-' }}</p>
        <a href="{{ route('piutang.show', $penjualan->piutang) }}" class="btn btn-sm btn-primary">Kelola Penerimaan Piutang</a>
    </div>
</div>
@endif
@endsection