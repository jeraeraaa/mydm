<?php

namespace App\Http\Controllers;

use App\Models\DetailKegiatan;
use Illuminate\Http\Request;

class FrontendKegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = DetailKegiatan::with(['kegiatan', 'bph'])
            ->where('tanggal_mulai', '>=', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        return view('frontend-kegiatan.index', compact('kegiatan'));
    }
}
