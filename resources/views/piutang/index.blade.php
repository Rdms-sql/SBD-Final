@extends('layouts.app')
@section('title', 'Piutang')

@section('content')
<h4 class="mb-3">Daftar Piutang dari Konsumen</h4>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Konsumen</th>
                    <th>Tanggal Penjualan</th>
                    <th>Sisa Piutang</th>
                    <th>Jatuh Tempo</th>
                    <th style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($piutangs as $piutang)
                    <tr>
                        <td>{{ $piutang->penjualan->konsumen->nama_konsumen ?? '-' }}</td>
                        <td>{{ $piutang->penjualan->tgl_penjualan ?? '-' }}</td>
                        <td class="text-success fw-bold">Rp {{ number_format($piutang->sisa_piutang, 0, ',', '.') }}</td>
                        <td>
                            {{ $piutang->jatuh_tempo ?? '-' }}
                            @if ($piutang->jatuh_tempo && \Carbon\Carbon::parse($piutang->jatuh_tempo)->isPast())
                                <span class="badge bg-danger">Lewat Tempo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('piutang.show', $piutang) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Tidak ada piutang aktif 🎉</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $piutangs->links() }}
</div>
@endsection