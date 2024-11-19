<?php

namespace App\Http\Controllers\BackendKegiatan;

use App\Http\Controllers\Controller;
use App\Models\DetailKegiatan;
use App\Models\Kegiatan;
use App\Models\Bph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DetailKegiatanController extends Controller
{
    // Display a listing of the detail kegiatan
    public function index()
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            try {
                $details = DetailKegiatan::with(['kegiatan', 'bph'])->get();
                $bphList = Bph::all(); // Mendapatkan seluruh data divisi BPH
                $kegiatanList = Kegiatan::all(); // Menyertakan kegiatan untuk tampilan index jika diperlukan
                return view('backend-kegiatan.detail-kegiatan.index', compact('details', 'bphList', 'kegiatanList'));
            } catch (\Exception $e) {
                Log::error("Failed to display detail kegiatan list: " . $e->getMessage());
                return back()->withErrors(['error' => 'Failed to display detail kegiatan list.']);
            }
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    public function show($id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            try {
                // Temukan detail kegiatan berdasarkan ID
                $detailKegiatan = DetailKegiatan::with(['kegiatan', 'bph'])->findOrFail($id);

                // Kembalikan view dengan data detail kegiatan
                return view('backend-kegiatan.detail-kegiatan.show', compact('detailKegiatan'));
            } catch (\Exception $e) {
                Log::error("Failed to show detail kegiatan: " . $e->getMessage());
                return back()->withErrors(['error' => 'Gagal menampilkan detail kegiatan.']);
            }
        } else {
            abort(403, 'Akses Ditolak');
        }
    }


    // Show the form for creating a new detail kegiatan
    public function create()
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin') {
            $kegiatanList = Kegiatan::all();
            $bphList = Bph::all(); // Mengambil seluruh data BPH untuk ditampilkan di form
            return view('backend-kegiatan.detail-kegiatan.create', compact('kegiatanList', 'bphList'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $request->validate([
            'id_kegiatan' => 'required|exists:kegiatan,id_kegiatan',
            'id_bph' => 'nullable|exists:bph,id_bph',
            'nama_detail_kegiatan' => 'required|string|max:255',
            'deskripsi_detail' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'lokasi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Validasi tambahan untuk waktu jika tanggal sama
        if ($request->tanggal_mulai === $request->tanggal_selesai && $request->waktu_selesai <= $request->waktu_mulai) {
            return back()->withErrors([
                'waktu_selesai' => 'Waktu selesai harus lebih besar dari waktu mulai pada tanggal yang sama.',
            ])->withInput();
        }

        try {
            $data = $request->all();

            // Menentukan id_bph berdasarkan kategori kegiatan
            $kegiatan = Kegiatan::findOrFail($request->id_kegiatan);
            if ($kegiatan->kategori == 'Program Kerja') {
                $data['id_bph'] = 'Inti'; // Jika kategori Program Kerja, set id_bph sebagai "Inti"
            }

            // Simpan foto jika ada
            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('foto_detail_kegiatan', 'public');
            }

            DetailKegiatan::create($data);
            return redirect()->route('detail-kegiatan.index')->with('success', 'Detail kegiatan berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error("Failed to add detail kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to add detail kegiatan.'])->withInput();
        }
    }


    public function update(Request $request, $id)
    {
        // Validasi dasar tanpa required untuk waktu_mulai dan waktu_selesai
        $request->validate([
            'id_kegiatan' => 'required|exists:kegiatan,id_kegiatan',
            'id_bph' => 'nullable|exists:bph,id_bph',
            'nama_detail_kegiatan' => 'required|string|max:255',
            'deskripsi_detail' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil data detail kegiatan
        $detailKegiatan = DetailKegiatan::findOrFail($id);

        // Proses waktu_mulai dan waktu_selesai dengan Carbon jika diisi ulang
        $data = $request->all();
        if ($request->filled('waktu_mulai')) {
            $data['waktu_mulai'] = Carbon::parse($request->waktu_mulai)->format('H:i');
        } else {
            $data['waktu_mulai'] = $detailKegiatan->waktu_mulai;
        }

        if ($request->filled('waktu_selesai')) {
            $data['waktu_selesai'] = Carbon::parse($request->waktu_selesai)->format('H:i');
        } else {
            $data['waktu_selesai'] = $detailKegiatan->waktu_selesai;
        }

        // Validasi waktu jika tanggal mulai dan selesai sama
        if ($data['tanggal_mulai'] === $data['tanggal_selesai'] && $data['waktu_selesai'] <= $data['waktu_mulai']) {
            return back()->withErrors([
                'waktu_selesai' => 'Waktu selesai harus lebih besar dari waktu mulai pada tanggal yang sama.',
            ])->withInput();
        }

        try {
            // Menyimpan data dan foto baru jika ada
            if ($request->hasFile('foto')) {
                if ($detailKegiatan->foto && Storage::disk('public')->exists($detailKegiatan->foto)) {
                    Storage::disk('public')->delete($detailKegiatan->foto);
                }
                $data['foto'] = $request->file('foto')->store('foto_detail_kegiatan', 'public');
            }

            $detailKegiatan->update($data);
            return redirect()->route('detail-kegiatan.index')->with('success', 'Detail kegiatan berhasil diperbaharui.');
        } catch (\Exception $e) {
            Log::error("Failed to update detail kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update detail kegiatan.'])->withInput();
        }
    }




    // Show the form for editing the specified detail kegiatan
    public function edit($id)
    {
        $detailKegiatan = DetailKegiatan::findOrFail($id);
        $kegiatanList = Kegiatan::all();
        $bphList = Bph::all(); // Mengambil seluruh data BPH untuk ditampilkan di form edit
        return view('backend-kegiatan.detail-kegiatan.edit', compact('detailKegiatan', 'kegiatanList', 'bphList'));
    }



    // Remove the specified detail kegiatan from storage
    public function destroy($id)
    {
        try {
            $detailKegiatan = DetailKegiatan::findOrFail($id);

            // Delete the photo if exists
            if ($detailKegiatan->foto && Storage::disk('public')->exists($detailKegiatan->foto)) {
                Storage::disk('public')->delete($detailKegiatan->foto);
            }

            $detailKegiatan->delete();
            return redirect()->route('detail-kegiatan.index')->with('success', 'Detail kegiatan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Failed to delete detail kegiatan: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus detail kegiatan.']);
        }
    }
}
