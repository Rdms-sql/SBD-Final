@extends('layouts.app')
@section('title', 'Transaksi Pembelian Baru')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">Input Transaksi Pembelian</div>
    <div class="card-body">
        <form action="{{ route('pembelian.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Supplier</label>
                    <select name="id_supplier" class="form-select" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Pembelian</label>
                    <input type="date" name="tgl_pembelian" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status Bayar</label>
                    <select name="status_bayar" id="status_bayar" class="form-select" required>
                        <option value="lunas">Lunas</option>
                        <option value="belum_lunas">Belum Lunas</option>
                    </select>
                </div>
                <div class="col-md-3" id="jatuh_tempo_wrapper" style="display: none;">
                    <label class="form-label">Jatuh Tempo</label>
                    <input type="date" name="jatuh_tempo" class="form-control">
                </div>
            </div>

            <hr>
            <h6 class="mb-3">Daftar Barang Dibeli</h6>
            <p class="text-muted small">Isi baris yang dibutuhkan saja, sisakan kosong jika tidak dipakai.</p>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40%;">Barang</th>
                        <th style="width: 20%;">Jumlah</th>
                        <th style="width: 30%;">Harga Satuan (Beli)</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>
                                <select name="items[{{ $i }}][id_barang]" class="form-select">
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }} (stok: {{ $barang->stok }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="items[{{ $i }}][jumlah]" class="form-control" min="1">
                            </td>
                            <td>
                                <input type="number" name="items[{{ $i }}][harga_satuan]" class="form-control" min="0" placeholder="Harga beli dari supplier">
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Transaksi</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

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