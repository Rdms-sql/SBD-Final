@extends('layouts.public')
@section('title', 'Detail Pesanan')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white d-flex justify-content-between">
        Detail Pesanan #{{ str_pad($pemesanan->id, 6, '0', STR_PAD_LEFT) }}
        <a href="{{ route('pesanan-saya.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><th style="width: 200px;">Tanggal Pesan</th><td>: {{ $pemesanan->tgl_pesan }}</td></tr>
            <tr><th>Status Pesanan</th>
                <td>:
                    @if ($pemesanan->status == 'diproses')
                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Sedang Diproses Staff</span>
                    @elseif ($pemesanan->status == 'selesai')
                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Dikonfirmasi</span>
                    @else
                        <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Dibatalkan</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-header bg-white">Daftar Barang</div>
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

@if ($pemesanan->status == 'diproses')
    <div class="alert alert-warning">
        <i class="bi bi-hourglass-split"></i> <strong>Pesanan Anda sedang diproses oleh staff toko</strong> (pengecekan stok & penyiapan barang). Tagihan pembayaran akan muncul di sini setelah staff mengonfirmasi pesanan.
    </div>
@elseif ($pemesanan->status == 'batal')
    <div class="alert alert-danger">
        <i class="bi bi-x-circle"></i> Pesanan ini dibatalkan.
    </div>
@elseif ($pemesanan->penjualan)
    <div class="card shadow-sm border-{{ $pemesanan->penjualan->status_bayar == 'lunas' ? 'success' : 'warning' }} mb-3">
        <div class="card-header {{ $pemesanan->penjualan->status_bayar == 'lunas' ? 'bg-success-subtle' : 'bg-warning-subtle' }}">
            Informasi Tagihan
        </div>
        <div class="card-body">
            @if ($pemesanan->penjualan->status_bayar == 'lunas')
                <p class="mb-0 text-success"><i class="bi bi-check-circle"></i> Pesanan ini sudah lunas.</p>
            @else
                <p class="mb-1"><strong>Sisa yang harus dibayar:</strong> Rp {{ number_format($pemesanan->penjualan->piutang->sisa_piutang ?? 0, 0, ',', '.') }}</p>
                <p class="mb-0"><strong>Batas waktu pembayaran:</strong> {{ $pemesanan->penjualan->piutang->jatuh_tempo ?? '-' }}</p>
                <hr>
                <p class="text-muted small mb-0">Silakan lakukan pembayaran langsung ke toko. Status akan diperbarui staff setelah pembayaran diterima.</p>
            @endif
        </div>
    </div>

    @if ($pemesanan->penjualan->piutang && $pemesanan->penjualan->piutang->penerimaan->count() > 0)
    <div class="card shadow-sm">
        <div class="card-header bg-white">Riwayat Pembayaran</div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr><th>Tanggal Diterima</th><th>Jumlah</th></tr>
                </thead>
                <tbody>
                    @foreach ($pemesanan->penjualan->piutang->penerimaan as $bayar)
                        <tr>
                            <td>{{ $bayar->tgl_terima }}</td>
                            <td>Rp {{ number_format($bayar->jumlah_terima, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endif
@endsection