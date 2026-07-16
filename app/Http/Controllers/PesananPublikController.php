<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PemesananKonsumen;
use App\Models\DetailPesanKonsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananPublikController extends Controller
{
    public function create()
    {
        $barangs = Barang::where('stok', '>', 0)->orderBy('nama_barang')->get();
        $konsumen = Auth::guard('konsumen')->user();

        return view('pesanan-publik.create', compact('barangs', 'konsumen'));
    }

    public function store(Request $request)
    {
        $items = collect($request->items)->filter(fn($item) => !empty($item['id_barang']))->values()->all();
        $request->merge(['items' => $items]);

        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id_barang' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        $konsumen = Auth::guard('konsumen')->user();

        foreach ($validated['items'] as $item) {
            $barang = Barang::findOrFail($item['id_barang']);
            if ($barang->stok < $item['jumlah']) {
                return back()->withErrors([
                    'items' => "Maaf, stok {$barang->nama_barang} tidak cukup. Sisa stok: {$barang->stok}",
                ])->withInput();
            }
        }

        $pemesanan = DB::transaction(function () use ($validated, $konsumen) {
            $pemesanan = PemesananKonsumen::create([
                'id_konsumen' => $konsumen->id,
                'tgl_pesan' => now()->toDateString(),
                'status' => 'diproses',
            ]);

            foreach ($validated['items'] as $item) {
                $barang = Barang::findOrFail($item['id_barang']);
                $subtotal = $item['jumlah'] * $barang->harga_jual;

                DetailPesanKonsumen::create([
                    'id_pesan_konsumen' => $pemesanan->id,
                    'id_barang' => $barang->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $barang->harga_jual,
                    'subtotal' => $subtotal,
                ]);
            }

            return $pemesanan;
        });

        return redirect()->route('pesanan-publik.success', $pemesanan);
    }

    public function success(PemesananKonsumen $pemesanan_konsumen)
    {
        abort_unless(
            (int) $pemesanan_konsumen->id_konsumen === (int) Auth::guard('konsumen')->id(),
            403
        );

        $pemesanan_konsumen->load('detail.barang');

        return view('pesanan-publik.success', ['pemesanan' => $pemesanan_konsumen]);
    }

    public function riwayat()
    {
        $pemesanans = PemesananKonsumen::with('penjualan.piutang')
            ->where('id_konsumen', Auth::guard('konsumen')->id())
            ->latest()
            ->paginate(10);

        return view('pesanan-saya.index', compact('pemesanans'));
    }

    public function riwayatShow(PemesananKonsumen $pemesanan_konsumen)
    {
        abort_unless(
            (int) $pemesanan_konsumen->id_konsumen === (int) Auth::guard('konsumen')->id(),
            403
        );

        $pemesanan_konsumen->load('detail.barang', 'penjualan.piutang.penerimaan');

        return view('pesanan-saya.show', ['pemesanan' => $pemesanan_konsumen]);
    }
}
