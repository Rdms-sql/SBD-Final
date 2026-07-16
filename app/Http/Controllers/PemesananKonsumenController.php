<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Konsumen;
use App\Models\PemesananKonsumen;
use App\Models\DetailPesanKonsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananKonsumenController extends Controller
{
    public function index()
    {
        $pemesanans = PemesananKonsumen::with('konsumen')->latest()->paginate(10);
        return view('pemesanan-konsumen.index', compact('pemesanans'));
    }

    public function create()
    {
        $konsumens = Konsumen::orderBy('nama_konsumen')->get();
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('pemesanan-konsumen.create', compact('konsumens', 'barangs'));
    }

    public function store(Request $request)
    {
        $items = collect($request->items)->filter(fn($item) => !empty($item['id_barang']))->values()->all();
        $request->merge(['items' => $items]);

        $validated = $request->validate([
            'id_konsumen' => 'required|exists:konsumens,id',
            'tgl_pesan' => 'required|date',
            'status' => 'required|in:diproses,selesai,batal',
            'items' => 'required|array|min:1',
            'items.*.id_barang' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $pemesanan = PemesananKonsumen::create([
                'id_konsumen' => $validated['id_konsumen'],
                'tgl_pesan' => $validated['tgl_pesan'],
                'status' => $validated['status'],
            ]);

            foreach ($validated['items'] as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                DetailPesanKonsumen::create([
                    'id_pesan_konsumen' => $pemesanan->id,
                    'id_barang' => $item['id_barang'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $subtotal,
                ]);
            }
        });

        return redirect()->route('pemesanan-konsumen.index')->with('success', 'Pemesanan konsumen berhasil dibuat.');
    }

    public function show(PemesananKonsumen $pemesanan_konsumen)
    {
        $pemesanan_konsumen->load('konsumen', 'detail.barang');
        return view('pemesanan-konsumen.show', ['pemesanan' => $pemesanan_konsumen]);
    }

    public function edit(PemesananKonsumen $pemesanan_konsumen)
    {
        return view('pemesanan-konsumen.edit', ['pemesanan' => $pemesanan_konsumen]);
    }

    public function update(Request $request, PemesananKonsumen $pemesanan_konsumen)
    {
        $validated = $request->validate([
            'status' => 'required|in:diproses,selesai,batal',
        ]);

        $pemesanan_konsumen->update($validated);

        return redirect()->route('pemesanan-konsumen.index')->with('success', 'Status pemesanan berhasil diperbarui.');
    }

    public function destroy(PemesananKonsumen $pemesanan_konsumen)
    {
        $pemesanan_konsumen->delete();
        return redirect()->route('pemesanan-konsumen.index')->with('success', 'Pemesanan berhasil dihapus.');
    }
}
