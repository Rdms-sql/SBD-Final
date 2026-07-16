@extends('layouts.app')
@section('title', 'Detail Pemesanan Supplier')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white d-flex justify-content-between">
        Detail Pemesanan ke Supplier
        <a href="{{ route('pemesanan-supplier.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><th style="width: 200px;">Supplier</th><td>: {{ $pemesanan->supplier->nama_supplier ?? '-' }}</td></tr>
            <tr><th>Tanggal Pesan</th><td>: {{ $pemesanan->tgl_pesan }}</td></tr>
            <tr><th>Status</th><td>: {{ ucfirst($pemesanan->status) }}</td></tr>
        </table>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">Daftar Barang Dipesan</div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Nama Barang</th><th>Jumlah</th><th>Harga Satuan</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
                @foreach ($pemesanan->detail as $item)
                    <tr>
                        <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <th colspan="3" class="text-end">Total</th>
                    <th>Rp {{ number_format($pemesanan->detail->sum('subtotal'), 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection