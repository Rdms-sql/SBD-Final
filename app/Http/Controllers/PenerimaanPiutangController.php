<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use App\Models\PenerimaanPiutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PenerimaanPiutangController extends Controller
{
    public function store(Request $request, Piutang $piutang)
    {
        $validated = $request->validate([
            'tgl_terima' => 'required|date',
            'jumlah_terima' => 'required|integer|min:1',
        ]);

        if ($validated['jumlah_terima'] > $piutang->sisa_piutang) {
            throw ValidationException::withMessages([
                'jumlah_terima' => 'Jumlah terima melebihi sisa piutang (Rp ' . number_format($piutang->sisa_piutang, 0, ',', '.') . ').',
            ]);
        }

        DB::transaction(function () use ($validated, $piutang) {
            PenerimaanPiutang::create([
                'id_piutang' => $piutang->id,
                'tgl_terima' => $validated['tgl_terima'],
                'jumlah_terima' => $validated['jumlah_terima'],
            ]);

            $piutang->decrement('sisa_piutang', $validated['jumlah_terima']);

            if ($piutang->fresh()->sisa_piutang <= 0) {
                $piutang->penjualan->update(['status_bayar' => 'lunas']);
            }
        });

        return redirect()->route('piutang.show', $piutang)->with('success', 'Penerimaan piutang berhasil dicatat.');
    }
}
