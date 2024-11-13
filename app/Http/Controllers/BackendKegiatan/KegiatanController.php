<?php

namespace App\Http\Controllers\BackendKegiatan;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\KategoriKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Mengambil semua kategori untuk opsi filter di dropdown
            $kategoriList = KategoriKegiatan::all();

            // Mengambil nilai filter kategori dari request
            $kategoriFilter = $request->input('kategori_filter');

            // Query untuk mendapatkan kegiatan dengan relasi detail_kegiatan dan kategoriKegiatan
            $kegiatanQuery = Kegiatan::with(['detail_kegiatan', 'kategoriKegiatan']);

            // Jika filter kategori dipilih, tambahkan kondisi where
            if ($kategoriFilter) {
                $kegiatanQuery->where('id_kategori_kegiatan', $kategoriFilter);
            }

            // Eksekusi query untuk mendapatkan hasil
            $kegiatan = $kegiatanQuery->get();

            // Mengirim data kegiatan, kategoriList, dan kategoriFilter ke view
            return view('backend-kegiatan.kegiatan.index', compact('kegiatan', 'kategoriList', 'kategoriFilter'));
        } catch (\Exception $e) {
            // Logging jika terjadi kesalahan
            Log::error("Gagal menampilkan daftar kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menampilkan daftar kegiatan.']);
        }
    }



    // Menyimpan kegiatan baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'id_kategori_kegiatan' => 'required|exists:kategori_kegiatan,id_kategori_kegiatan',
            'deskripsi_kegiatan' => 'nullable|string',
        ]);

        try {
            // Simpan data kegiatan
            Kegiatan::create([
                'nama_kegiatan' => $request->nama_kegiatan,
                'id_kategori_kegiatan' => $request->id_kategori_kegiatan,
                'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            ]);

            Log::info("Kegiatan berhasil ditambahkan: " . $request->nama_kegiatan);
            return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Logging jika terjadi kesalahan
            Log::error("Gagal menambahkan kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menambahkan kegiatan.'])->withInput();
        }
    }

    // Menampilkan form edit kegiatan
    public function edit($id)
    {
        try {
            $kegiatan = Kegiatan::with('kategoriKegiatan')->findOrFail($id);
            $kategori = KategoriKegiatan::all(); // Kategori untuk dropdown pada form edit

            return view('backend-kegiatan.kegiatan.edit', compact('kegiatan', 'kategori'));
        } catch (\Exception $e) {
            Log::error("Gagal menampilkan form edit kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menampilkan form edit kegiatan.']);
        }
    }

    // Memperbarui kegiatan yang sudah ada
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'id_kategori_kegiatan' => 'required|exists:kategori_kegiatan,id_kategori_kegiatan',
            'deskripsi_kegiatan' => 'nullable|string',
        ]);

        try {
            // Temukan kegiatan dan perbarui
            $kegiatan = Kegiatan::findOrFail($id);
            $kegiatan->update([
                'nama_kegiatan' => $request->nama_kegiatan,
                'id_kategori_kegiatan' => $request->id_kategori_kegiatan,
                'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            ]);

            Log::info("Kegiatan ID {$id} berhasil diperbarui.");
            return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Gagal memperbarui kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal memperbarui kegiatan.'])->withInput();
        }
    }

    // Menghapus kegiatan
    public function destroy($id)
    {
        try {
            $kegiatan = Kegiatan::findOrFail($id);
            $kegiatan->delete();

            Log::info("Kegiatan ID {$id} berhasil dihapus.");
            return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus kegiatan.']);
        }
    }
}
