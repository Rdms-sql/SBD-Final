@extends('layouts.app')
@section('title', 'Retur Penjualan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Retur Penjualan (dari Konsumen)</h4>
    <a href="{{ route('retur-penjualan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Buat Retur
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Tanggal Retur</th>
                    <th>Konsumen</th>
                    <th>Transaksi Asal</th>
                    <th style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($returs as $retur)
                    <tr>
                        <td>{{ $retur->tgl_retur }}</td>
                        <td>{{ $retur->penjualan->konsumen->nama_konsumen ?? '-' }}</td>
                        <td>
                            <a href="{{ route('penjualan.show', $retur->penjualan) }}">
                                Penjualan #{{ $retur->penjualan->id ?? '-' }} ({{ $retur->penjualan->tgl_penjualan ?? '-' }})
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('retur-penjualan.show', $retur) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                            <form action="{{ route('retur-penjualan.destroy', $retur) }}" method="POST" class="d-inline" onsubmit="return confirm('Batalkan retur ini? Stok akan disesuaikan kembali.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada retur penjualan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $returs->links() }}
</div>
@endsection