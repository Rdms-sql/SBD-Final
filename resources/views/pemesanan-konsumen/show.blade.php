@extends('layouts.app')
@section('title', 'Detail Pemesanan Konsumen')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header bg-white d-flex justify-content-between">
        Detail Pemesanan dari Konsumen
        <a href="{{ route('pemesanan-konsumen.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><th style="width: 200px;">Konsumen</th><td>: {{ $pemesanan->konsumen->nama_konsumen ?? '-' }}</td></tr>
            <tr><th>No HP</th><td>: {{ $pemesanan->konsumen->no_hp ?? '-' }}</td></tr>
            <tr><th>Tanggal Pesan</th><td>: {{ $pemesanan->tgl_pesan }}</td></tr>
            <tr><th>Status</th><td>: {{ ucfirst($pemesanan->status) }}</td></tr>
        </table>
    </div>
</div>

<div class="card shadow-sm mb-3">
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

@if ($pemesanan->id_penjualan)
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> Pesanan ini sudah diproses menjadi transaksi penjualan.
        <a href="{{ route('penjualan.show', $pemesanan->id_penjualan) }}" class="alert-link">Lihat Transaksi Penjualan</a>
    </div>
@elseif ($pemesanan->status === 'diproses')
    <div class="card shadow-sm border-primary">
        <div class="card-header bg-primary-subtle">
            <i class="bi bi-arrow-right-circle"></i> Proses Jadi Transaksi Penjualan
        </div>
        <div class="card-body">
            <form action="{{ route('pemesanan-konsumen.proses', $pemesanan) }}" method="POST" class="row g-3" onsubmit="return confirm('Proses pesanan ini jadi transaksi penjualan? Stok akan berkurang.')">
                @csrf
                <div class="col-md-4">
                    <label class="form-label">Status Bayar</label>
                    <select name="status_bayar" id="status_bayar" class="form-select" required>
                        <option value="lunas">Lunas</option>
                        <option value="belum_lunas">Belum Lunas</option>
                    </select>
                </div>
                <div class="col-md-4" id="jatuh_tempo_wrapper" style="display: none;">
                    <label class="form-label">Jatuh Tempo</label>
                    <input type="date" name="jatuh_tempo" class="form-control">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-check-lg"></i> Proses Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    @section('scripts')
    <script>
        const statusBayar = document.getElementById('status_bayar');
        const jatuhTempoWrapper = document.getElementById('jatuh_tempo_wrapper');
        function toggleJatuhTempo() {
            jatuhTempoWrapper.style.display = statusBayar.value === 'belum_lunas' ? 'block' : 'none';
        }
        statusBayar.addEventListener('change', toggleJatuhTempo);
        toggleJatuhTempo();
    </script>
    @endsection
@endif
@endsection