<?php

namespace App\Http\Controllers;

use App\Models\Bph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BphController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('anggota')->user();

        if ($user->role && ($user->role->name === 'super_user' || $user->role->name === 'admin')) {
            // Ambil semua data BPH
            $bph = Bph::all();
            return view('bph.index', compact('bph'));
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

        if ($user->role && ($user->role->name === 'super_user' || $user->role->name === 'admin')) {
            $request->validate([
                'id_bph' => 'required|string|max:2|unique:bph,id_bph',
                'nama_divisi_bph' => 'required|string|max:255',
            ]);

            Bph::create($request->only(['id_bph', 'nama_divisi_bph']));
            return redirect()->route('bph.index')->with('success', 'Data BPH berhasil ditambahkan.');
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
                'id_bph' => 'required|string|max:2',
                'nama_divisi_bph' => 'required|string|max:255',
            ]);

            $bph = Bph::findOrFail($id);
            $bph->update($request->only(['id_bph', 'nama_divisi_bph']));
            return redirect()->route('bph.index')->with('success', 'Data BPH berhasil diperbarui.');
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
            $bph = Bph::findOrFail($id);
            $bph->delete();
            return redirect()->route('bph.index')->with('success', 'Data BPH berhasil dihapus.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }
}
