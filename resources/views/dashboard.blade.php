@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-bg-primary shadow-sm">
            <div class="card-body">
                <div class="small">Total Barang</div>
                <div class="fs-3 fw-bold">{{ $totalBarang }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning shadow-sm">
            <div class="card-body">
                <div class="small">Stok Menipis</div>
                <div class="fs-3 fw-bold">{{ $totalStokMenipis }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-danger shadow-sm">
            <div class="card-body">
                <div class="small">Total Hutang</div>
                <div class="fs-5 fw-bold">Rp {{ number_format($totalHutang, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success shadow-sm">
            <div class="card-body">
                <div class="small">Total Piutang</div>
                <div class="fs-5 fw-bold">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Penjualan Hari Ini</div>
                <div class="fs-4 fw-bold text-success">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Pembelian Hari Ini</div>
                <div class="fs-4 fw-bold text-primary">Rp {{ number_format($pembelianHariIni, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <i class="bi bi-exclamation-triangle text-warning"></i> Barang dengan Stok Menipis
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangMenipis as $barang)
                    <tr>
                        <td>{{ $barang->nama_barang }}</td>
                        <td><span class="badge bg-warning text-dark">{{ $barang->stok }}</span></td>
                        <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada barang dengan stok menipis</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection