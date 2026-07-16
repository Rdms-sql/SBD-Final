<?php

namespace App\Http\Controllers;

use App\Models\Piutang;

class PiutangController extends Controller
{
    public function index()
    {
        $piutangs = Piutang::with('penjualan.konsumen')->where('sisa_piutang', '>', 0)->latest()->paginate(10);
        return view('piutang.index', compact('piutangs'));
    }

    public function show(Piutang $piutang)
    {
        $piutang->load('penjualan.konsumen', 'penerimaan');
        return view('piutang.show', compact('piutang'));
    }
}
