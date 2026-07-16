@extends('layouts.app')
@section('title', 'Pembelian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Transaksi Pembelian</h4>
    <a href="{{ route('pembelian.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Transaksi Baru
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Diinput Oleh</th>
                    <th>Total</th>
                    <th>Status Bayar</th>
                    <th style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembelians as $pembelian)
                    <tr>
                        <td>{{ $pembelian->tgl_pembelian }}</td>
                        <td>{{ $pembelian->supplier->nama_supplier ?? '-' }}</td>
                        <td>{{ $pembelian->user->nama_lengkap ?? '-' }}</td>
                        <td>Rp {{ number_format($pembelian->total_beli, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $pembelian->status_bayar == 'lunas' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst(str_replace('_', ' ', $pembelian->status_bayar)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pembelian.show', $pembelian) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                            <form action="{{ route('pembelian.destroy', $pembelian) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus transaksi ini? Stok akan dikembalikan.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">Belum ada transaksi pembelian</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $pembelians->links() }}
</div>
@endsection