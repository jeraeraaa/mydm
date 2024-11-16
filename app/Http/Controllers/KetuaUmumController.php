<?php

namespace App\Http\Controllers;

use App\Models\KetuaUmum;
use App\Models\Anggota; // Karena ada relasi dengan anggota
use Illuminate\Http\Request;

class KetuaUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data ketua umum beserta nama anggota terkait
        $ketuaUmum = KetuaUmum::with('anggota')->get();
        $anggota = Anggota::all(); // Ambil semua data anggota untuk dropdown

        return view('ketua-umum.index', compact('ketuaUmum', 'anggota'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggota = Anggota::all(); // Ambil semua data anggota untuk dropdown
        return view('ketua-umum.create', compact('anggota'));
    }

    public function store(Request $request)
    {
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
    }

    public function update(Request $request, $id)
    {
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
    }



    public function edit($id)
    {
        $ketuaUmum = KetuaUmum::findOrFail($id);
        $anggota = Anggota::all(); // Ambil semua data anggota untuk dropdown
        return view('ketua-umum.edit', compact('ketuaUmum', 'anggota'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Hapus data ketua umum
        $ketuaUmum = KetuaUmum::findOrFail($id);
        $ketuaUmum->delete();

        return redirect()->route('ketua-umum.index')->with('success', 'Data Ketua Umum berhasil dihapus.');
    }
}
