<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Konsumen;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Piutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('konsumen', 'user')->latest()->paginate(10);
        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $konsumens = Konsumen::orderBy('nama_konsumen')->get();
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('penjualan.create', compact('konsumens', 'barangs'));
    }

    public function store(Request $request)
    {
        $items = collect($request->items)->filter(fn($item) => !empty($item['id_barang']))->values()->all();
        $request->merge(['items' => $items]);

        $validated = $request->validate([
            'id_konsumen' => 'required|exists:konsumens,id',
            'tgl_penjualan' => 'required|date',
            'status_bayar' => 'required|in:lunas,belum_lunas',
            'jatuh_tempo' => 'nullable|date|required_if:status_bayar,belum_lunas',
            'items' => 'required|array|min:1',
            'items.*.id_barang' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|integer|min:0',
        ]);

        // Cek stok cukup sebelum diproses
        foreach ($validated['items'] as $item) {
            $barang = Barang::findOrFail($item['id_barang']);
            if ($barang->stok < $item['jumlah']) {
                throw ValidationException::withMessages([
                    'items' => "Stok {$barang->nama_barang} tidak cukup. Sisa stok: {$barang->stok}",
                ]);
            }
        }

        DB::transaction(function () use ($validated) {
            $total = 0;
            foreach ($validated['items'] as $item) {
                $total += $item['jumlah'] * $item['harga_satuan'];
            }

            $penjualan = Penjualan::create([
                'id_konsumen' => $validated['id_konsumen'],
                'id_user' => Auth::id(),
                'tgl_penjualan' => $validated['tgl_penjualan'],
                'status_bayar' => $validated['status_bayar'],
                'total_jual' => $total,
            ]);

            foreach ($validated['items'] as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];

                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_barang' => $item['id_barang'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $subtotal,
                ]);

                // Stok berkurang karena dijual ke konsumen
                Barang::where('id', $item['id_barang'])->decrement('stok', $item['jumlah']);
            }

            if ($validated['status_bayar'] === 'belum_lunas') {
                Piutang::create([
                    'id_penjualan' => $penjualan->id,
                    'sisa_piutang' => $total,
                    'jatuh_tempo' => $validated['jatuh_tempo'] ?? null,
                ]);
            }
        });

        return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil disimpan.');
    }

    public function show(Penjualan $penjualan)
    {
        $penjualan->load('konsumen', 'user', 'detail.barang', 'piutang');
        return view('penjualan.show', compact('penjualan'));
    }

    public function cetak(Penjualan $penjualan)
    {
        $penjualan->load('konsumen', 'user', 'detail.barang', 'piutang');
        return view('penjualan.cetak', compact('penjualan'));
    }
    

    public function destroy(Penjualan $penjualan)
    {
        DB::transaction(function () use ($penjualan) {
            // Kembalikan stok yang sudah berkurang sebelumnya
            foreach ($penjualan->detail as $item) {
                Barang::where('id', $item->id_barang)->increment('stok', $item->jumlah);
            }
            $penjualan->delete();
        });

        return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil dihapus & stok dikembalikan.');
    }
}
