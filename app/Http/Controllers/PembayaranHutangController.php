<?php

namespace App\Http\Controllers;

use App\Models\Hutang;
use App\Models\PembayaranHutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PembayaranHutangController extends Controller
{
    public function store(Request $request, Hutang $hutang)
    {
        $validated = $request->validate([
            'tgl_bayar' => 'required|date',
            'jumlah_bayar' => 'required|integer|min:1',
        ]);

        if ($validated['jumlah_bayar'] > $hutang->sisa_hutang) {
            throw ValidationException::withMessages([
                'jumlah_bayar' => 'Jumlah bayar melebihi sisa hutang (Rp ' . number_format($hutang->sisa_hutang, 0, ',', '.') . ').',
            ]);
        }

        DB::transaction(function () use ($validated, $hutang) {
            PembayaranHutang::create([
                'id_hutang' => $hutang->id,
                'tgl_bayar' => $validated['tgl_bayar'],
                'jumlah_bayar' => $validated['jumlah_bayar'],
            ]);

            $hutang->decrement('sisa_hutang', $validated['jumlah_bayar']);

            // Jika lunas, update status pembelian
            if ($hutang->fresh()->sisa_hutang <= 0) {
                $hutang->pembelian->update(['status_bayar' => 'lunas']);
            }
        });

        return redirect()->route('hutang.show', $hutang)->with('success', 'Pembayaran hutang berhasil dicatat.');
    }
}
