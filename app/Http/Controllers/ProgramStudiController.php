<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use App\Models\Fakultas;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan nama program studi
        $query = ProgramStudi::with('fakultas'); // Include fakultas relasi untuk menghindari query tambahan
        if ($request->has('nama_prodi') && $request->nama_prodi) {
            $query->where('nama_prodi', 'like', '%' . $request->nama_prodi . '%');
        }

        // Ambil data program studi dan fakultas
        $programStudiList = $query->get();
        $fakultasList = Fakultas::all(); // Untuk modal tambah

        return view('program-studi.index', compact('programStudiList', 'fakultasList'));
    }


    public function create()
    {
        return view('program-studi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prodi' => 'required|string|max:3|unique:program_studi,id_prodi',
            'id_fakultas' => 'required|exists:fakultas,id_fakultas',
            'nama_prodi' => 'required|string|max:255',
        ]);

        ProgramStudi::create($request->all());

        return redirect()->route('program-studi.index')->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $programStudi = ProgramStudi::findOrFail($id);
        $fakultasList = Fakultas::all();

        return view('program-studi.edit', compact('programStudi', 'fakultasList'));
    }

    public function update(Request $request, $id)
    {
        $programStudi = ProgramStudi::findOrFail($id);

        $request->validate([
            'id_fakultas' => 'required|exists:fakultas,id_fakultas',
            'nama_prodi' => 'required|string|max:255',
        ]);

        $programStudi->update($request->all());

        return redirect()->route('program-studi.index')->with('success', 'Program Studi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $programStudi = ProgramStudi::findOrFail($id);
        $programStudi->delete();

        return redirect()->route('program-studi.index')->with('success', 'Program Studi berhasil dihapus.');
    }
}
