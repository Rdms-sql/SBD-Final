@extends('layouts.app')
@section('title', 'Buat Pemesanan Konsumen')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">Buat Pemesanan dari Konsumen</div>
    <div class="card-body">
        <form action="{{ route('pemesanan-konsumen.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Konsumen</label>
                    <select name="id_konsumen" class="form-select" required>
                        <option value="">-- Pilih Konsumen --</option>
                        @foreach ($konsumens as $konsumen)
                            <option value="{{ $konsumen->id }}">{{ $konsumen->nama_konsumen }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Pesan</label>
                    <input type="date" name="tgl_pesan" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="batal">Batal</option>
                    </select>
                </div>
            </div>

            <hr>
            <h6 class="mb-3">Daftar Barang yang Dipesan</h6>
            <p class="text-muted small">Isi baris yang dibutuhkan saja, sisakan kosong jika tidak dipakai.</p>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40%;">Barang</th>
                        <th style="width: 20%;">Jumlah</th>
                        <th style="width: 30%;">Harga Satuan</th>
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
                                            {{ $barang->nama_barang }}
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

            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Pemesanan</button>
            <a href="{{ route('pemesanan-konsumen.index') }}" class="btn btn-secondary">Batal</a>
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
</script>
@endsection