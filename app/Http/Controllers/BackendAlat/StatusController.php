<?php

namespace App\Http\Controllers\BackendAlat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailPeminjamanAlat;
use App\Models\Alat;
use Illuminate\Support\Facades\Auth;

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
            return redirect()->route('status-peminjaman.index')->withErrors(['error' => 'Data peminjaman tidak ditemukan.']);
        }

        // Ambil data peminjam (polymorphic)
        $peminjam = $detailPeminjaman->first()->peminjamable;
        $namaPeminjam = null;
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
        } else {
            $namaPeminjam = 'Tidak Diketahui';
        }

        // Tentukan tombol aksi berdasarkan status peminjaman
        $statusPeminjaman = $detailPeminjaman->first()->status_peminjaman ?? null;
        $actionButton = null;

        $user = Auth::user(); // Ambil data user login menggunakan Auth

        if ($statusPeminjaman === 'menunggu persetujuan' || $statusPeminjaman === 'ditolak') {
            if ($user && $user->role === 'super_user') {
                $actionButton = [
                    'label' => 'Setujui Peminjaman',
                    'route' => route('persetujuan.approve', ['id' => $id]),
                    'class' => 'btn btn-warning btn-sm',
                ];
            }
        } elseif ($statusPeminjaman === 'dipinjam') {
            $actionButton = [
                'label' => 'Kembalikan Alat',
                'route' => route('pengembalian-alat.create', ['id' => $id]),
                'class' => 'btn btn-primary btn-sm',
            ];
        }

        // Return view dengan data
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
