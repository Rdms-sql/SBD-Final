@extends('layouts.print')
@section('title', 'Nota Pembelian #' . $pembelian->id)

@section('content')
<div class="text-center">
    <div class="fs-lg fw-bold">GROSIR SEMBAKO</div>
    <div>Nota Pembelian</div>
</div>

<hr>

<table>
    <tr>
        <td>No. Transaksi</td>
        <td>: #{{ str_pad($pembelian->id, 6, '0', STR_PAD_LEFT) }}</td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>: {{ $pembelian->tgl_pembelian }}</td>
    </tr>
    <tr>
        <td>Supplier</td>
        <td>: {{ $pembelian->supplier->nama_supplier ?? '-' }}</td>
    </tr>
    <tr>
        <td>Diinput Oleh</td>
        <td>: {{ $pembelian->user->nama_lengkap ?? '-' }}</td>
    </tr>
</table>

<hr>

<table>
    <thead>
        <tr>
            <th>Barang</th>
            <th class="text-end">Qty</th>
            <th class="text-end">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pembelian->detail as $item)
            <tr>
                <td colspan="3">{{ $item->barang->nama_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="3" style="padding-left: 10px;">
                    {{ $item->jumlah }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                    <span style="float: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<hr>

<table>
    <tr>
        <td class="fw-bold">TOTAL</td>
        <td class="text-end fw-bold">Rp {{ number_format($pembelian->total_beli, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Status Bayar</td>
        <td class="text-end">{{ ucfirst(str_replace('_', ' ', $pembelian->status_bayar)) }}</td>
    </tr>
    @if ($pembelian->hutang)
    <tr>
        <td>Sisa Hutang</td>
        <td class="text-end">Rp {{ number_format($pembelian->hutang->sisa_hutang, 0, ',', '.') }}</td>
    </tr>
    @endif
</table>

<hr>

<div class="text-center">
    Terima kasih atas kerja samanya
</div>
@endsection