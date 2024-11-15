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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'tahun_jabatan' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        // Simpan data ketua umum
        KetuaUmum::create([
            'id_anggota' => $request->id_anggota,
            'tahun_jabatan' => $request->tahun_jabatan,
        ]);

        return redirect()->route('ketua-umum.index')->with('success', 'Data Ketua Umum berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ketuaUmum = KetuaUmum::findOrFail($id);
        $anggota = Anggota::all(); // Ambil semua data anggota untuk dropdown
        return view('ketua-umum.edit', compact('ketuaUmum', 'anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'tahun_jabatan' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        // Update data ketua umum
        $ketuaUmum = KetuaUmum::findOrFail($id);
        $ketuaUmum->update([
            'id_anggota' => $request->id_anggota,
            'tahun_jabatan' => $request->tahun_jabatan,
        ]);

        return redirect()->route('ketua-umum.index')->with('success', 'Data Ketua Umum berhasil diperbarui.');
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
