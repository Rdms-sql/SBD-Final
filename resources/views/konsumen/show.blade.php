@extends('layouts.app')
@section('title', 'Detail Konsumen')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white d-flex justify-content-between">
        Detail Konsumen
        <a href="{{ route('konsumen.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><th style="width: 200px;">Nama Konsumen</th><td>: {{ $konsumen->nama_konsumen }}</td></tr>
            <tr><th>No HP</th><td>: {{ $konsumen->no_hp ?? '-' }}</td></tr>
            <tr><th>Alamat</th><td>: {{ $konsumen->alamat ?? '-' }}</td></tr>
        </table>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">Riwayat Penjualan ke Konsumen Ini</div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Tanggal</th><th>Total</th><th>Status Bayar</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse ($konsumen->penjualan as $penjualan)
                    <tr>
                        <td>{{ $penjualan->tgl_penjualan }}</td>
                        <td>Rp {{ number_format($penjualan->total_jual, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $penjualan->status_bayar == 'lunas' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst(str_replace('_', ' ', $penjualan->status_bayar)) }}
                            </span>
                        </td>
                        <td><a href="{{ route('penjualan.show', $penjualan) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada riwayat penjualan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection