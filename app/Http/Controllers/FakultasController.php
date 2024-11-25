<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('anggota')->user();

        if ($user->role && ($user->role->name === 'super_user')) {
            // Ambil semua data Fakultas
            $fakultas = Fakultas::all();
            return view('fakultas.index', compact('fakultas'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::guard('anggota')->user();

        if ($user->role && ($user->role->name === 'super_user')) {
            $request->validate([
                'nama_fakultas' => 'required|string|max:255|unique:fakultas,nama_fakultas',
            ]);

            Fakultas::create($request->only(['nama_fakultas']));
            return redirect()->route('fakultas.index')->with('success', 'Data Fakultas berhasil ditambahkan.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::guard('anggota')->user();

        if ($user->role && ($user->role->name === 'super_user')) {
            $request->validate([
                'nama_fakultas' => 'required|string|max:255|unique:fakultas,nama_fakultas,' . $id . ',id_fakultas',
            ]);

            $fakultas = Fakultas::findOrFail($id);
            $fakultas->update($request->only(['nama_fakultas']));
            return redirect()->route('fakultas.index')->with('success', 'Data Fakultas berhasil diperbarui.');
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

        if ($user->role && ($user->role->name === 'super_user')) {
            $fakultas = Fakultas::findOrFail($id);
            $fakultas->delete();
            return redirect()->route('fakultas.index')->with('success', 'Data Fakultas berhasil dihapus.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }
}
