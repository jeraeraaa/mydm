<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\KategoriKegiatan;
use App\Models\DetailKegiatan;
use App\Models\Bph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class KegiatanController extends Controller
{
    // Menampilkan daftar kegiatan
    public function index()
    {
        $kegiatan = Kegiatan::with(['kategori', 'detail_kegiatan.bph'])->get();
        $kategori = KategoriKegiatan::all();
        $bph = Bph::all();
        return view('kegiatan.index', compact('kegiatan', 'kategori', 'bph'));
    }

    public function store(Request $request)
    {
        Log::info("Log test - memulai fungsi store di KegiatanController");

        // Validasi input tanpa aturan after di waktu_selesai
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'id_kategori_kegiatan' => 'required|exists:kategori_kegiatan,id_kategori_kegiatan',
            'tanggal_mulai' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_selesai' => 'required|date_format:H:i',
            'lokasi' => 'required|string|max:255',
            'id_bph' => 'nullable|exists:bph,id_bph',
            'deskripsi_kegiatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Logika tambahan untuk memvalidasi waktu_selesai setelah waktu_mulai
        if ($request->tanggal_mulai === $request->tanggal_selesai && $request->waktu_selesai <= $request->waktu_mulai) {
            return back()->withErrors(['waktu_selesai' => 'Waktu selesai harus lebih lambat dari waktu mulai pada tanggal yang sama.'])->withInput();
        }

        // Selanjutnya proses penyimpanan data seperti biasa
        try {
            DB::transaction(function () use ($request) {
                Log::info("Memulai penyimpanan kegiatan...");

                // Simpan data kegiatan utama
                $kegiatan = Kegiatan::create([
                    'id_kategori_kegiatan' => $request->id_kategori_kegiatan,
                    'nama_kegiatan' => $request->nama_kegiatan,
                    'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
                ]);

                Log::info("Kegiatan berhasil disimpan: ID - " . $kegiatan->id_kegiatan);

                // Proses penyimpanan foto jika ada
                $fotoFileName = null;
                if ($request->hasFile('foto')) {
                    $file = $request->file('foto');
                    $path = $file->store('foto_kegiatan', 'public');
                    $fotoFileName = basename($path); // Menyimpan hanya nama file
                    Log::info("Foto berhasil diunggah: " . $fotoFileName);
                }

                // Simpan detail kegiatan termasuk foto jika ada
                $kegiatan->detail_kegiatan()->create([
                    'id_bph' => $request->id_bph,
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'waktu_mulai' => $request->waktu_mulai,
                    'tanggal_selesai' => $request->tanggal_selesai,
                    'waktu_selesai' => $request->waktu_selesai,
                    'lokasi' => $request->lokasi,
                    'foto' => $fotoFileName,
                ]);

                Log::info("Detail kegiatan berhasil disimpan untuk kegiatan ID: " . $kegiatan->id_kegiatan);
            });

            return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error("Gagal menambahkan kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menambahkan kegiatan: ' . $e->getMessage()])->withInput();
        }
    }


    // Menampilkan form edit kegiatan
    public function edit($id)
    {
        Log::info("Memulai fungsi edit kegiatan dengan ID: {$id}");

        $kegiatan = Kegiatan::with('detail_kegiatan')->findOrFail($id);
        $kategori = KategoriKegiatan::all();
        $bph = Bph::all();
        return view('kegiatan.edit', compact('kegiatan', 'kategori', 'bph'));
    }

    // Memperbarui data kegiatan
    public function update(Request $request, $id)
    {
        Log::info("Memulai fungsi update kegiatan dengan ID: {$id}");

        $kegiatan = Kegiatan::with('detail_kegiatan')->findOrFail($id);

        // Konversi waktu agar sesuai dengan format H:i
        $request->merge([
            'waktu_mulai' => Carbon::parse($request->waktu_mulai)->format('H:i'),
            'waktu_selesai' => Carbon::parse($request->waktu_selesai)->format('H:i'),
        ]);

        // Validasi input tanpa menggunakan aturan `after` pada waktu
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'id_kategori_kegiatan' => 'required|exists:kategori_kegiatan,id_kategori_kegiatan',
            'tanggal_mulai' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_selesai' => 'required|date_format:H:i',
            'lokasi' => 'required|string|max:255',
            'id_bph' => 'nullable|exists:bph,id_bph',
            'deskripsi_kegiatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto
        ]);

        // Validasi tambahan untuk memastikan `waktu_selesai` lebih lambat dari `waktu_mulai` pada tanggal yang sama
        if ($request->tanggal_mulai === $request->tanggal_selesai && $request->waktu_selesai <= $request->waktu_mulai) {
            return back()->withErrors(['waktu_selesai' => 'Waktu selesai harus lebih lambat dari waktu mulai pada tanggal yang sama.'])->withInput();
        }

        try {
            DB::transaction(function () use ($request, $kegiatan) {
                Log::info("Memulai pembaruan kegiatan utama ID: {$kegiatan->id_kegiatan}");

                // Update kegiatan utama
                $kegiatan->update([
                    'id_kategori_kegiatan' => $request->id_kategori_kegiatan,
                    'nama_kegiatan' => $request->nama_kegiatan,
                    'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
                ]);

                // Proses penyimpanan foto jika ada
                $fotoFileName = $kegiatan->detail_kegiatan->foto ?? null;
                if ($request->hasFile('foto')) {
                    // Hapus foto lama jika ada
                    if ($fotoFileName && file_exists(storage_path('app/public/foto_kegiatan/' . $fotoFileName))) {
                        unlink(storage_path('app/public/foto_kegiatan/' . $fotoFileName));
                    }

                    // Simpan foto baru
                    $file = $request->file('foto');
                    $path = $file->store('foto_kegiatan', 'public');
                    $fotoFileName = basename($path); // Menyimpan hanya nama file
                    Log::info("Foto berhasil diunggah: " . $fotoFileName);
                }

                // Update atau buat detail kegiatan dengan foto baru jika ada
                $kegiatan->detail_kegiatan()->updateOrCreate(
                    ['id_kegiatan' => $kegiatan->id_kegiatan],
                    [
                        'id_bph' => $request->id_bph,
                        'tanggal_mulai' => $request->tanggal_mulai,
                        'waktu_mulai' => $request->waktu_mulai,
                        'tanggal_selesai' => $request->tanggal_selesai,
                        'waktu_selesai' => $request->waktu_selesai,
                        'lokasi' => $request->lokasi,
                        'foto' => $fotoFileName, // Simpan nama file ke database
                    ]
                );

                Log::info("Detail kegiatan berhasil diperbarui atau dibuat untuk kegiatan ID: {$kegiatan->id_kegiatan}");
            });

            return redirect()->route('kegiatan.index')->with('success', 'Data kegiatan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Gagal memperbarui kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal memperbarui kegiatan: ' . $e->getMessage()])->withInput();
        }
    }








    // Menghapus data kegiatan
    public function destroy($id)
    {
        $kegiatan = Kegiatan::find($id);

        if (!$kegiatan) {
            return back()->withErrors(['error' => 'Kegiatan tidak ditemukan.']);
        }

        try {
            $kegiatan->delete();
            Log::info("Kegiatan ID {$id} berhasil dihapus.");
            return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus kegiatan: ' . $e->getMessage()]);
        }
    }
}
