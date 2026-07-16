@extends('layouts.app')
@section('title', 'Transaksi Penjualan Baru')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">Input Transaksi Penjualan</div>
    <div class="card-body">
        <form action="{{ route('penjualan.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Konsumen</label>
                    <select name="id_konsumen" class="form-select" required>
                        <option value="">-- Pilih Konsumen --</option>
                        @foreach ($konsumens as $konsumen)
                            <option value="{{ $konsumen->id }}">{{ $konsumen->nama_konsumen }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Penjualan</label>
                    <input type="date" name="tgl_penjualan" class="form-control" value="{{ date('Y-m-d') }}" required>
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
            <h6 class="mb-3">Daftar Barang Dijual</h6>
            <p class="text-muted small">Isi baris yang dibutuhkan saja, sisakan kosong jika tidak dipakai. Harga otomatis terisi dari harga jual barang (bisa diubah manual).</p>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40%;">Barang</th>
                        <th style="width: 20%;">Jumlah</th>
                        <th style="width: 30%;">Harga Satuan (Jual)</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>
                                <select name="items[{{ $i }}][id_barang]" class="form-select barang-select">
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}" data-harga="{{ $barang->harga_jual }}">
                                            {{ $barang->nama_barang }} (stok: {{ $barang->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="items[{{ $i }}][jumlah]" class="form-control" min="1">
                            </td>
                            <td>
                                <input type="number" name="items[{{ $i }}][harga_satuan]" class="form-control harga-input" min="0">
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Transaksi</button>
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.barang-select').forEach(function (select) {
        select.addEventListener('change', function () {
            const row = this.closest('tr');
            const hargaInput = row.querySelector('.harga-input');
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            if (harga && !hargaInput.value) {
                hargaInput.value = harga;
            }
        });
    });

    const statusBayar = document.getElementById('status_bayar');
    const jatuhTempoWrapper = document.getElementById('jatuh_tempo_wrapper');

    function toggleJatuhTempo() {
        jatuhTempoWrapper.style.display = statusBayar.value === 'belum_lunas' ? 'block' : 'none';
    }

    statusBayar.addEventListener('change', toggleJatuhTempo);
    toggleJatuhTempo();
</script>
@endsection