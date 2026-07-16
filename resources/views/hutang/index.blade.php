@extends('layouts.app')
@section('title', 'Hutang')

@section('content')
<h4 class="mb-3">Daftar Hutang ke Supplier</h4>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Supplier</th>
                    <th>Tanggal Pembelian</th>
                    <th>Sisa Hutang</th>
                    <th>Jatuh Tempo</th>
                    <th style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hutangs as $hutang)
                    <tr>
                        <td>{{ $hutang->pembelian->supplier->nama_supplier ?? '-' }}</td>
                        <td>{{ $hutang->pembelian->tgl_pembelian ?? '-' }}</td>
                        <td class="text-danger fw-bold">Rp {{ number_format($hutang->sisa_hutang, 0, ',', '.') }}</td>
                        <td>
                            {{ $hutang->jatuh_tempo ?? '-' }}
                            @if ($hutang->jatuh_tempo && \Carbon\Carbon::parse($hutang->jatuh_tempo)->isPast())
                                <span class="badge bg-danger">Lewat Tempo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('hutang.show', $hutang) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Tidak ada hutang aktif 🎉</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $hutangs->links() }}
</div>
@endsection