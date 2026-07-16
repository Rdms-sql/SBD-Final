@extends('layouts.app')
@section('title', 'Laporan Penjualan')

@section('content')
<h4 class="mb-3">Laporan Penjualan</h4>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ $dariTanggal }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="sampai" value="{{ $sampaiTanggal }}" class="form-control">
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
                <a href="{{ route('laporan.penjualan') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-bg-primary shadow-sm">
            <div class="card-body">
                <div class="small">Total Transaksi</div>
                <div class="fs-4 fw-bold">{{ $totalTransaksi }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success shadow-sm">
            <div class="card-body">
                <div class="small">Total Penjualan</div>
                <div class="fs-5 fw-bold">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-info shadow-sm">
            <div class="card-body">
                <div class="small">Sudah Lunas</div>
                <div class="fs-5 fw-bold">Rp {{ number_format($totalLunas, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-danger shadow-sm">
            <div class="card-body">
                <div class="small">Belum Lunas</div>
                <div class="fs-5 fw-bold">Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span>Detail Transaksi ({{ $dariTanggal }} s/d {{ $sampaiTanggal }})</span>
        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer"></i> Cetak</button>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Konsumen</th>
                    <th>Diinput Oleh</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penjualans as $penjualan)
                <tr>
                    <td>{{ $penjualan->tgl_penjualan }}</td>
                    <td>{{ $penjualan->konsumen->nama_konsumen ?? '-' }}</td>
                    <td>{{ $penjualan->user->nama_lengkap ?? '-' }}</td>
                    <td>Rp {{ number_format($penjualan->total_jual, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $penjualan->status_bayar == 'lunas' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst(str_replace('_', ' ', $penjualan->status_bayar)) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">Tidak ada transaksi pada periode ini</td>
                </tr>
                @endforelse
            </tbody>
            @if ($penjualans->isNotEmpty())
            <tfoot>
                <tr class="table-light">
                    <th colspan="3" class="text-end">Total</th>
                    <th colspan="2">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection