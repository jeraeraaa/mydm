<?php

namespace App\Http\Controllers\BackendAlat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailPeminjamanAlat;
use App\Models\Alat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\PersetujuanKetum;
use App\Models\KetuaUmum;

class StatusController extends Controller
{
    /**
     * Menampilkan daftar status peminjaman alat.
     */
    public function index(Request $request)
    {
        // Ambil nilai filter dari query string
        $filterStatus = $request->get('filter_status');

        // Ambil data alat dengan relasi terkait
        $statusPeminjaman = DetailPeminjamanAlat::with(['alat', 'persetujuanKetum', 'peminjamable'])
            ->when($filterStatus, function ($query, $filterStatus) {
                // Tambahkan filter berdasarkan status
                $query->where(function ($q) use ($filterStatus) {
                    if ($filterStatus === 'dikembalikan') {
                        $q->where('is_returned', true);
                    } elseif ($filterStatus === 'menunggu persetujuan') {
                        $q->whereHas('persetujuanKetum', function ($q) {
                            $q->where('status_persetujuan', 'menunggu');
                        });
                    } elseif ($filterStatus === 'dipinjam') {
                        $q->whereHas('persetujuanKetum', function ($q) {
                            $q->where('status_persetujuan', 'disetujui');
                        })->where('is_returned', false);
                    } elseif ($filterStatus === 'ditolak') {
                        $q->whereHas('persetujuanKetum', function ($q) {
                            $q->where('status_persetujuan', 'ditolak');
                        });
                    }
                });
            })
            ->orderBy('id_grup_peminjaman', 'asc') // Urutkan berdasarkan ID Grup Peminjaman
            ->get()
            ->groupBy('id_grup_peminjaman') // Kelompokkan berdasarkan ID Grup Peminjaman
            ->map(function ($details, $grupId) {
                $firstDetail = $details->first(); // Ambil elemen pertama dari grup peminjaman

                // Ambil nama peminjam dari polymorphic relation
                $peminjam = null;
                if ($firstDetail->peminjamable) {
                    if (get_class($firstDetail->peminjamable) === 'App\\Models\\Anggota') {
                        $peminjam = $firstDetail->peminjamable->nama_anggota;
                    } elseif (get_class($firstDetail->peminjamable) === 'App\\Models\\PeminjamEksternal') {
                        $peminjam = $firstDetail->peminjamable->nama;
                    }
                }

                return [
                    'id_grup_peminjaman' => $grupId,
                    'nama_peminjam' => $peminjam ?? 'Tidak Diketahui',
                    'status_peminjaman' => $firstDetail->status_peminjaman, // Menggunakan accessor
                    'tanggal_pinjam' => $firstDetail->tanggal_pinjam,
                    'tanggal_kembali' => $firstDetail->tanggal_kembali ?? '-',
                ];
            });

        return view('backend-alat.status-peminjaman.index', compact('statusPeminjaman', 'filterStatus'));
    }



    /**
     * Menampilkan detail alat berdasarkan ID grup peminjaman.
     */
    public function show($id)
    {
        // Ambil semua detail peminjaman dalam grup yang sama
        $detailPeminjaman = DetailPeminjamanAlat::with(['alat', 'peminjamable', 'persetujuanKetum'])
            ->where('id_grup_peminjaman', $id)
            ->get();

        // Cek apakah data peminjaman ditemukan
        if ($detailPeminjaman->isEmpty()) {
            return redirect()->route('status-peminjaman.index')
                ->withErrors(['error' => 'Data peminjaman tidak ditemukan.']);
        }

        // Ambil status peminjaman dari elemen pertama
        $statusPeminjaman = $detailPeminjaman->first()->status_peminjaman ?? null;

        // Debug: Pastikan status peminjaman valid
        if (is_null($statusPeminjaman)) {
            return redirect()->route('status-peminjaman.index')
                ->withErrors(['error' => 'Status peminjaman tidak valid.']);
        }

        // Ambil data peminjam (polymorphic)
        $peminjam = $detailPeminjaman->first()->peminjamable;
        $namaPeminjam = 'Tidak Diketahui';
        $nim = null;
        $fakultas = null;
        $jurusan = null;
        $organisasi = null;

        if ($peminjam) {
            if ($peminjam instanceof \App\Models\Anggota) {
                $namaPeminjam = $peminjam->nama_anggota;
                $nim = $peminjam->id_anggota;
                $programStudi = $peminjam->prodi;
                $jurusan = $programStudi->nama_prodi ?? 'Tidak Berlaku';
                $fakultas = $programStudi->fakultas->nama_fakultas ?? 'Tidak Berlaku';
                $organisasi = 'Internal Dharmayana';
            } elseif ($peminjam instanceof \App\Models\PeminjamEksternal) {
                $namaPeminjam = $peminjam->nama;
                $nim = $peminjam->id_peminjam_eksternal;
                $programStudi = $peminjam->programStudi;
                $jurusan = $programStudi->nama_prodi ?? 'Tidak Berlaku';
                $fakultas = $programStudi->fakultas->nama_fakultas ?? 'Tidak Berlaku';
                $organisasi = $peminjam->organisasi ?? 'Tidak Diketahui';
            }
        }

        // Tentukan tombol aksi berdasarkan status peminjaman
        $actionButton = $this->determineActionButton($statusPeminjaman, $id);
        // dd([
        //     'statusPeminjaman' => $statusPeminjaman,
        //     'userRole' => Auth::user()->role ?? 'guest',
        //     'actionButton' => $actionButton,
        // ]);

        return view('backend-alat.status-peminjaman.show', compact(
            'detailPeminjaman',
            'namaPeminjam',
            'nim',
            'fakultas',
            'jurusan',
            'organisasi',
            'actionButton'
        ));
    }

