<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\ReturPembelian;
use App\Models\DetailReturPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReturPembelianController extends Controller
{
    public function index()
    {
        $returs = ReturPembelian::with('pembelian.supplier')->latest()->paginate(10);
        return view('retur-pembelian.index', compact('returs'));
    }

    public function create()
    {
        $pembelians = Pembelian::with('supplier')->latest()->get();
        return view('retur-pembelian.create', compact('pembelians'));
    }

    public function store(Request $request)
    {
        $items = collect($request->items)->filter(fn($item) => !empty($item['id_barang']))->values()->all();
        $request->merge(['items' => $items]);

        $validated = $request->validate([
            'id_pembelian' => 'required|exists:pembelian,id',
            'tgl_retur' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.id_barang' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.alasan' => 'nullable|string|max:255',
        ]);

        // Cek stok cukup untuk diretur balik ke supplier
        foreach ($validated['items'] as $item) {
            $barang = Barang::findOrFail($item['id_barang']);
            if ($barang->stok < $item['jumlah']) {
                throw ValidationException::withMessages([
                    'items' => "Stok {$barang->nama_barang} tidak cukup untuk diretur.",
                ]);
            }
        }

        DB::transaction(function () use ($validated) {
            $retur = ReturPembelian::create([
                'id_pembelian' => $validated['id_pembelian'],
                'tgl_retur' => $validated['tgl_retur'],
            ]);

            $totalRetur = 0;

            foreach ($validated['items'] as $item) {
                DetailReturPembelian::create([
                    'id_retur_beli' => $retur->id,
                    'id_barang' => $item['id_barang'],
                    'jumlah' => $item['jumlah'],
                    'alasan' => $item['alasan'] ?? null,
                ]);

                // Stok berkurang karena barang dikembalikan ke supplier
                $barang = Barang::find($item['id_barang']);
                $barang->decrement('stok', $item['jumlah']);
                $totalRetur += $barang->harga_jual * $item['jumlah'];
            }

            // Jika pembelian ini masih ada hutang, kurangi hutangnya
            $pembelian = Pembelian::find($validated['id_pembelian']);
            if ($pembelian->hutang && $pembelian->hutang->sisa_hutang > 0) {
                $pengurangan = min($totalRetur, $pembelian->hutang->sisa_hutang);
                $pembelian->hutang->decrement('sisa_hutang', $pengurangan);
            }
        });

        return redirect()->route('retur-pembelian.index')->with('success', 'Retur pembelian berhasil disimpan.');
    }

    public function show(ReturPembelian $returPembelian)
    {
        $returPembelian->load('pembelian.supplier', 'detail.barang');
        return view('retur-pembelian.show', ['retur' => $returPembelian]);
    }

    public function destroy(ReturPembelian $returPembelian)
    {
        DB::transaction(function () use ($returPembelian) {
            foreach ($returPembelian->detail as $item) {
                Barang::where('id', $item->id_barang)->increment('stok', $item->jumlah);
            }
            $returPembelian->delete();
        });

        return redirect()->route('retur-pembelian.index')->with('success', 'Retur pembelian dibatalkan & stok dikembalikan.');
    }
}
