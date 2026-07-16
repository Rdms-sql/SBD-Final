@extends('layouts.app')
@section('title', 'Buat Retur Penjualan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">Buat Retur Penjualan (Barang Dikembalikan Konsumen)</div>
    <div class="card-body">
        <form action="{{ route('retur-penjualan.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label">Transaksi Penjualan</label>
                    <select name="id_penjualan" class="form-select" required>
                        <option value="">-- Pilih Transaksi Penjualan --</option>
                        @foreach ($penjualans as $penjualan)
                            <option value="{{ $penjualan->id }}">
                                #{{ $penjualan->id }} - {{ $penjualan->konsumen->nama_konsumen ?? '-' }} ({{ $penjualan->tgl_penjualan }}) - Rp {{ number_format($penjualan->total_jual, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Retur</label>
                    <input type="date" name="tgl_retur" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            <hr>
            <h6 class="mb-3">Barang yang Diretur</h6>
            <p class="text-muted small">Isi baris yang dibutuhkan saja. Pastikan barang yang dipilih memang dari transaksi penjualan di atas.</p>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40%;">Barang</th>
                        <th style="width: 20%;">Jumlah</th>
                        <th style="width: 40%;">Alasan</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>
                                <select name="items[{{ $i }}][id_barang]" class="form-select">
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach (\App\Models\Barang::orderBy('nama_barang')->get() as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="items[{{ $i }}][jumlah]" class="form-control" min="1">
                            </td>
                            <td>
                                <input type="text" name="items[{{ $i }}][alasan]" class="form-control" placeholder="Contoh: Salah beli, rusak, dsb">
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Retur</button>
            <a href="{{ route('retur-penjualan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection