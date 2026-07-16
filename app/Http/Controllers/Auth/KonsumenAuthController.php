<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Konsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class KonsumenAuthController extends Controller
{
    public function showRegister()
    {
        return view('auth-konsumen.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_konsumen' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20|unique:konsumens,no_hp',
            'alamat' => 'nullable|string',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $konsumen = Konsumen::create([
            'nama_konsumen' => $validated['nama_konsumen'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('konsumen')->login($konsumen);

        return redirect()->route('pesanan-publik.create');
    }

    public function showLogin()
    {
        return view('auth-konsumen.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'no_hp' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('konsumen')->attempt([
            'no_hp' => $validated['no_hp'],
            'password' => $validated['password'],
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('pesanan-publik.create');
        }

        return back()->withErrors([
            'no_hp' => 'No HP atau password salah.',
        ])->onlyInput('no_hp');
    }

    public function logout(Request $request)
    {
        Auth::guard('konsumen')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('konsumen.login');
    }
}
