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
        // Validasi kredensial
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah email terdaftar di tabel anggota
        $anggota = Anggota::where('email', $request->email)->first();

        if (!$anggota) {
            // Jika email tidak ditemukan, arahkan ke halaman register
            return back()->withErrors([
                'email' => 'Akun tidak ditemukan. Silakan daftar terlebih dahulu.',
            ]);
        }

        // Autentikasi pengguna
        if (Auth::guard('anggota')->attempt($credentials)) {
            $request->session()->regenerate();

            // Panggil fungsi `authenticated` untuk pengalihan sesuai role
            return $this->authenticated($request, Auth::guard('anggota')->user());
        }

        // Jika autentikasi gagal karena password salah
        return back()->withErrors([
            'password' => 'Password yang Anda masukkan salah.',
        ])->withInput(); // Mengembalikan input email
    }

    protected function authenticated(Request $request, $user)
    {
        // Cek role pengguna dan arahkan ke halaman sesuai role
        if ($user->role && $user->role->name === 'admin' || $user->role->name === 'super_user' || $user->role->name === 'inventaris') {
            return redirect()->route('dashboard');
        } elseif ($user->role && $user->role->name === 'anggota') {
            return redirect()->route('home'); // arahkan ke halaman alat frontend
        }

        // Pengalihan default jika role tidak sesuai
        return redirect()->route('home');
    }
}
