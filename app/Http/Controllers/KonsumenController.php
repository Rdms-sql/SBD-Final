<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use Illuminate\Http\Request;

class KonsumenController extends Controller
{
    public function index()
    {
        $konsumens = Konsumen::latest()->paginate(10);
        return view('konsumen.index', compact('konsumens'));
    }

    public function create()
    {
        return view('konsumen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_konsumen' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        Konsumen::create($validated);

        return redirect()->route('konsumen.index')->with('success', 'Konsumen berhasil ditambahkan.');
    }

    public function show(Konsumen $konsumen)
    {
        $konsumen->load('penjualan');
        return view('konsumen.show', compact('konsumen'));
    }

    public function edit(Konsumen $konsumen)
    {
        return view('konsumen.edit', compact('konsumen'));
    }

    public function update(Request $request, Konsumen $konsumen)
    {
        $validated = $request->validate([
            'nama_konsumen' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $konsumen->update($validated);

        return redirect()->route('konsumen.index')->with('success', 'Konsumen berhasil diperbarui.');
    }

    public function destroy(Konsumen $konsumen)
    {
        $konsumen->delete();
        return redirect()->route('konsumen.index')->with('success', 'Konsumen berhasil dihapus.');
    }
}
