<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Hutang;
use App\Models\Piutang;
use App\Models\Penjualan;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function penjualan(Request $request)
    {
        $dariTanggal = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampaiTanggal = $request->input('sampai', now()->toDateString());

        $penjualans = Penjualan::with('konsumen', 'user')
            ->whereBetween('tgl_penjualan', [$dariTanggal, $sampaiTanggal])
            ->orderBy('tgl_penjualan')
            ->get();

        $totalPenjualan = $penjualans->sum('total_jual');
        $totalTransaksi = $penjualans->count();
        $totalLunas = $penjualans->where('status_bayar', 'lunas')->sum('total_jual');
        $totalBelumLunas = $penjualans->where('status_bayar', 'belum_lunas')->sum('total_jual');

        return view('laporan.penjualan', compact(
            'penjualans',
            'dariTanggal',
            'sampaiTanggal',
            'totalPenjualan',
            'totalTransaksi',
            'totalLunas',
            'totalBelumLunas'
        ));
    }

    public function pembelian(Request $request)
    {
        $dariTanggal = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampaiTanggal = $request->input('sampai', now()->toDateString());

        $pembelians = Pembelian::with('supplier', 'user')
            ->whereBetween('tgl_pembelian', [$dariTanggal, $sampaiTanggal])
            ->orderBy('tgl_pembelian')
            ->get();

        $totalPembelian = $pembelians->sum('total_beli');
        $totalTransaksi = $pembelians->count();
        $totalLunas = $pembelians->where('status_bayar', 'lunas')->sum('total_beli');
        $totalBelumLunas = $pembelians->where('status_bayar', 'belum_lunas')->sum('total_beli');

        return view('laporan.pembelian', compact(
            'pembelians',
            'dariTanggal',
            'sampaiTanggal',
            'totalPembelian',
            'totalTransaksi',
            'totalLunas',
            'totalBelumLunas'
        ));
    }

    public function hutangPiutang()
    {
        $hutangs = Hutang::with('pembelian.supplier')
            ->where('sisa_hutang', '>', 0)
            ->orderBy('jatuh_tempo')
            ->get();

        $piutangs = Piutang::with('penjualan.konsumen')
            ->where('sisa_piutang', '>', 0)
            ->orderBy('jatuh_tempo')
            ->get();

        $totalHutang = $hutangs->sum('sisa_hutang');
        $totalPiutang = $piutangs->sum('sisa_piutang');

        return view('laporan.hutang-piutang', compact(
            'hutangs',
            'piutangs',
            'totalHutang',
            'totalPiutang'
        ));
    }

    public function stok()
    {
        $barangs = Barang::with('supplier')->orderBy('nama_barang')->get();

        $totalNilaiStok = $barangs->sum(fn($barang) => $barang->stok * $barang->harga_jual);
        $totalBarang = $barangs->count();
        $stokMenipis = $barangs->where('stok', '<=', 10)->count();
        $stokHabis = $barangs->where('stok', 0)->count();

        return view('laporan.stok', compact(
            'barangs',
            'totalNilaiStok',
            'totalBarang',
            'stokMenipis',
            'stokHabis'
        ));
    }
}
