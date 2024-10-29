<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/login');  // Redirect to the home page
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_anggota' => 'required|string|unique:anggota,id_anggota|digits:9',
            'nama_anggota' => 'required|string|regex:/^[a-zA-Z\s]*$/|max:255',
            'email' => 'required|email|unique:anggota',
            'password' => 'required|string|min:8|confirmed',
            'tanggal_lahir' => 'required|date|before:' . now()->subYears(17)->format('Y-m-d'),
            'no_hp' => 'required|string|regex:/^[0-9]{10,13}$/', // Nomor HP hanya angka, panjang antara 10-13 digit
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
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Usia minimal harus 17 tahun.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP harus terdiri dari 10-13 digit angka.',
            'alamat.required' => 'Alamat wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        // Menentukan prodi dan fakultas berdasarkan 3 digit pertama dari NIM
        $nim = $request->id_anggota;
        $kode_prodi = substr($nim, 0, 3); // mengambil 3 digit pertama

        // Mencari prodi berdasarkan kode_prodi
        $prodi = Prodi::where('id_prodi', $kode_prodi)->first();

        if (!$prodi) {
            return back()->withErrors([
                'id_anggota' => 'Kode prodi tidak valid, tidak ada prodi yang sesuai dengan NIM ini.',
            ])->withInput();
        }

        // Membuat password default dari nama anggota + tanggal lahir
        $tanggal_lahir = \Carbon\Carbon::parse($request->tanggal_lahir)->format('dmY'); // format ddmmyyyy
        $password_default = strtolower($request->nama_anggota) . $tanggal_lahir;

        // Menyiapkan data untuk disimpan
        $data = $request->all();
        $data['id_prodi'] = $prodi->id_prodi;
        $data['password'] = bcrypt($password_default);

        // Proses upload foto profil jika ada
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $path = $file->store('foto_profil', 'public'); // Gunakan disk 'public'
            $data['foto_profil'] = basename($path);
        }

        // Simpan data ke database
        try {
            Anggota::create($data);
            return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan dengan password default.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Gagal menambahkan anggota: ' . $e->getMessage(),
            ])->withInput();
        }
    }
}
