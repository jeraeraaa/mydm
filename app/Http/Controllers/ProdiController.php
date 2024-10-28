<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Fakultas;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::with('fakultas')->get();
        return view('prodi.index', compact('prodis'));
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        return view('prodi.create', compact('fakultas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_fakultas' => 'required|exists:fakultas,id_fakultas',
            'nama_prodi' => 'required|string|max:255',
        ]);

        Prodi::create($request->all());
        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil ditambahkan.');
    }

    // Metode lain seperti edit, update, dan destroy bisa ditambahkan sesuai kebutuhan
}
