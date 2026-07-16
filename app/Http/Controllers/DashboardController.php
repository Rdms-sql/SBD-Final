<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Hutang;
use App\Models\Piutang;
use App\Models\Penjualan;
use App\Models\Pembelian;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalStokMenipis = Barang::where('stok', '<=', 10)->count();
        $totalHutang = Hutang::sum('sisa_hutang');
        $totalPiutang = Piutang::sum('sisa_piutang');

        $penjualanHariIni = Penjualan::whereDate('tgl_penjualan', today())->sum('total_jual');
        $pembelianHariIni = Pembelian::whereDate('tgl_pembelian', today())->sum('total_beli');

        $barangMenipis = Barang::where('stok', '<=', 10)->orderBy('stok')->take(5)->get();

        return view('dashboard', compact(
            'totalBarang',
            'totalStokMenipis',
            'totalHutang',
            'totalPiutang',
            'penjualanHariIni',
            'pembelianHariIni',
            'barangMenipis'
        ));
    }
}
