@extends('layouts.print')
@section('title', 'Nota Penjualan #' . $penjualan->id)

@section('content')
<div class="text-center">
    <div class="fs-lg fw-bold">GROSIR SEMBAKO</div>
    <div>Nota Penjualan</div>
</div>

<hr>

<table>
    <tr>
        <td>No. Transaksi</td>
        <td>: #{{ str_pad($penjualan->id, 6, '0', STR_PAD_LEFT) }}</td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>: {{ $penjualan->tgl_penjualan }}</td>
    </tr>
    <tr>
        <td>Konsumen</td>
        <td>: {{ $penjualan->konsumen->nama_konsumen ?? '-' }}</td>
    </tr>
    <tr>
        <td>Dilayani Oleh</td>
        <td>: {{ $penjualan->user->nama_lengkap ?? '-' }}</td>
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
        @foreach ($penjualan->detail as $item)
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
        <td class="text-end fw-bold">Rp {{ number_format($penjualan->total_jual, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Status Bayar</td>
        <td class="text-end">{{ ucfirst(str_replace('_', ' ', $penjualan->status_bayar)) }}</td>
    </tr>
    @if ($penjualan->piutang)
    <tr>
        <td>Sisa Piutang</td>
        <td class="text-end">Rp {{ number_format($penjualan->piutang->sisa_piutang, 0, ',', '.') }}</td>
    </tr>
    @if ($penjualan->piutang->jatuh_tempo)
    <tr>
        <td>Jatuh Tempo</td>
        <td class="text-end">{{ $penjualan->piutang->jatuh_tempo }}</td>
    </tr>
    @endif
    @endif
</table>

<hr>

<div class="text-center">
    Terima kasih telah berbelanja
</div>
@endsection