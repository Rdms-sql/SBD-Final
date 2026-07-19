@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- Baris 1: 4 Kartu Metrik Utama -->
<div class="row g-4 mb-4">
    <!-- Card Total Barang -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-1">Total Barang</p>
                        <h3 class="fw-bold text-dark mb-0">{{ $totalBarang }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Stok Menipis -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-1">Stok Menipis</p>
                        <h3 class="fw-bold text-dark mb-0">{{ $totalStokMenipis }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-3">
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Total Hutang -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-1">Total Hutang</p>
                        <h4 class="fw-bold text-dark mb-0">Rp {{ number_format($totalHutang, 0, ',', '.') }}</h4>
                    </div>
                    <div class="bg-danger bg-opacity-10 text-danger p-2 rounded-3">
                        <i class="bi bi-arrow-down-right-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Total Piutang -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-1">Total Piutang</p>
                        <h4 class="fw-bold text-dark mb-0">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</h4>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success p-2 rounded-3">
                        <i class="bi bi-arrow-up-right-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Baris 2: Kartu Transaksi Hari Ini -->
<div class="row g-4 mb-4">
    <!-- Card Penjualan -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small text-uppercase fw-bold mb-1">Penjualan Hari Ini</p>
                    <h2 class="fw-bold text-success mb-0">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</h2>
                </div>
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle">
                    <i class="bi bi-graph-up-arrow fs-2"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Pembelian -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small text-uppercase fw-bold mb-1">Pembelian Hari Ini</p>
                    <h2 class="fw-bold text-primary mb-0">Rp {{ number_format($pembelianHariIni, 0, ',', '.') }}</h2>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
                    <i class="bi bi-cart-check fs-2"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Baris 3: Tabel Data -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
        <h6 class="fw-bold text-dark mb-0">
            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> Barang dengan Stok Menipis
        </h6>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-secondary small fw-semibold border-0 rounded-start">Nama Barang</th>
                        <th class="text-secondary small fw-semibold border-0">Stok</th>
                        <th class="text-secondary small fw-semibold border-0 rounded-end">Harga Jual</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse ($barangMenipis as $barang)
                        <tr>
                            <td class="text-dark fw-medium">{{ $barang->nama_barang }}</td>
                            <td>
                                <!-- Badge  -->
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">{{ $barang->stok }}</span>
                            </td>
                            <td class="text-secondary">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-light"></i>
                                Tidak ada barang dengan stok menipis
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection