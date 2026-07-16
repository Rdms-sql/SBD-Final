@extends('layouts.app')
@section('title', 'Pesan ke Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Pemesanan ke Supplier</h4>
    <a href="{{ route('pemesanan-supplier.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Buat Pemesanan
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Tanggal Pesan</th>
                    <th>Supplier</th>
                    <th>Status</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pemesanans as $pemesanan)
                    <tr>
                        <td>{{ $pemesanan->tgl_pesan }}</td>
                        <td>{{ $pemesanan->supplier->nama_supplier ?? '-' }}</td>
                        <td>
                            <span class="badge
                                @if($pemesanan->status == 'selesai') bg-success
                                @elseif($pemesanan->status == 'batal') bg-danger
                                @elseif($pemesanan->status == 'dikirim') bg-info
                                @else bg-secondary @endif">
                                {{ ucfirst($pemesanan->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pemesanan-supplier.show', $pemesanan) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('pemesanan-supplier.edit', $pemesanan) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('pemesanan-supplier.destroy', $pemesanan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus pemesanan ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada pemesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $pemesanans->links() }}
</div>
@endsection