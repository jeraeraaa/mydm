<?php

namespace App\Http\Controllers\BackendAlat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailPeminjamanAlat;
use App\Models\PersetujuanKetum;
use App\Models\KetuaUmum;

class PersetujuanKetumController extends Controller
{
    public function index()
    {
        $user = Auth::guard('anggota')->user();

        if ($user->role && $user->role->name === 'super_user') {
            // Ambil persetujuan dengan detail peminjaman
            $persetujuan = PersetujuanKetum::with(['detailPeminjaman'])
                ->where('status_persetujuan', 'menunggu')
                ->get()
                ->map(function ($item) {
                    // Loop melalui detail_peminjaman untuk menentukan peminjam
                    $item->nama_peminjam = null;
                    $item->identitas_peminjam = null;

                    if ($item->detailPeminjaman->isNotEmpty()) {
                        $detailPeminjaman = $item->detailPeminjaman->first();
                        $type = $detailPeminjaman->peminjamable_type;
                        $id = $detailPeminjaman->peminjamable_id;

                        if ($type === 'App\Models\Anggota') {
                            $anggota = \App\Models\Anggota::find($id);
                            $item->nama_peminjam = $anggota->nama_anggota ?? 'Tidak Diketahui';
                            $item->identitas_peminjam = $anggota->id_anggota ?? '-';
                        } elseif ($type === 'App\Models\PeminjamEksternal') {
                            $peminjamEksternal = \App\Models\PeminjamEksternal::find($id);
                            $item->nama_peminjam = $peminjamEksternal->nama ?? 'Tidak Diketahui';
                            $item->identitas_peminjam = $peminjamEksternal->organisasi ?? '-';
                        } else {
                            $item->nama_peminjam = 'Tidak Diketahui';
                            $item->identitas_peminjam = '-';
                        }
                    }

                    // Tambahkan jumlah item dan tanggal pinjam
                    $item->jumlah_item = $item->detailPeminjaman->count();
                    $item->tanggal_pinjam = $item->detailPeminjaman->first()->tanggal_pinjam ?? null;

                    return $item;
                });

            return view('backend-alat.persetujuan.index', compact('persetujuan'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }




    // Menampilkan detail peminjaman
    public function show($id)
    {
        $user = Auth::guard('anggota')->user();

        // Pastikan hanya Ketua Umum yang dapat mengakses
        if ($user->role && $user->role->name === 'super_user') {
            // Ambil data persetujuan berdasarkan ID
            $persetujuanKetum = PersetujuanKetum::with('detailPeminjaman')
                ->findOrFail($id);

            // Inisialisasi data peminjam
            $namaPeminjam = null;
            $identitasPeminjam = null;
            $fakultas = null;
            $jurusan = null;
            $organisasi = null;

            if ($persetujuanKetum->detailPeminjaman->isNotEmpty()) {
                $detailPeminjaman = $persetujuanKetum->detailPeminjaman->first(); // Ambil salah satu detail

                $type = $detailPeminjaman->peminjamable_type;
                $peminjamId = $detailPeminjaman->peminjamable_id;

                if ($type === 'App\Models\Anggota') {
                    // Jika peminjam adalah anggota internal
                    $anggota = \App\Models\Anggota::find($peminjamId);
                    $namaPeminjam = $anggota->nama_anggota ?? 'Tidak Diketahui';
                    $identitasPeminjam = $anggota->id_anggota ?? '-';
                    $fakultas = $anggota->prodi->fakultas->nama_fakultas ?? 'Fakultas Tidak Diketahui';
                    $jurusan = $anggota->prodi->nama_prodi ?? 'Jurusan Tidak Diketahui';
                    $organisasi = 'Internal Dharmayana';
                } elseif ($type === 'App\Models\PeminjamEksternal') {
                    // Jika peminjam adalah peminjam eksternal
                    $peminjamEksternal = \App\Models\PeminjamEksternal::find($peminjamId);
                    $namaPeminjam = $peminjamEksternal->nama ?? 'Tidak Diketahui';
                    $identitasPeminjam = '-';
                    $fakultas = '-';
                    $jurusan = '-';
                    $organisasi = $peminjamEksternal->organisasi ?? '-';
                }
            }

            // Ambil semua detail peminjaman
            $detailPeminjaman = $persetujuanKetum->detailPeminjaman->map(function ($detail) {
                return [
                    'nama_alat' => $detail->alat->nama_alat ?? 'Tidak Diketahui',
                    'jumlah_dipinjam' => $detail->jumlah_dipinjam,
                    'kondisi_alat_dipinjam' => $detail->kondisi_alat_dipinjam,
                    'tanggal_pinjam' => $detail->tanggal_pinjam,
                    'tanggal_kembali' => $detail->tanggal_kembali ?? 'Belum Dikembalikan',
                ];
            });

            return view('backend-alat.persetujuan.show', compact(
                'persetujuanKetum',
                'namaPeminjam',
                'identitasPeminjam',
                'fakultas',
                'jurusan',
                'organisasi',
                'detailPeminjaman'
            ));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    public function approve($id)
    {
        // Ambil data pengguna yang login
        $user = Auth::guard('anggota')->user();

        // Pastikan user adalah Ketua Umum dengan validasi di tabel `ketua_umum`
        $ketuaUmum = KetuaUmum::where('id_anggota', $user->id_anggota)->first();

        if (!$ketuaUmum) {
            return redirect()->back()->withErrors(['error' => 'Pengguna ini bukan Ketua Umum yang valid.']);
        }

        // Cari data persetujuan berdasarkan ID
        $persetujuan = PersetujuanKetum::findOrFail($id);

        // Perbarui data persetujuan
        $persetujuan->update([
            'id_ketum' => $ketuaUmum->id_ketum, // Masukkan ID Ketua Umum dari tabel `ketua_umum`
            'status_persetujuan' => 'disetujui',
            'updated_at' => now(),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('persetujuan.index')->with('success', 'Peminjaman telah disetujui.');
    }

    public function reject(Request $request, $id)
    {
        // Ambil data pengguna yang login
        $user = Auth::guard('anggota')->user();

        // Periksa apakah user adalah Ketua Umum
        $ketuaUmum = KetuaUmum::where('id_anggota', $user->id_anggota)->first();

        if (!$ketuaUmum) {
            return redirect()->back()->withErrors(['error' => 'Pengguna ini bukan Ketua Umum yang valid.']);
        }

        // Cari data persetujuan berdasarkan ID
        $persetujuan = PersetujuanKetum::findOrFail($id);

        // Perbarui data persetujuan
        $persetujuan->update([
            'id_ketum' => $ketuaUmum->id_ketum, // Masukkan ID Ketua Umum dari tabel `ketua_umum`
            'status_persetujuan' => 'ditolak', // Ubah status menjadi 'ditolak'
            'catatan' => $request->input('alasan'), // Masukkan alasan penolakan ke kolom `catatan`
            'updated_at' => now(),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('persetujuan.index')->with('success', 'Peminjaman telah ditolak.');
    }
}
