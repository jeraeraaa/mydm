<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\ProgramStudi;


class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_anggota' => 'required|string|unique:anggota,id_anggota|digits:9',
            'nama_anggota' => 'required|string|regex:/^[a-zA-Z\s]*$/|max:255',
            'email' => 'required|email|unique:anggota,email',
            'password' => 'required|string|min:8|confirmed',
            'tanggal_lahir' => 'required|date|before:' . now()->subYears(17)->format('Y-m-d'),
            'no_hp' => 'required|string|regex:/^[0-9]{10,13}$/',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'id_anggota.required' => 'NIM wajib diisi.',
            'id_anggota.digits' => 'NIM harus terdiri dari 9 digit angka.',
            'nama_anggota.required' => 'Nama wajib diisi.',
            'nama_anggota.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Password tidak cocok.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Usia minimal harus 17 tahun.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP harus terdiri dari 10-13 digit angka.',
            'alamat.required' => 'Alamat wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        // Menentukan prodi berdasarkan 3 digit pertama dari NIM
        $kode_prodi = substr($request->id_anggota, 0, 3);
        $prodi = ProgramStudi::where('id_prodi', $kode_prodi)->first();

        if (!$prodi) {
            return back()->withErrors([
                'id_anggota' => 'Kode prodi tidak valid, tidak ada prodi yang sesuai dengan NIM ini.',
            ])->withInput();
        }

        // Menyiapkan data untuk disimpan ke tabel anggota
        $data = [
            'id_anggota' => $request->id_anggota,
            'nama_anggota' => $request->nama_anggota,
            'email' => $request->email,
            'password' => Hash::make($request->password), // menggunakan password yang di-input oleh pengguna
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'id_prodi' => $prodi->id_prodi,
            'id_role' => 4,
        ];

        // Proses upload foto profil jika ada
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $path = $file->store('foto_profil', 'public');
            $data['foto_profil'] = basename($path);
        }

        // Simpan data anggota ke database
        try {
            Anggota::create($data);
            return redirect('/login')->with('success', 'Pendaftaran berhasil, silakan login.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Pendaftaran gagal' . $e->getMessage()])->withInput();
        }

        Auth::login($anggota);
        return redirect('/login');
    }
}
