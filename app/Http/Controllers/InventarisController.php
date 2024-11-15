<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Anggota; // Karena ada relasi dengan anggota
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data inventaris beserta nama anggota terkait
        $inventaris = Inventaris::with('anggota')->get(); // Asumsi relasi anggota sudah dibuat
        return view('inventaris.index', compact('inventaris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggota = Anggota::all(); // Ambil semua data anggota untuk dropdown
        return view('inventaris.create', compact('anggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'tahun_jabatan' => 'required|integer|min:1900|max:' . date('Y'),
        ]);
    
        $lastInventaris = Inventaris::orderBy('created_at', 'desc')->first();
        $newIdNumber = $lastInventaris ? ((int) str_replace('INV-', '', $lastInventaris->id_inventaris)) + 1 : 1;
        $newIdInventaris = 'INV-' . str_pad($newIdNumber, 3, '0', STR_PAD_LEFT);
    
        // Debugging untuk memastikan data yang akan disimpan
        dd([
            'id_inventaris' => $newIdInventaris,
            'id_anggota' => $request->id_anggota,
            'tahun_jabatan' => $request->tahun_jabatan,
        ]);
    
        Inventaris::create([
            'id_inventaris' => $newIdInventaris,
            'id_anggota' => $request->id_anggota,
            'tahun_jabatan' => $request->tahun_jabatan,
        ]);
    
        return redirect()->route('inventaris.index')->with('success', 'Data Inventaris berhasil ditambahkan.');
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        $anggota = Anggota::all(); // Ambil semua data anggota untuk dropdown
        return view('inventaris.edit', compact('inventaris', 'anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_inventaris' => 'required|max:20|unique:inventaris,id_inventaris,' . $id . ',id_inventaris',
            'id_anggota' => 'required|exists:anggota,id_anggota',
        ]);

        // Update data inventaris
        $inventaris = Inventaris::findOrFail($id);
        $inventaris->update([
            'id_inventaris' => $request->id_inventaris,
            'id_anggota' => $request->id_anggota,
        ]);

        return redirect()->route('inventaris.index')->with('success', 'Data Inventaris berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Hapus data inventaris
        $inventaris = Inventaris::findOrFail($id);
        $inventaris->delete();

        return redirect()->route('inventaris.index')->with('success', 'Data Inventaris berhasil dihapus.');
    }
}