    private function determineActionButton($statusPeminjaman, $id)
    {
        $user = Auth::user();

        switch ($statusPeminjaman) {
            case 'menunggu persetujuan':
                // Tindakan hanya untuk `super_user`
                if ($user && $user->role === 'super_user') {
                    return [
                        'label' => 'Setujui Peminjaman',
                        'route' => route('persetujuan.approve', ['id' => $id]),
                        'class' => 'btn btn-warning btn-sm',
                    ];
                }
                return [
                    'label' => 'Menunggu Persetujuan',
                    'route' => '#',
                    'class' => 'btn btn-secondary btn-sm',
                ];

            case 'ditolak':
                // Tindakan hanya untuk `super_user`
                if ($user && $user->role === 'super_user') {
                    return [
                        'label' => 'Ajukan Ulang',
                        'route' => route('pengajuan.ulang', ['id' => $id]),
                        'class' => 'btn btn-danger btn-sm',
                    ];
                }
                return [
                    'label' => 'Peminjaman Ditolak',
                    'route' => '#',
                    'class' => 'btn btn-secondary btn-sm',
                ];

            case 'dipinjam':
                return [
                    'label' => 'Kembalikan Alat',
                    'route' => route('pengembalian-alat.store', ['id' => $id]),
                    'class' => 'btn btn-primary btn-sm',
                ];

            case 'dikembalikan':
                return [
                    'label' => 'Sudah Dikembalikan',
                    'route' => '#',
                    'class' => 'btn btn-success btn-sm',
                ];

            default:
                return null;
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

    /**
     * Memperbarui status alat.
     */
    public function updateStatus(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status' => 'required|in:menunggu,dipinjam,ditolak,dikembalikan'
        ]);

        // Cari data detail peminjaman
        $detailPeminjaman = DetailPeminjamanAlat::findOrFail($id);

        // Perbarui status berdasarkan input
        switch ($request->input('status')) {
            case 'dikembalikan':
                $this->handleReturn($detailPeminjaman, $request);
                break;

            case 'dipinjam':
                $this->handleApproval($detailPeminjaman);
                break;

            case 'ditolak':
                $this->handleRejection($detailPeminjaman, $request);
                break;

            default:
                // Tidak ada perubahan untuk status menunggu
                break;
        }

        return redirect()->route('status-peminjaman.index')->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    /**
     * Proses pengembalian alat.
     */
    private function handleReturn($detailPeminjaman, $request)
    {
        $detailPeminjaman->update([
            'tanggal_kembali' => now(),
            'kondisi_setelah_dikembalikan' => $request->input('kondisi_setelah_dikembalikan', 'Baik'),
        ]);

        $alat = $detailPeminjaman->alat;
        $alat->jumlah_tersedia += $detailPeminjaman->jumlah_dipinjam;
        $alat->save();
    }

    /**
     * Proses persetujuan peminjaman.
     */
    private function handleApproval($detailPeminjaman)
    {
        $detailPeminjaman->persetujuanKetum->update([
            'status_persetujuan' => 'disetujui',
        ]);
    }

    /**
     * Proses penolakan peminjaman.
     */
    private function handleRejection($detailPeminjaman, $request)
    {
        $detailPeminjaman->persetujuanKetum->update([
            'status_persetujuan' => 'ditolak',
            'catatan' => $request->input('catatan', 'Tidak ada alasan diberikan.'),
        ]);
    }
}
