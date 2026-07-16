@extends('layouts.app')
@section('title', 'Pesanan Konsumen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Pemesanan dari Konsumen</h4>
    <a href="{{ route('pemesanan-konsumen.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Buat Pemesanan
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Tanggal Pesan</th>
                    <th>Konsumen</th>
                    <th>Status</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pemesanans as $pemesanan)
                    <tr>
                        <td>{{ $pemesanan->tgl_pesan }}</td>
                        <td>{{ $pemesanan->konsumen->nama_konsumen ?? '-' }}</td>
                        <td>
                            <span class="badge
                                @if($pemesanan->status == 'selesai') bg-success
                                @elseif($pemesanan->status == 'batal') bg-danger
                                @else bg-secondary @endif">
                                {{ ucfirst($pemesanan->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pemesanan-konsumen.show', $pemesanan) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('pemesanan-konsumen.edit', $pemesanan) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('pemesanan-konsumen.destroy', $pemesanan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus pemesanan ini?')">
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