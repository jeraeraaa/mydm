<?php

namespace App\Http\Controllers;

use App\Models\PeminjamEksternal;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamEksternalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $peminjamEksternal = PeminjamEksternal::with('program_studi')->get();
            $programStudi = ProgramStudi::all();
            return view('peminjam-eksternal.index', compact('peminjamEksternal', 'programStudi'));
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
                'id_peminjam_eksternal' => 'required|string|max:10|unique:peminjam_eksternal',
                'nama' => 'required|string|max:255',
                'organisasi' => 'required|string|max:255',
            ]);

            // Ambil 3 digit pertama dari id_peminjam_eksternal
            $id_prodi = substr($request->id_peminjam_eksternal, 0, 3);

            // Pastikan id_prodi yang diambil dari id_peminjam_eksternal valid
            if (!ProgramStudi::where('id_prodi', $id_prodi)->exists()) {
                return redirect()->back()->withErrors(['id_peminjam_eksternal' => 'Invalid program ID derived from the NIM.']);
            }

            // Simpan data ke database
            PeminjamEksternal::create([
                'id_peminjam_eksternal' => $request->id_peminjam_eksternal,
                'id_prodi' => $id_prodi,
                'nama' => $request->nama,
                'organisasi' => $request->organisasi,
            ]);

            return redirect()->route('peminjam-eksternal.index')->with('success', 'Borrower added successfully.');
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
            $borrower = PeminjamEksternal::findOrFail($id);
            $programStudi = ProgramStudi::all();
            return view('peminjam-eksternal.edit', compact('borrower', 'programStudi'));
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
                'nama' => 'required|string|max:255',
                'organisasi' => 'required|string|max:255',
            ]);

            $borrower = PeminjamEksternal::findOrFail($id);

            // Ambil 3 digit pertama dari id_peminjam_eksternal untuk menentukan id_prodi
            $id_prodi = substr($borrower->id_peminjam_eksternal, 0, 3);

            // Validasi apakah id_prodi valid
            if (!ProgramStudi::where('id_prodi', $id_prodi)->exists()) {
                return redirect()->back()->withErrors(['id_peminjam_eksternal' => 'Invalid program ID derived from the NIM.']);
            }

            // Update data borrower
            $borrower->update([
                'nama' => $request->nama,
                'organisasi' => $request->organisasi,
                'id_prodi' => $id_prodi,
            ]);

            return redirect()->route('peminjam-eksternal.index')->with('success', 'Borrower updated successfully.');
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
            $borrower = PeminjamEksternal::findOrFail($id);
            $borrower->delete();

            return redirect()->route('peminjam-eksternal.index')->with('success', 'Borrower deleted successfully.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }
}
