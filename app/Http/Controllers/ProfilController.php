<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function show($id_anggota)
    {
        // Data anggota dengan relasi prodi, fakultas, dan absensi
        $anggota = Anggota::with(['prodi.fakultas', 'absensi.detailKegiatan'])->findOrFail($id_anggota);

        // Riwayat peminjaman dengan tambahan accessor status_peminjaman
        $riwayatPeminjaman = $anggota->detailPeminjamanAlat()->with('alat')->get();

        // Riwayat kegiatan diambil dari relasi absensi
        $riwayatKegiatan = $anggota->absensi;

        return view('profile.profil', compact('anggota', 'riwayatPeminjaman', 'riwayatKegiatan'));
    }

    public function edit($id_anggota)
    {
        $anggota = Anggota::findOrFail($id_anggota);
        return view('profile.edit', compact('anggota'));
    }

    public function update(Request $request, $id_anggota)
    {
        $anggota = Anggota::findOrFail($id_anggota);

        // Validasi input
        $request->validate([
            'nama_anggota' => 'required|string|regex:/^[a-zA-Z\s]*$/|max:255',
            'email' => 'required|email|unique:anggota,email,' . $anggota->id_anggota . ',id_anggota',
            'no_hp' => 'required|string|regex:/^[0-9]{10,13}$/',
            'tanggal_lahir' => 'required|date|before:' . now()->subYears(17)->format('Y-m-d'),
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Cek dan proses file foto_profil jika diunggah
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($anggota->foto_profil && file_exists(storage_path('app/public/foto_profil/' . $anggota->foto_profil))) {
                unlink(storage_path('app/public/foto_profil/' . $anggota->foto_profil));
            }

            // Simpan foto baru
            $file = $request->file('foto_profil');
            $path = $file->store('foto_profil', 'public');
            $data['foto_profil'] = basename($path);
        }

        // Update data anggota
        $anggota->update($data);

        // Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profile.show', $id_anggota)->with('success', 'Profil berhasil diperbarui.');
    }
}
