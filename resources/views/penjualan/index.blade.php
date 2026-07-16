@extends('layouts.app')
@section('title', 'Penjualan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Transaksi Penjualan</h4>
    <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Transaksi Baru
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Konsumen</th>
                    <th>Diinput Oleh</th>
                    <th>Total</th>
                    <th>Status Bayar</th>
                    <th style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penjualans as $penjualan)
                    <tr>
                        <td>{{ $penjualan->tgl_penjualan }}</td>
                        <td>{{ $penjualan->konsumen->nama_konsumen ?? '-' }}</td>
                        <td>{{ $penjualan->user->nama_lengkap ?? '-' }}</td>
                        <td>Rp {{ number_format($penjualan->total_jual, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $penjualan->status_bayar == 'lunas' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst(str_replace('_', ' ', $penjualan->status_bayar)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('penjualan.show', $penjualan) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                            <form action="{{ route('penjualan.destroy', $penjualan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus transaksi ini? Stok akan dikembalikan.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">Belum ada transaksi penjualan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $penjualans->links() }}
</div>
@endsection