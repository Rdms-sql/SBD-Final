@extends('layouts.app')
@section('title', 'Edit Supplier')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">Edit Supplier</div>
    <div class="card-body">
        <form action="{{ route('supplier.update', $supplier) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Supplier</label>
                <input type="text" name="nama_supplier" value="{{ old('nama_supplier', $supplier->nama_supplier) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $supplier->no_hp) }}" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $supplier->alamat) }}</textarea>
            </div>
            <button class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection