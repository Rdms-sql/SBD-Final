@extends('layouts.public')
@section('title', 'Pesanan Berhasil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-sm border-success">
            <div class="card-body text-center py-5">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                <h4 class="mt-3">Pesanan Berhasil Dikirim!</h4>
                <p class="text-muted">Terima kasih {{ $pemesanan->konsumen->nama_konsumen }}, pesanan Anda sedang <strong>diproses oleh staff toko</strong>. Anda bisa memantau statusnya kapan saja di halaman "Pesanan Saya".</p>

                <div class="bg-light rounded p-3 d-inline-block my-3">
                    <div class="text-muted small">Nomor Pesanan Anda</div>
                    <div class="fs-3 fw-bold text-primary">#{{ str_pad($pemesanan->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>

                <p class="text-muted small">Tagihan akan muncul setelah pesanan dikonfirmasi oleh staff.</p>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header bg-white">Ringkasan Pesanan</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr><th>Barang</th><th>Jumlah</th><th>Harga Satuan</th><th>Subtotal</th></tr>
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

        <div class="text-center mt-3">
            <a href="{{ route('pesanan-publik.create') }}" class="btn btn-outline-primary">
                <i class="bi bi-plus-lg"></i> Buat Pesanan Lain
            </a>
            <a href="{{ route('pesanan-saya.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-clock-history"></i> Lihat Semua Pesanan Saya
            </a>
        </div>

    </div>
</div>
@endsection