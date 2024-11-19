<?php

namespace App\Http\Controllers;

use App\Models\KetuaUmum;
use App\Models\Anggota; // Karena ada relasi dengan anggota
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KetuaUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            // Ambil data ketua umum beserta nama anggota terkait
            $ketuaUmum = KetuaUmum::with('anggota')->get();
            $anggota = Anggota::all(); // Ambil semua data anggota untuk dropdown

            return view('ketua-umum.index', compact('ketuaUmum', 'anggota'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $anggota = Anggota::all(); // Ambil semua data anggota untuk dropdown
            return view('ketua-umum.create', compact('anggota'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    public function store(Request $request)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $request->validate([
                'id_anggota' => 'required',
                'tahun_jabatan' => 'required|integer|min:1900|max:' . date('Y'),
            ]);

            // Cek apakah id_anggota ada di tabel anggota
            $anggota = Anggota::where('id_anggota', $request->id_anggota)->first();
            if (!$anggota) {
                return redirect()->route('ketua-umum.index')->with('error', 'ID Anggota tidak ditemukan.');
            }

            // Simpan data ketua umum
            KetuaUmum::create([
                'id_anggota' => $request->id_anggota,
                'tahun_jabatan' => $request->tahun_jabatan,
            ]);

            return redirect()->route('ketua-umum.index')->with('success', 'Data Ketua Umum berhasil ditambahkan.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $request->validate([
                'id_anggota' => 'required',
                'tahun_jabatan' => 'required|integer|min:1900|max:' . date('Y'),
            ]);

            // Cek apakah id_anggota ada di tabel anggota
            $anggota = Anggota::where('id_anggota', $request->id_anggota)->first();
            if (!$anggota) {
                return redirect()->route('ketua-umum.index')->with('error', 'ID Anggota tidak ditemukan.');
            }

            // Update data ketua umum
            $ketum = KetuaUmum::findOrFail($id);
            $ketum->update([
                'id_anggota' => $request->id_anggota,
                'tahun_jabatan' => $request->tahun_jabatan,
            ]);

            return redirect()->route('ketua-umum.index')->with('success', 'Data Ketua Umum berhasil diperbarui.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }



    public function edit($id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $ketuaUmum = KetuaUmum::findOrFail($id);
            $anggota = Anggota::all(); // Ambil semua data anggota untuk dropdown
            return view('ketua-umum.edit', compact('ketuaUmum', 'anggota'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            // Hapus data ketua umum
            $ketuaUmum = KetuaUmum::findOrFail($id);
            $ketuaUmum->delete();

            return redirect()->route('ketua-umum.index')->with('success', 'Data Ketua Umum berhasil dihapus.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }
}
