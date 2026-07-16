@extends('layouts.app')
@section('title', 'Detail Piutang')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white d-flex justify-content-between">
        Detail Piutang
        <a href="{{ route('piutang.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><th style="width: 200px;">Konsumen</th><td>: {{ $piutang->penjualan->konsumen->nama_konsumen ?? '-' }}</td></tr>
            <tr><th>Tanggal Penjualan</th><td>: {{ $piutang->penjualan->tgl_penjualan ?? '-' }}</td></tr>
            <tr><th>Total Penjualan</th><td>: Rp {{ number_format($piutang->penjualan->total_jual ?? 0, 0, ',', '.') }}</td></tr>
            <tr><th>Sisa Piutang</th><td>: <strong class="text-success">Rp {{ number_format($piutang->sisa_piutang, 0, ',', '.') }}</strong></td></tr>
            <tr><th>Jatuh Tempo</th><td>: {{ $piutang->jatuh_tempo ?? '-' }}</td></tr>
        </table>
        <a href="{{ route('penjualan.show', $piutang->penjualan) }}" class="btn btn-sm btn-outline-primary">Lihat Detail Transaksi Penjualan</a>
    </div>
</div>

@if ($piutang->sisa_piutang > 0)
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white">Terima Pembayaran Piutang</div>
    <div class="card-body">
        <form action="{{ route('piutang.terima', $piutang) }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Tanggal Terima</label>
                <input type="date" name="tgl_terima" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jumlah Terima</label>
                <input type="number" name="jumlah_terima" class="form-control" min="1" max="{{ $piutang->sisa_piutang }}" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary w-100"><i class="bi bi-cash-coin"></i> Terima Sekarang</button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-white">Riwayat Penerimaan</div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Tanggal Terima</th><th>Jumlah Terima</th></tr>
            </thead>
            <tbody>
                @forelse ($piutang->penerimaan as $terima)
                    <tr>
                        <td>{{ $terima->tgl_terima }}</td>
                        <td>Rp {{ number_format($terima->jumlah_terima, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center text-muted py-3">Belum ada penerimaan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection