@extends('layouts.app')
@section('title', 'Laporan Stok')

@section('content')
<h4 class="mb-3">Laporan Stok Barang</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-bg-primary shadow-sm">
            <div class="card-body">
                <div class="small">Total Jenis Barang</div>
                <div class="fs-4 fw-bold">{{ $totalBarang }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning shadow-sm">
            <div class="card-body">
                <div class="small">Stok Menipis (≤10)</div>
                <div class="fs-4 fw-bold">{{ $stokMenipis }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-danger shadow-sm">
            <div class="card-body">
                <div class="small">Stok Habis</div>
                <div class="fs-4 fw-bold">{{ $stokHabis }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success shadow-sm">
            <div class="card-body">
                <div class="small">Total Nilai Stok</div>
                <div class="fs-6 fw-bold">Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span>Detail Stok Barang</span>
        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer"></i> Cetak</button>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Supplier</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Nilai Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $barang)
                    <tr>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->supplier->nama_supplier ?? '-' }}</td>
                        <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $barang->stok == 0 ? 'bg-danger' : ($barang->stok <= 10 ? 'bg-warning text-dark' : 'bg-success') }}">
                                {{ $barang->stok }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($barang->stok * $barang->harga_jual, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada data barang</td></tr>
                @endforelse
            </tbody>
            @if ($barangs->isNotEmpty())
            <tfoot>
                <tr class="table-light">
                    <th colspan="4" class="text-end">Total Nilai Stok</th>
                    <th>Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection