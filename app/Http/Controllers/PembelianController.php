<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Hutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\PemesananKonsumen;
use App\Models\Piutang;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::with('supplier', 'user')->latest()->paginate(10);
        return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('pembelian.create', compact('suppliers', 'barangs'));
    }

    public function store(Request $request)
    {
        $items = collect($request->items)->filter(fn($item) => !empty($item['id_barang']))->values()->all();
        $request->merge(['items' => $items]);

        $validated = $request->validate([
            'id_supplier' => 'required|exists:suppliers,id',
            'tgl_pembelian' => 'required|date',
            'status_bayar' => 'required|in:lunas,belum_lunas',
            'jatuh_tempo' => 'nullable|date|required_if:status_bayar,belum_lunas',
            'items' => 'required|array|min:1',
            'items.*.id_barang' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $total = 0;
            foreach ($validated['items'] as $item) {
                $total += $item['jumlah'] * $item['harga_satuan'];
            }

            $pembelian = Pembelian::create([
                'id_supplier' => $validated['id_supplier'],
                'id_user' => Auth::id(),
                'tgl_pembelian' => $validated['tgl_pembelian'],
                'status_bayar' => $validated['status_bayar'],
                'total_beli' => $total,
            ]);

            foreach ($validated['items'] as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];

                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id,
                    'id_barang' => $item['id_barang'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $subtotal,
                ]);

                // Stok bertambah karena kita membeli dari supplier
                Barang::where('id', $item['id_barang'])->increment('stok', $item['jumlah']);
            }

            // Jika belum lunas, otomatis buat catatan hutang
            if ($validated['status_bayar'] === 'belum_lunas') {
                Hutang::create([
                    'id_pembelian' => $pembelian->id,
                    'sisa_hutang' => $total,
                    'jatuh_tempo' => $validated['jatuh_tempo'] ?? null,
                ]);
            }
        });

        return redirect()->route('pembelian.index')->with('success', 'Transaksi pembelian berhasil disimpan.');
    }

    public function show(Pembelian $pembelian)
    {
        $pembelian->load('supplier', 'user', 'detail.barang', 'hutang');
        return view('pembelian.show', compact('pembelian'));
    }

    public function cetak(Pembelian $pembelian)
    {
        $pembelian->load('supplier', 'user', 'detail.barang', 'hutang');
        return view('pembelian.cetak', compact('pembelian'));
    }

    public function destroy(Pembelian $pembelian)
    {
        DB::transaction(function () use ($pembelian) {
            // Kembalikan stok yang sudah bertambah sebelumnya
            foreach ($pembelian->detail as $item) {
                Barang::where('id', $item->id_barang)->decrement('stok', $item->jumlah);
            }
            $pembelian->delete(); // cascade akan menghapus detail & hutang terkait
        });

        return redirect()->route('pembelian.index')->with('success', 'Transaksi pembelian berhasil dihapus & stok dikembalikan.');
    }
    public function proses(Request $request, PemesananKonsumen $pemesanan_konsumen)
    {
        abort_if($pemesanan_konsumen->id_penjualan, 400, 'Pesanan ini sudah diproses menjadi transaksi.');
        abort_if($pemesanan_konsumen->status !== 'diproses', 400, 'Hanya pesanan berstatus diproses yang bisa dikonversi.');

        $validated = $request->validate([
            'status_bayar' => 'required|in:lunas,belum_lunas',
            'jatuh_tempo' => 'nullable|date|required_if:status_bayar,belum_lunas',
        ]);

        $pemesanan_konsumen->load('detail.barang');

        foreach ($pemesanan_konsumen->detail as $item) {
            if ($item->barang->stok < $item->jumlah) {
                return back()->withErrors([
                    'items' => "Stok {$item->barang->nama_barang} tidak cukup. Sisa stok: {$item->barang->stok}",
                ]);
            }
        }

        DB::transaction(function () use ($pemesanan_konsumen, $validated) {
            $total = $pemesanan_konsumen->detail->sum('subtotal');

            $penjualan = Penjualan::create([
                'id_konsumen' => $pemesanan_konsumen->id_konsumen,
                'id_user' => Auth::id(),
                'tgl_penjualan' => now()->toDateString(),
                'status_bayar' => $validated['status_bayar'],
                'total_jual' => $total,
            ]);

            foreach ($pemesanan_konsumen->detail as $item) {
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_barang' => $item->id_barang,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->harga_satuan,
                    'subtotal' => $item->subtotal,
                ]);

                Barang::where('id', $item->id_barang)->decrement('stok', $item->jumlah);
            }

            if ($validated['status_bayar'] === 'belum_lunas') {
                Piutang::create([
                    'id_penjualan' => $penjualan->id,
                    'sisa_piutang' => $total,
                    'jatuh_tempo' => $validated['jatuh_tempo'],
                ]);
            }

            $pemesanan_konsumen->update([
                'status' => 'selesai',
                'id_penjualan' => $penjualan->id,
            ]);
        });

        return redirect()->route('pemesanan-konsumen.show', $pemesanan_konsumen)
            ->with('success', 'Pesanan berhasil diproses menjadi transaksi penjualan.');
    }
}
