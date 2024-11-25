<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Bph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exports\AlatExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin' || $user->role->name === 'inventaris') {
            $bph = Bph::all();
            $query = Alat::with('bph');

            // Filter berdasarkan divisi
            if ($request->filled('divisi_filter')) {
                $query->where('id_bph', $request->divisi_filter);
            }

            $alat = $query->get();
            return view('alat.index', compact('alat', 'bph'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    /**
     * Display the specified resource.
     */
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin' || $user->role->name === 'inventaris') {
            Log::info("Memuat detail alat dengan ID: $id");

            // Ambil data alat beserta relasi ke bph dan detail peminjaman
            $alat = Alat::with([
                'bph',
                'detailPeminjaman' => function ($query) {
                    $query->whereHas('persetujuanKetum', function ($q) {
                        $q->where('status_persetujuan', 'disetujui');
                    });
                },
                'detailPeminjaman.peminjamable',
            ])->findOrFail($id);

            // Tambahkan informasi nama peminjam ke setiap detail peminjaman
            foreach ($alat->detailPeminjaman as $peminjaman) {
                if ($peminjaman->peminjamable_type === \App\Models\Anggota::class) {
                    $peminjaman->nama_peminjam = $peminjaman->peminjamable->nama_anggota ?? 'Tidak Diketahui';
                } elseif ($peminjaman->peminjamable_type === \App\Models\PeminjamEksternal::class) {
                    $peminjaman->nama_peminjam = $peminjaman->peminjamable->nama ?? 'Tidak Diketahui';
                } else {
                    $peminjaman->nama_peminjam = 'Tidak Diketahui';
                }

                // Tambahkan log lebih detail
                Log::info('Detail Peminjaman', [
                    'id_detail_peminjaman' => $peminjaman->id_detail_peminjaman_alat,
                    'peminjamable_id' => $peminjaman->peminjamable_id,
                    'peminjamable_type' => $peminjaman->peminjamable_type,
                    'nama_peminjam' => $peminjaman->nama_peminjam,
                ]);
            }


            // Redirect ke tampilan detail alat di backend
            return view('alat.show', compact('alat'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }



    public function create()
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin' || $user->role->name === 'inventaris') {
            $bphList = Bph::all();
            return view('alat.create', compact('bphList'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    public function store(Request $request)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin' || $user->role->name === 'inventaris') {
            $request->validate([
                'id_bph' => 'required|string|exists:bph,id_bph',
                'nama_alat' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'jumlah_tersedia' => 'required|integer|min:1',
                'foto' => 'nullable|image|max:2048', // Max 2MB
            ]);

            $lastId = Alat::where('id_bph', $request->id_bph)->max('id_alat');
            $increment = $lastId ? intval(substr($lastId, -3)) + 1 : 1;
            $id_alat = $request->id_bph . '-' . str_pad($increment, 3, '0', STR_PAD_LEFT);

            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoName = Str::random(10) . '.' . $request->file('foto')->getClientOriginalExtension();
                $request->file('foto')->move(storage_path('app/public/alats'), $fotoName);
                $fotoPath = 'alats/' . $fotoName;
            }

            Alat::create([
                'id_alat' => $id_alat,
                'id_bph' => $request->id_bph,
                'nama_alat' => $request->nama_alat,
                'deskripsi' => $request->deskripsi,
                'jumlah_tersedia' => $request->jumlah_tersedia,
                'foto' => $fotoPath,
            ]);

            return redirect()->route('alat.index')->with('success', 'Alat berhasil ditambahkan.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alat $alat)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin' || $user->role->name === 'inventaris') {
            $bphList = Bph::all();
            return view('alat.edit', compact('alat', 'bphList'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alat $alat)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin' || $user->role->name === 'inventaris') {
            $request->validate([
                'nama_alat' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'jumlah_tersedia' => 'required|integer',
                'foto' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('foto')) {
                if ($alat->foto && file_exists(storage_path('app/public/' . $alat->foto))) {
                    unlink(storage_path('app/public/' . $alat->foto));
                }

                $fotoName = Str::random(10) . '.' . $request->file('foto')->getClientOriginalExtension();
                $request->file('foto')->move(storage_path('app/public/alats'), $fotoName);
                $alat->foto = 'alats/' . $fotoName;
            }

            $alat->update([
                'nama_alat' => $request->nama_alat,
                'deskripsi' => $request->deskripsi,
                'jumlah_tersedia' => $request->jumlah_tersedia,
                'foto' => $alat->foto,
            ]);

            return redirect()->route('alat.index')->with('success', 'Alat berhasil diperbarui.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alat $alat)
    {
        $user = Auth::guard('anggota')->user();
        if ($user->role && $user->role->name === 'super_user' || $user->role->name === 'admin' || $user->role->name === 'inventaris') {
            if ($alat->foto && file_exists(storage_path('app/public/' . $alat->foto))) {
                unlink(storage_path('app/public/' . $alat->foto));
            }

            $alat->delete();

            return redirect()->route('alat.index')->with('success', 'Alat berhasil dihapus.');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    public function laporanDataAlat(Request $request)
    {
        Log::info('Laporan Data Alat Method Called');
        // Debug input filter
        Log::info('Filter Input:', $request->all());

        $user = Auth::guard('anggota')->user();
        if ($user->role && ($user->role->name === 'super_user' || $user->role->name === 'admin')) {
            // Query awal
            $query = Alat::join('bph', 'alat.id_bph', '=', 'bph.id_bph')
                ->select(
                    'alat.id_alat',
                    'alat.nama_alat',
                    'alat.deskripsi',
                    'alat.jumlah_tersedia',
                    'alat.status_alat',
                    'bph.nama_divisi_bph'
                );

            // Filter berdasarkan divisi BPH
            if ($request->filled('id_bph')) {
                $query->where('alat.id_bph', $request->id_bph);
            }

            // Dapatkan hasil
            $alat = $query->orderBy('alat.nama_alat', 'asc')->get();

            // Dapatkan daftar BPH untuk dropdown filter
            $bphList = Bph::all();

            return view('alat.laporan', compact('alat', 'bphList'));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    public function downloadPdf(Request $request)
    {
        // Query awal
        $query = Alat::join('bph', 'alat.id_bph', '=', 'bph.id_bph')
            ->select(
                'alat.id_alat',
                'alat.nama_alat',
                'alat.deskripsi',
                'alat.jumlah_tersedia',
                'alat.status_alat',
                'bph.nama_divisi_bph'
            );

        // Apply filter
        if ($request->filled('id_bph')) {
            $query->where('alat.id_bph', $request->id_bph);
        }

        $alat = $query->orderBy('alat.nama_alat', 'asc')->get();
        $filteredBph = $request->filled('id_bph') ? Bph::where('id_bph', $request->id_bph)->pluck('nama_divisi_bph')->first() : 'Semua Divisi';

        $user = Auth::guard('anggota')->user();

        // Generate PDF
        $pdf = PDF::loadView('alat.pdf', compact('alat', 'filteredBph', 'user'));
        return $pdf->download('laporan_alat.pdf');
    }

    public function downloadExcel(Request $request)
    {
        return Excel::download(new AlatExport($request), 'laporan_alat.xlsx');
    }
}
