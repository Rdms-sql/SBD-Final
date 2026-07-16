@extends('layouts.app')
@section('title', 'Detail Retur Pembelian')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white d-flex justify-content-between">
        Detail Retur Pembelian
        <a href="{{ route('retur-pembelian.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><th style="width: 200px;">Supplier</th><td>: {{ $retur->pembelian->supplier->nama_supplier ?? '-' }}</td></tr>
            <tr><th>Tanggal Retur</th><td>: {{ $retur->tgl_retur }}</td></tr>
            <tr><th>Transaksi Asal</th><td>: <a href="{{ route('pembelian.show', $retur->pembelian) }}">Pembelian #{{ $retur->pembelian->id ?? '-' }}</a></td></tr>
        </table>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">Barang yang Diretur</div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Nama Barang</th><th>Jumlah</th><th>Alasan</th></tr>
            </thead>
            <tbody>
                @foreach ($retur->detail as $item)
                    <tr>
                        <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->alasan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection