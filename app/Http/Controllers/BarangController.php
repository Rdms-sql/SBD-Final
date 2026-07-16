<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('supplier')->latest()->paginate(10);
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        return view('barang.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_supplier' => 'required|exists:suppliers,id',
            'nama_barang' => 'required|string|max:255',
            'harga_jual' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load('supplier');
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        return view('barang.edit', compact('barang', 'suppliers'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'id_supplier' => 'required|exists:suppliers,id',
            'nama_barang' => 'required|string|max:255',
            'harga_jual' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
