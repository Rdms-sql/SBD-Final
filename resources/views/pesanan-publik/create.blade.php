@extends('layouts.public')
@section('title', 'Form Pemesanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <span class="text-muted small">Memesan sebagai:</span>
                <div class="fw-bold">{{ $konsumen->nama_konsumen }} — {{ $konsumen->no_hp }}</div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-cart-plus"></i> Form Pemesanan Barang</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pesanan-publik.store') }}" method="POST">
                    @csrf

                    <h6 class="mb-3">Pilih Barang yang Ingin Dipesan</h6>
                    <p class="text-muted small">Isi baris yang dibutuhkan saja, sisakan kosong jika tidak dipakai. Harga mengikuti harga jual saat ini.</p>

                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 55%;">Barang</th>
                                <th style="width: 20%;">Harga</th>
                                <th style="width: 25%;">Jumlah</th>
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
                                        <span class="harga-display text-muted">-</span>
                                    </td>
                                    <td>
                                        <input type="number" name="items[{{ $i }}][jumlah]" class="form-control" min="1">
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>

                    @if ($barangs->isEmpty())
                        <div class="alert alert-warning">Maaf, saat ini belum ada barang yang tersedia untuk dipesan.</div>
                    @endif

                    <button class="btn btn-primary w-100" {{ $barangs->isEmpty() ? 'disabled' : '' }}>
                        <i class="bi bi-send"></i> Kirim Pesanan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.barang-select').forEach(function (select) {
        select.addEventListener('change', function () {
            const row = this.closest('tr');
            const hargaDisplay = row.querySelector('.harga-display');
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            if (harga) {
                hargaDisplay.textContent = 'Rp ' + parseInt(harga).toLocaleString('id-ID');
                hargaDisplay.classList.remove('text-muted');
            } else {
                hargaDisplay.textContent = '-';
                hargaDisplay.classList.add('text-muted');
            }
        });
    });
</script>
@endsection