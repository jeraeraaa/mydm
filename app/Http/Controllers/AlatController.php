<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Bph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlatController extends Controller
{
    public function index()
    {
        $alat = Alat::with('bph')->get();
        $bph = Bph::all();
        return view('alat.index', compact('alat', 'bph'));
    }

    public function create()
    {
        $bphList = Bph::all();
        return view('alat.create', compact('bphList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bph' => 'required|string|exists:bph,id_bph',
            'nama_alat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jumlah_tersedia' => 'required|integer|min:1',
            'foto' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $lastId = Alat::where('id_bph', $request->id_bph)->max('id_alat');
        $increment = $lastId ? intval(substr($lastId, -3)) + 1 : 1;
        $id_alat = $request->id_bph . '-' . str_pad($increment, 3, '0', STR_PAD_LEFT);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoName = Str::random(10) . '.' . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move(storage_path('app/public/alats'), $fotoName);
            $fotoPath = 'alats/' . $fotoName;
        }

        Alat::create([
            'id_alat' => $id_alat,
            'id_bph' => $request->id_bph,
            'nama_alat' => $request->nama_alat,
            'deskripsi' => $request->deskripsi,
            'jumlah_tersedia' => $request->jumlah_tersedia,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alat $alat)
    {
        $bphList = Bph::all();
        return view('alat.edit', compact('alat', 'bphList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jumlah_tersedia' => 'required|integer',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($alat->foto && file_exists(storage_path('app/public/' . $alat->foto))) {
                unlink(storage_path('app/public/' . $alat->foto));
            }

            $fotoName = Str::random(10) . '.' . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move(storage_path('app/public/alats'), $fotoName);
            $alat->foto = 'alats/' . $fotoName;
        }

        $alat->update([
            'nama_alat' => $request->nama_alat,
            'deskripsi' => $request->deskripsi,
            'jumlah_tersedia' => $request->jumlah_tersedia,
            'foto' => $alat->foto,
        ]);

        return redirect()->route('alat.index')->with('success', 'Alat berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alat $alat)
    {
        if ($alat->foto && file_exists(storage_path('app/public/' . $alat->foto))) {
            unlink(storage_path('app/public/' . $alat->foto));
        }

        $alat->delete();

        return redirect()->route('alat.index')->with('success', 'Alat berhasil dihapus.');
    }
}
