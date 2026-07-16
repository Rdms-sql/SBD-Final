@extends('layouts.app')
@section('title', 'Laporan Hutang & Piutang')

@section('content')
<h4 class="mb-3">Laporan Hutang & Piutang</h4>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card text-bg-danger shadow-sm">
            <div class="card-body">
                <div class="small">Total Hutang Aktif</div>
                <div class="fs-4 fw-bold">Rp {{ number_format($totalHutang, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-bg-success shadow-sm">
            <div class="card-body">
                <div class="small">Total Piutang Aktif</div>
                <div class="fs-4 fw-bold">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span><i class="bi bi-graph-down-arrow text-danger"></i> Daftar Hutang ke Supplier</span>
        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer"></i> Cetak</button>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Supplier</th><th>Tanggal Pembelian</th><th>Sisa Hutang</th><th>Jatuh Tempo</th></tr>
            </thead>
            <tbody>
                @forelse ($hutangs as $hutang)
                    <tr>
                        <td>{{ $hutang->pembelian->supplier->nama_supplier ?? '-' }}</td>
                        <td>{{ $hutang->pembelian->tgl_pembelian ?? '-' }}</td>
                        <td class="text-danger fw-bold">Rp {{ number_format($hutang->sisa_hutang, 0, ',', '.') }}</td>
                        <td>
                            {{ $hutang->jatuh_tempo ?? '-' }}
                            @if ($hutang->jatuh_tempo && \Carbon\Carbon::parse($hutang->jatuh_tempo)->isPast())
                                <span class="badge bg-danger">Lewat Tempo</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Tidak ada hutang aktif</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <i class="bi bi-graph-up-arrow text-success"></i> Daftar Piutang dari Konsumen
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Konsumen</th><th>Tanggal Penjualan</th><th>Sisa Piutang</th><th>Jatuh Tempo</th></tr>
            </thead>
            <tbody>
                @forelse ($piutangs as $piutang)
                    <tr>
                        <td>{{ $piutang->penjualan->konsumen->nama_konsumen ?? '-' }}</td>
                        <td>{{ $piutang->penjualan->tgl_penjualan ?? '-' }}</td>
                        <td class="text-success fw-bold">Rp {{ number_format($piutang->sisa_piutang, 0, ',', '.') }}</td>
                        <td>
                            {{ $piutang->jatuh_tempo ?? '-' }}
                            @if ($piutang->jatuh_tempo && \Carbon\Carbon::parse($piutang->jatuh_tempo)->isPast())
                                <span class="badge bg-danger">Lewat Tempo</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Tidak ada piutang aktif</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection