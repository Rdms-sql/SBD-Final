@extends('layouts.app')
@section('title', 'Edit Status Pemesanan Konsumen')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">Update Status Pemesanan</div>
    <div class="card-body">
        <p><strong>Konsumen:</strong> {{ $pemesanan->konsumen->nama_konsumen ?? '-' }}</p>
        <p><strong>Tanggal Pesan:</strong> {{ $pemesanan->tgl_pesan }}</p>

        <form action="{{ route('pemesanan-konsumen.update', $pemesanan) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="diproses" {{ $pemesanan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ $pemesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ $pemesanan->status == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <button class="btn btn-primary"><i class="bi bi-save"></i> Update Status</button>
            <a href="{{ route('pemesanan-konsumen.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection