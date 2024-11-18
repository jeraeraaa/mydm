<?php

namespace App\Http\Controllers;

use App\Models\DetailKegiatan;
use Illuminate\Http\Request;

class FrontendKegiatanController extends Controller
{
    public function index()
    {
        // Kegiatan yang akan datang
        $kegiatanMendatang = DetailKegiatan::with(['kegiatan', 'bph'])
            ->where('tanggal_mulai', '>=', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        // Kegiatan yang telah selesai
        $kegiatanSelesai = DetailKegiatan::with(['kegiatan', 'bph'])
            ->where('tanggal_selesai', '<', now())
            ->orderBy('tanggal_selesai', 'desc')
            ->get();

        return view('frontend-kegiatan.index', compact('kegiatanMendatang', 'kegiatanSelesai'));
    }

    public function show($id)
    {
        $detailKegiatan = DetailKegiatan::with(['kegiatan', 'materi.pembicara'])
            ->findOrFail($id);

        return view('frontend-kegiatan.show', compact('detailKegiatan'));
    }
}
