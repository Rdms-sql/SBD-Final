@extends('layouts.app')
@section('title', 'Edit Barang')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">Edit Barang</div>
    <div class="card-body">
        <form action="{{ route('barang.update', $barang) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Supplier</label>
                <select name="id_supplier" class="form-select" required>
                    <option value="">-- Pilih Supplier --</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('id_supplier', $barang->id_supplier) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->nama_supplier }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga Jual</label>
                <input type="number" name="harga_jual" value="{{ old('harga_jual', $barang->harga_jual) }}" class="form-control" min="0" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" value="{{ old('stok', $barang->stok) }}" class="form-control" min="0" required>
            </div>
            <button class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection