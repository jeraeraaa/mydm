<?php

namespace App\Http\Controllers;

use App\Models\DetailKegiatan;
use App\Models\Pengunjung;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class FrontendKegiatanController extends Controller
{

    public function index()
    {
        // Ambil tanggal hari ini untuk perbandingan
        $tanggalHariIni = now()->toDateString();

        // Kegiatan yang sedang berlangsung hari ini
        $kegiatanHariIni = DetailKegiatan::with(['kegiatan', 'bph'])
            ->whereDate('tanggal_mulai', '<=', $tanggalHariIni) // Sudah dimulai
            ->whereDate('tanggal_selesai', '>=', $tanggalHariIni) // Masih berlangsung
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        // Kegiatan yang akan datang
        $kegiatanMendatang = DetailKegiatan::with(['kegiatan', 'bph'])
            ->whereDate('tanggal_mulai', '>', $tanggalHariIni) // Belum dimulai
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        // Kegiatan yang telah selesai
        $kegiatanSelesai = DetailKegiatan::with(['kegiatan', 'bph'])
            ->whereDate('tanggal_selesai', '<', $tanggalHariIni) // Sudah selesai
            ->orderBy('tanggal_selesai', 'desc')
            ->get();

        // Debugging (opsional)
        // Log::info('Kegiatan Hari Ini:', $kegiatanHariIni->toArray());
        // Log::info('Kegiatan Mendatang:', $kegiatanMendatang->toArray());
        // Log::info('Kegiatan Selesai:', $kegiatanSelesai->toArray());

        return view('frontend-kegiatan.index', compact('kegiatanHariIni', 'kegiatanMendatang', 'kegiatanSelesai'));
    }


    public function show($id)
    {
        $detailKegiatan = DetailKegiatan::with(['kegiatan', 'materi.pembicara'])
            ->findOrFail($id);

        return view('frontend-kegiatan.show', compact('detailKegiatan'));
    }

    public function formAbsensi($id)
    {
        $detailKegiatan = DetailKegiatan::findOrFail($id);

        return view('frontend-kegiatan.absensi', compact('detailKegiatan'));
    }

    public function storeAbsensi(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'status_absen' => 'required|in:anggota,pengunjung',
            'id_anggota' => 'nullable|required_if:status_absen,anggota|exists:anggota,id_anggota',
            'nama_pengunjung' => 'nullable|required_if:status_absen,pengunjung|string|max:255',
            'no_hp' => 'nullable|required_if:status_absen,pengunjung|string|max:15',
        ]);

        // Proses absensi berdasarkan status_absen
        if ($validated['status_absen'] === 'anggota') {
            // Cek apakah anggota sudah terdaftar pada absensi kegiatan ini
            $alreadyExists = Absensi::where('id_anggota', $validated['id_anggota'])
                ->where('id_detail_kegiatan', $id)
                ->exists();

            if ($alreadyExists) {
                return redirect()->back()->withErrors(['error' => 'Anggota sudah terdaftar pada absensi ini.']);
            }

            // Simpan absensi anggota
            Absensi::create([
                'id_anggota' => $validated['id_anggota'],
                'id_detail_kegiatan' => $id,
                'waktu_masuk' => now(),
            ]);
        } elseif ($validated['status_absen'] === 'pengunjung') {
            // Cari pengunjung berdasarkan nomor HP
            $pengunjung = Pengunjung::where('no_hp', $validated['no_hp'])->first();

            if (!$pengunjung) {
                // Jika pengunjung belum ada, buat data baru
                $pengunjung = Pengunjung::create([
                    'nama_pengunjung' => $validated['nama_pengunjung'],
                    'no_hp' => $validated['no_hp'],
                ]);
            }

            // Cek apakah pengunjung sudah terdaftar pada absensi kegiatan ini
            $alreadyExists = Absensi::where('id_pengunjung', $pengunjung->id_pengunjung)
                ->where('id_detail_kegiatan', $id)
                ->exists();

            if ($alreadyExists) {
                return redirect()->back()->withErrors(['error' => 'Pengunjung sudah terdaftar pada absensi ini.']);
            }

            // Simpan absensi pengunjung
            Absensi::create([
                'id_pengunjung' => $pengunjung->id_pengunjung,
                'id_detail_kegiatan' => $id,
                'waktu_masuk' => now(),
            ]);
        }

        // Redirect ke halaman konfirmasi dengan pesan sukses
        return redirect()->route('frontend-kegiatan.absensiConfirmation')->with('success', 'Absensi berhasil disimpan!');
    }


    public function absensiConfirmation()
    {
        return view('frontend-kegiatan.confirmation');
    }
}
