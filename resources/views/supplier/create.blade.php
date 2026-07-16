@extends('layouts.app')
@section('title', 'Tambah Supplier')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">Tambah Supplier</div>
    <div class="card-body">
        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Supplier</label>
                <input type="text" name="nama_supplier" value="{{ old('nama_supplier') }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
            </div>
            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection