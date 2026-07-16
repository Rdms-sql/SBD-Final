<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\ReturPenjualan;
use App\Models\DetailReturPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturPenjualanController extends Controller
{
    public function index()
    {
        $returs = ReturPenjualan::with('penjualan.konsumen')->latest()->paginate(10);
        return view('retur-penjualan.index', compact('returs'));
    }

    public function create()
    {
        $penjualans = Penjualan::with('konsumen')->latest()->get();
        return view('retur-penjualan.create', compact('penjualans'));
    }

    public function store(Request $request)
    {
        $items = collect($request->items)->filter(fn($item) => !empty($item['id_barang']))->values()->all();
        $request->merge(['items' => $items]);
        
        $validated = $request->validate([
            'id_penjualan' => 'required|exists:penjualan,id',
            'tgl_retur' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.id_barang' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.alasan' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated) {
            $retur = ReturPenjualan::create([
                'id_penjualan' => $validated['id_penjualan'],
                'tgl_retur' => $validated['tgl_retur'],
            ]);

            $totalRetur = 0;

            foreach ($validated['items'] as $item) {
                DetailReturPenjualan::create([
                    'id_retur_jual' => $retur->id,
                    'id_barang' => $item['id_barang'],
                    'jumlah' => $item['jumlah'],
                    'alasan' => $item['alasan'] ?? null,
                ]);

                // Stok bertambah karena barang dikembalikan dari konsumen
                $barang = Barang::find($item['id_barang']);
                $barang->increment('stok', $item['jumlah']);
                $totalRetur += $barang->harga_jual * $item['jumlah'];
            }

            // Jika penjualan ini masih ada piutang, kurangi piutangnya
            $penjualan = Penjualan::find($validated['id_penjualan']);
            if ($penjualan->piutang && $penjualan->piutang->sisa_piutang > 0) {
                $pengurangan = min($totalRetur, $penjualan->piutang->sisa_piutang);
                $penjualan->piutang->decrement('sisa_piutang', $pengurangan);
            }
        });

        return redirect()->route('retur-penjualan.index')->with('success', 'Retur penjualan berhasil disimpan.');
    }

    public function show(ReturPenjualan $returPenjualan)
    {
        $returPenjualan->load('penjualan.konsumen', 'detail.barang');
        return view('retur-penjualan.show', ['retur' => $returPenjualan]);
    }

    public function destroy(ReturPenjualan $returPenjualan)
    {
        DB::transaction(function () use ($returPenjualan) {
            foreach ($returPenjualan->detail as $item) {
                Barang::where('id', $item->id_barang)->decrement('stok', $item->jumlah);
            }
            $returPenjualan->delete();
        });

        return redirect()->route('retur-penjualan.index')->with('success', 'Retur penjualan dibatalkan & stok dikembalikan.');
    }
}
