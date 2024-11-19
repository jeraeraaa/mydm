<?php

namespace App\Http\Controllers\BackendKegiatan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\DetailKegiatan;
use App\Models\Anggota;
use App\Models\Pengunjung;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;


class AbsensiController extends Controller
{
    /**
     * Tampilkan halaman index absensi dengan daftar kegiatan.
     */
    public function index()
    { // Ambil data pengguna yang login
        $user = Auth::guard('anggota')->user();

        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $details = DetailKegiatan::all();
            return view('backend-kegiatan.absensi.index', compact('details'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    // halaman detail absensi
    public function show($id_detail_kegiatan)
    {
        $user = Auth::guard('anggota')->user();

        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $detail = DetailKegiatan::findOrFail($id_detail_kegiatan);
            $absensi = Absensi::where('id_detail_kegiatan', $id_detail_kegiatan)->with(['anggota', 'pengunjung'])->get();

            // Tambahkan definisi QR Code URL
            $qrCodeUrl = route('frontend-kegiatan.formAbsensi', ['id' => $id_detail_kegiatan]);

            return view('backend-kegiatan.absensi.show', compact('detail', 'absensi', 'qrCodeUrl'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }




    /**
     * Simpan absensi baru.
     */
    public function store(Request $request)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            // Validasi input
            $validated = $request->validate([
                'id_detail_kegiatan' => 'required|exists:detail_kegiatan,id_detail_kegiatan',
                'id_anggota' => 'nullable|exists:anggota,id_anggota',
                'nama_pengunjung' => 'nullable|required_without:id_anggota|string|max:255',
                'no_hp' => 'nullable|required_without:id_anggota|string|max:15',
            ]);

            // Cek jika anggota hadir, maka tidak boleh ada input untuk pengunjung
            if ($validated['id_anggota'] && ($validated['nama_pengunjung'] || $validated['no_hp'])) {
                return redirect()->back()->withErrors(['error' => 'Anggota tidak boleh mengisi nama pengunjung atau nomor HP.']);
            }

            // Proses absensi anggota
            if ($validated['id_anggota']) {
                // Cek apakah anggota sudah absen untuk kegiatan ini
                $alreadyExists = Absensi::where('id_anggota', $validated['id_anggota'])
                    ->where('id_detail_kegiatan', $validated['id_detail_kegiatan'])
                    ->exists();

                if ($alreadyExists) {
                    return redirect()->back()->withErrors(['error' => 'Anggota sudah terdaftar pada absensi ini.']);
                }

                Absensi::create([
                    'id_anggota' => $validated['id_anggota'],
                    'id_detail_kegiatan' => $validated['id_detail_kegiatan'],
                    'waktu_masuk' => now(),
                ]);
            }

            // Proses absensi pengunjung
            if ($validated['no_hp']) {
                // Cari pengunjung berdasarkan nomor HP
                $pengunjung = Pengunjung::where('no_hp', $validated['no_hp'])->first();

                if ($pengunjung) {
                    // Jika pengunjung sudah ada, gunakan data yang ada
                    $pengunjungId = $pengunjung->id_pengunjung;
                } else {
                    // Jika pengunjung belum ada, buat data baru
                    $pengunjung = Pengunjung::create([
                        'nama_pengunjung' => $validated['nama_pengunjung'],
                        'no_hp' => $validated['no_hp'],
                    ]);
                    $pengunjungId = $pengunjung->id_pengunjung;
                }

                // Cek apakah pengunjung sudah absen untuk kegiatan ini
                $alreadyExists = Absensi::where('id_pengunjung', $pengunjungId)
                    ->where('id_detail_kegiatan', $validated['id_detail_kegiatan'])
                    ->exists();

                if ($alreadyExists) {
                    return redirect()->back()->withErrors(['error' => 'Pengunjung sudah terdaftar pada absensi ini.']);
                }

                Absensi::create([
                    'id_pengunjung' => $pengunjungId,
                    'id_detail_kegiatan' => $validated['id_detail_kegiatan'],
                    'waktu_masuk' => now(),
                ]);
            }

            return redirect()->back()->with('success', 'Absensi berhasil disimpan!');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }



    /**
     * Tampilkan halaman edit absensi.
     */
    public function edit($id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $absensi = Absensi::findOrFail($id);
            $detailKegiatan = DetailKegiatan::all();
            $anggota = Anggota::all();
            return view('backend-kegiatan.absensi.edit', compact('absensi', 'detailKegiatan', 'anggota'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    /**
     * Update data absensi.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $validated = $request->validate([
                'id_detail_kegiatan' => 'required|exists:detail_kegiatan,id_detail_kegiatan',
                'id_anggota' => 'nullable|exists:anggota,id_anggota',
                'id_pengunjung' => 'nullable|exists:pengunjung,id_pengunjung',
                'waktu_masuk' => 'required|date',
                'waktu_keluar' => 'nullable|date|after_or_equal:waktu_masuk',
            ]);

            $absensi = Absensi::findOrFail($id);
            $absensi->update($validated);

            return redirect()->route('absensi.show', $validated['id_detail_kegiatan'])->with('success', 'Absensi berhasil diperbarui!');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    /**
     * Hapus data absensi.
     */
    public function destroy($id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $absensi = Absensi::findOrFail($id);
            $absensi->delete();

            return redirect()->route('absensi.show', $absensi->id_detail_kegiatan)->with('success', 'Absensi berhasil dihapus!');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }
}
