@extends('layouts.public')
@section('title', 'Pesanan Saya')

@section('content')
<h4 class="mb-3"><i class="bi bi-clock-history"></i> Riwayat Pesanan Saya</h4>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Tanggal Pesan</th>
                    <th>Status</th>
                    <th>Tagihan</th>
                    <th style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pemesanans as $pemesanan)
                    <tr>
                        <td>#{{ str_pad($pemesanan->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $pemesanan->tgl_pesan }}</td>
                        <td>
                            @if ($pemesanan->status == 'diproses')
                                <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Sedang Diproses Staff</span>
                            @elseif ($pemesanan->status == 'selesai')
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Dikonfirmasi</span>
                            @else
                                <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Dibatalkan</span>
                            @endif
                        </td>
                        <td>
                            @if ($pemesanan->penjualan)
                                @if ($pemesanan->penjualan->status_bayar == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        Rp {{ number_format($pemesanan->penjualan->piutang->sisa_piutang ?? 0, 0, ',', '.') }}
                                    </span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pesanan-saya.show', $pemesanan) }}" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Kamu belum pernah memesan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $pemesanans->links() }}
</div>
@endsection