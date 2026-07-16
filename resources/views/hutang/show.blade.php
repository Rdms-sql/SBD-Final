@extends('layouts.app')
@section('title', 'Detail Hutang')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white d-flex justify-content-between">
        Detail Hutang
        <a href="{{ route('hutang.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><th style="width: 200px;">Supplier</th><td>: {{ $hutang->pembelian->supplier->nama_supplier ?? '-' }}</td></tr>
            <tr><th>Tanggal Pembelian</th><td>: {{ $hutang->pembelian->tgl_pembelian ?? '-' }}</td></tr>
            <tr><th>Total Pembelian</th><td>: Rp {{ number_format($hutang->pembelian->total_beli ?? 0, 0, ',', '.') }}</td></tr>
            <tr><th>Sisa Hutang</th><td>: <strong class="text-danger">Rp {{ number_format($hutang->sisa_hutang, 0, ',', '.') }}</strong></td></tr>
            <tr><th>Jatuh Tempo</th><td>: {{ $hutang->jatuh_tempo ?? '-' }}</td></tr>
        </table>
        <a href="{{ route('pembelian.show', $hutang->pembelian) }}" class="btn btn-sm btn-outline-primary">Lihat Detail Transaksi Pembelian</a>
    </div>
</div>

@if ($hutang->sisa_hutang > 0)
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white">Bayar Hutang</div>
    <div class="card-body">
        <form action="{{ route('hutang.bayar', $hutang) }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Tanggal Bayar</label>
                <input type="date" name="tgl_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jumlah Bayar</label>
                <input type="number" name="jumlah_bayar" class="form-control" min="1" max="{{ $hutang->sisa_hutang }}" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary w-100"><i class="bi bi-cash-coin"></i> Bayar Sekarang</button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-white">Riwayat Pembayaran</div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Tanggal Bayar</th><th>Jumlah Bayar</th></tr>
            </thead>
            <tbody>
                @forelse ($hutang->pembayaran as $bayar)
                    <tr>
                        <td>{{ $bayar->tgl_bayar }}</td>
                        <td>Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center text-muted py-3">Belum ada pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection