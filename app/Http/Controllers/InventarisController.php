<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            try {
                // Ambil data inventaris beserta nama anggota terkait
                $inventaris = Inventaris::with('anggota')->get();
                return view('inventaris.index', compact('inventaris'));
            } catch (\Exception $e) {
                return redirect()->route('inventaris.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
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
            try {
                // Validasi input
                $request->validate([
                    'id_anggota' => 'required|exists:anggota,id_anggota',
                    'tahun_jabatan' => 'required|integer|min:1900|max:' . date('Y'),
                ]);

                // Generate ID Inventaris otomatis
                $lastInventaris = Inventaris::orderBy('id_anggota', 'desc')->first();
                $newIdNumber = $lastInventaris ? ((int) str_replace('INV-', '', $lastInventaris->id_inventaris)) + 1 : 1;
                $newIdInventaris = 'INV-' . str_pad($newIdNumber, 3, '0', STR_PAD_LEFT);

                // Simpan data inventaris baru
                $inventaris = new Inventaris();
                $inventaris->id_inventaris = $newIdInventaris;
                $inventaris->id_anggota = $request->id_anggota;
                $inventaris->tahun_jabatan = $request->tahun_jabatan;
                $inventaris->save();

                return redirect()->route('inventaris.index')->with('success', 'Data Inventaris berhasil ditambahkan.');
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Validasi gagal
                return redirect()->route('inventaris.index')->withErrors($e->validator)->withInput();
            } catch (\Exception $e) {
                // Error lain
                return redirect()->route('inventaris.index')->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
            }
        } else {
            abort(403, 'Akses Ditolak');
        }
    }


    public function update(Request $request, $id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            try {
                // Validasi input
                $request->validate([
                    'id_anggota' => [
                        'required',
                        'exists:anggota,id_anggota',
                        'regex:/^\d{9}$/', // Validasi panjang dan format ID Anggota (9 digit angka)
                    ],
                    'tahun_jabatan' => 'required|integer|min:1900|max:' . date('Y'),
                ]);

                // Cari data inventaris, jika tidak ditemukan, tangkap error
                $inventaris = Inventaris::findOrFail($id);

                // Update data inventaris
                $inventaris->update([
                    'id_anggota' => $request->id_anggota,
                    'tahun_jabatan' => $request->tahun_jabatan,
                ]);

                // Redirect dengan pesan sukses
                return redirect()->route('inventaris.index')->with('success', 'Data Inventaris berhasil diperbarui.');
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                // Jika data inventaris tidak ditemukan
                Log::error('Inventaris tidak ditemukan untuk ID: ' . $id);
                return redirect()->route('inventaris.index')->with('error', 'Data Inventaris tidak ditemukan.');
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Jika validasi gagal
                return redirect()->route('inventaris.index')->withErrors($e->validator)->withInput();
            } catch (\Exception $e) {
                // Penanganan error lainnya
                Log::error('Update Error:', ['error' => $e->getMessage()]);
                return redirect()->route('inventaris.index')->with('error', 'Terjadi kesalahan saat memperbarui data.');
            }
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
            try {
                // Cari data inventaris, jika tidak ditemukan, tangkap error
                $inventaris = Inventaris::findOrFail($id);

                // Hapus data inventaris
                $inventaris->delete();

                return redirect()->route('inventaris.index')->with('success', 'Data Inventaris berhasil dihapus.');
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                // Jika data tidak ditemukan
                return redirect()->route('inventaris.index')->with('error', 'Data Inventaris tidak ditemukan.');
            } catch (\Exception $e) {
                return redirect()->route('inventaris.index')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
            }
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    public function checkNim(Request $request)
    {
        $nim = $request->query('nim');
        $exists = Anggota::where('id_anggota', $nim)->exists();
        return response()->json(['exists' => $exists]);
    }
}
