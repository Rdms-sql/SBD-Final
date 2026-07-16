<?php

namespace App\Http\Controllers;

use App\Models\Hutang;

class HutangController extends Controller
{
    public function index()
    {
        $hutangs = Hutang::with('pembelian.supplier')->where('sisa_hutang', '>', 0)->latest()->paginate(10);
        return view('hutang.index', compact('hutangs'));
    }

    public function show(Hutang $hutang)
    {
        $hutang->load('pembelian.supplier', 'pembayaran');
        return view('hutang.show', compact('hutang'));
    }
}
