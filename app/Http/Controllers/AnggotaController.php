<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Prodi;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class AnggotaController extends Controller
{

    // Menampilkan daftar anggota
    public function index()
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $anggota = Anggota::all();
            $prodi = ProgramStudi::all();
            return view('anggota.index', compact('anggota', 'prodi'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    // Menampilkan form untuk menambah anggota
    public function create()
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            return view('anggota.create');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    // Menyimpan data anggota baru
    public function store(Request $request)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            // Validasi input
            $request->validate([
                'id_anggota' => 'required|string|unique:anggota,id_anggota|digits:9',
                'nama_anggota' => 'required|string|regex:/^[a-zA-Z\s]*$/|max:255',
                'email' => 'required|email|unique:anggota',
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
            $prodi = ProgramStudi::where('id_prodi', $kode_prodi)->first();

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
            $data['id_role'] = 4; 

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
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    public function edit($id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $anggota = Anggota::findOrFail($id);
            return view('anggota.edit', compact('anggota'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $anggota = Anggota::findOrFail($id);

            $request->validate([
                'id_anggota' => 'required|string|digits:9|unique:anggota,id_anggota,' . $anggota->id_anggota . ',id_anggota',
                'nama_anggota' => 'required|string|regex:/^[a-zA-Z\s]*$/|max:255',
                'email' => 'required|email|unique:anggota,email,' . $anggota->id_anggota . ',id_anggota',
                'tanggal_lahir' => 'required|date|before:' . now()->subYears(17)->format('Y-m-d'),
                'no_hp' => 'required|string|regex:/^[0-9]{10,13}$/',
                'alamat' => 'required|string',
                'jenis_kelamin' => 'required|in:L,P',
                'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = $request->all();

            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada
                if ($anggota->foto_profil && file_exists(storage_path('app/public/foto_profil/' . $anggota->foto_profil))) {
                    unlink(storage_path('app/public/foto_profil/' . $anggota->foto_profil));
                }

                // Simpan foto baru
                $file = $request->file('foto_profil');
                $path = $file->store('foto_profil', 'public');
                $data['foto_profil'] = basename($path);
            }

            $anggota->update($data);
            return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }


    // Menghapus data anggota
    public function destroy($id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $anggota = Anggota::find($id);

            if (!$anggota) {
                return back()->withErrors(['error' => 'Anggota tidak ditemukan.']);
            }

            try {
                $anggota->delete();
                return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
            } catch (\Exception $e) {
                return back()->withErrors([
                    'error' => 'Gagal menghapus anggota: ' . $e->getMessage(),
                ]);
            }
        } else {
            abort(403, 'Akses Ditolak');
        }
    }
}
