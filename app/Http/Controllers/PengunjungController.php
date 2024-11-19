<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengunjungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $pengunjung = Pengunjung::all();
            return view('pengunjung.index', compact('pengunjung'));
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
            return view('pengunjung.create');
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
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $request->validate([
                'nama_pengunjung' => 'required|string|max:255',
                'no_hp' => 'required|string|max:15|unique:pengunjung,no_hp',
            ]);

            Pengunjung::create($request->all());

            return redirect()->route('pengunjung.index')->with('success', 'Visitor added successfully.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $pengunjung = Pengunjung::findOrFail($id);
            return view('pengunjung.edit', compact('pengunjung'));
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
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $request->validate([
                'nama_pengunjung' => 'required|string|max:255',
                'no_hp' => 'required|string|max:15|unique:pengunjung,no_hp,' . $id . ',id_pengunjung',
            ]);

            $pengunjung = Pengunjung::findOrFail($id);
            $pengunjung->update($request->all());

            return redirect()->route('pengunjung.index')->with('success', 'Visitor updated successfully.');
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
            $pengunjung = Pengunjung::findOrFail($id);
            $pengunjung->delete();

            return redirect()->route('pengunjung.index')->with('success', 'Visitor deleted successfully.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }
}
