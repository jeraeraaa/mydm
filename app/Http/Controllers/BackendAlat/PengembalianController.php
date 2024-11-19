<?php

namespace App\Http\Controllers\BackendAlat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailPeminjamanAlat;
use App\Models\Alat;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    /**
     * Menampilkan form pengembalian alat.
     *
     * @param int $id ID Grup Peminjaman
     * @return \Illuminate\View\View
     */


    public function create($id)
    {

        // Ambil semua detail peminjaman dalam grup yang sama
        $detailPeminjaman = DetailPeminjamanAlat::with('alat')->where('id_grup_peminjaman', $id)->get();

        if ($detailPeminjaman->isEmpty()) {
            return redirect()->route('status-peminjaman.index')->withErrors(['error' => 'Data peminjaman tidak ditemukan.']);
        }

        // Ambil tanggal kembali default dari peminjaman pertama dalam grup
        $defaultTanggalKembali = $detailPeminjaman->first()->tanggal_kembali ?? now()->format('Y-m-d');

        // Return view dengan semua data yang diperlukan

        $user = Auth::guard('anggota')->user();
        // dd($user->role->name); // Menampilkan nama role untuk verifikasi

        if ($user->role && ($user->role->name === 'admin' || $user->role->name === 'super_user' || $user->role->name === 'inventaris')) {
            return view('backend-alat.pengembalian-alat.create', compact('id', 'detailPeminjaman', 'defaultTanggalKembali'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }


    public function store(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal_kembali' => 'required|date',
            'catatan' => 'nullable|string',
            'kondisi_setelah_dikembalikan.*' => 'required|string',
        ]);

        // Ambil data peminjaman
        $detailPeminjaman = DetailPeminjamanAlat::where('id_grup_peminjaman', $id)->get();

        foreach ($detailPeminjaman as $detail) {
            // Update data peminjaman
            $detail->update([
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'kondisi_setelah_dikembalikan' => $validated['kondisi_setelah_dikembalikan'][$detail->id_detail_peminjaman_alat],
                'catatan' => $validated['catatan'] ?? null,
                'is_returned' => true,
                'id_inventaris' => Auth::user()->role === 'inventaris' ? Auth::id() : null, // Inventaris otomatis diisi ID user login jika role Inventaris
            ]);

            // Update jumlah alat
            $alat = $detail->alat;
            $alat->jumlah_tersedia += $detail->jumlah_dipinjam;
            $alat->save();
        }

        $user = Auth::guard('anggota')->user();
        // dd($user->role->name); // Menampilkan nama role untuk verifikasi
        
        if ($user->role && ($user->role->name === 'admin' || $user->role->name === 'super_user' || $user->role->name === 'inventaris')) {
            return redirect()->route('status-peminjaman.index')->with('success', 'Pengembalian berhasil disimpan.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }
}
