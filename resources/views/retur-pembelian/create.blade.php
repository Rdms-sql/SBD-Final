@extends('layouts.app')
@section('title', 'Buat Retur Pembelian')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">Buat Retur Pembelian (Kembalikan Barang ke Supplier)</div>
    <div class="card-body">
        <form action="{{ route('retur-pembelian.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label">Transaksi Pembelian</label>
                    <select name="id_pembelian" class="form-select" required>
                        <option value="">-- Pilih Transaksi Pembelian --</option>
                        @foreach ($pembelians as $pembelian)
                            <option value="{{ $pembelian->id }}">
                                #{{ $pembelian->id }} - {{ $pembelian->supplier->nama_supplier ?? '-' }} ({{ $pembelian->tgl_pembelian }}) - Rp {{ number_format($pembelian->total_beli, 0, ',', '.') }}
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
            <p class="text-muted small">Isi baris yang dibutuhkan saja. Pastikan barang yang dipilih memang dari transaksi pembelian di atas.</p>

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
                                <input type="text" name="items[{{ $i }}][alasan]" class="form-control" placeholder="Contoh: Rusak, kadaluarsa, dsb">
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Retur</button>
            <a href="{{ route('retur-pembelian.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection