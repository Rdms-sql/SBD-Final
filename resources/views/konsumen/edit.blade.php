@extends('layouts.app')
@section('title', 'Edit Konsumen')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">Edit Konsumen</div>
    <div class="card-body">
        <form action="{{ route('konsumen.update', $konsumen) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Konsumen</label>
                <input type="text" name="nama_konsumen" value="{{ old('nama_konsumen', $konsumen->nama_konsumen) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $konsumen->no_hp) }}" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $konsumen->alamat) }}</textarea>
            </div>
            <button class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="{{ route('konsumen.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection