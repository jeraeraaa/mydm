<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah email terdaftar
        $anggota = Anggota::where('email', $request->email)->first();

        if (!$anggota) {
            // Jika email tidak ditemukan, arahkan ke halaman register
            return back()->withErrors([
                'email' => 'Akun tidak ditemukan. Silakan daftar terlebih dahulu.',
            ]);
        }

        // Jika email ditemukan, lakukan autentikasi
        if (Auth::guard('anggota')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // Jika password salah
        return back()->withErrors([
            'password' => 'Password yang Anda masukkan salah.',
        ])->withInput(); // Mengembalikan input email
    }
}
