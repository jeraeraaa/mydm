<?php

namespace App\Http\Controllers\BackendKegiatan;

use App\Http\Controllers\Controller;
use App\Models\KategoriKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class KategoriKegiatanController extends Controller
{
    // Menampilkan daftar kategori kegiatan

    public function index()
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $kategori = KategoriKegiatan::all();
            return view('backend-kegiatan.kategori-kegiatan.index', compact('kategori'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    // Menampilkan form untuk membuat kategori baru
    public function create()
    {
        return view('backend-kegiatan.kategori-kegiatan.create');
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        try {
            KategoriKegiatan::create([
                'nama_kategori' => $request->nama_kategori,
            ]);

            Log::info("Kategori kegiatan berhasil ditambahkan: " . $request->nama_kategori);

            return redirect()->route('kategori-kegiatan.index')->with('success', 'Kategori kegiatan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error("Gagal menambahkan kategori kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menambahkan kategori kegiatan.'])->withInput();
        }
    }

    // Menampilkan form untuk mengedit kategori
    public function edit($id)
    {
        $kategori = KategoriKegiatan::findOrFail($id);
        return view('backend-kegiatan.kategori-kegiatan.edit', compact('kategori'));
    }

    // Memperbarui kategori yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        try {
            $kategori = KategoriKegiatan::findOrFail($id);
            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
            ]);

            Log::info("Kategori kegiatan ID {$id} berhasil diperbarui.");

            return redirect()->route('kategori-kegiatan.index')->with('success', 'Kategori kegiatan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Gagal memperbarui kategori kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal memperbarui kategori kegiatan.'])->withInput();
        }
    }

    // Menghapus kategori
    public function destroy($id)
    {
        try {
            $kategori = KategoriKegiatan::findOrFail($id);
            $kategori->delete();

            Log::info("Kategori kegiatan ID {$id} berhasil dihapus.");

            return redirect()->route('kategori-kegiatan.index')->with('success', 'Kategori kegiatan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus kategori kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus kategori kegiatan.']);
        }
    }
}
