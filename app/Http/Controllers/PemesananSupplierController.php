<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\PemesananSupplier;
use App\Models\DetailPesanSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananSupplierController extends Controller
{
    public function index()
    {
        $pemesanans = PemesananSupplier::with('supplier')->latest()->paginate(10);
        return view('pemesanan-supplier.index', compact('pemesanans'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('pemesanan-supplier.create', compact('suppliers', 'barangs'));
    }

    public function store(Request $request)
    {
        // Buang baris kosong (yang tidak diisi id_barang)
        $items = collect($request->items)->filter(fn($item) => !empty($item['id_barang']))->values()->all();
        $request->merge(['items' => $items]);

        $validated = $request->validate([
            'id_supplier' => 'required|exists:suppliers,id',
            'tgl_pesan' => 'required|date',
            'status' => 'required|in:diproses,dikirim,selesai,batal',
            'items' => 'required|array|min:1',
            'items.*.id_barang' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $pemesanan = PemesananSupplier::create([
                'id_supplier' => $validated['id_supplier'],
                'tgl_pesan' => $validated['tgl_pesan'],
                'status' => $validated['status'],
            ]);

            foreach ($validated['items'] as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                DetailPesanSupplier::create([
                    'id_pesan_supplier' => $pemesanan->id,
                    'id_barang' => $item['id_barang'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $subtotal,
                ]);
            }
        });

        return redirect()->route('pemesanan-supplier.index')->with('success', 'Pemesanan ke supplier berhasil dibuat.');
    }

    public function show(PemesananSupplier $pemesananSupplier)
    {
        $pemesananSupplier->load('supplier', 'detail.barang');
        return view('pemesanan-supplier.show', ['pemesanan' => $pemesananSupplier]);
    }

    public function edit(PemesananSupplier $pemesananSupplier)
    {
        return view('pemesanan-supplier.edit', ['pemesanan' => $pemesananSupplier]);
    }

    public function update(Request $request, PemesananSupplier $pemesananSupplier)
    {
        $validated = $request->validate([
            'status' => 'required|in:diproses,dikirim,selesai,batal',
        ]);

        $pemesananSupplier->update($validated);

        return redirect()->route('pemesanan-supplier.index')->with('success', 'Status pemesanan berhasil diperbarui.');
    }

    public function destroy(PemesananSupplier $pemesananSupplier)
    {
        $pemesananSupplier->delete();
        return redirect()->route('pemesanan-supplier.index')->with('success', 'Pemesanan berhasil dihapus.');
    }
}
