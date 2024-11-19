<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Anggota;
use App\Models\Alat;
use App\Models\DetailKegiatan;
use App\Models\DetailPeminjamanAlat;
use App\Models\Fakultas;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('anggota')->user();
        // dd($user->role->name); // Menampilkan nama role untuk verifikasi

        if ($user->role && ($user->role->name === 'admin' || $user->role->name === 'super_user' || $user->role->name === 'inventaris')) {
            // Total anggota
            $totalMembers = Anggota::count();

            // Total peminjaman
            $totalBorrowings = DetailPeminjamanAlat::count();

            $totalDetailKegiatan = DetailKegiatan::count();

            // Anggota berdasarkan fakultas
            $membersByFaculty = Fakultas::with('prodi.anggota')->get()->map(function ($fakultas) {
                return [
                    'nama_fakultas' => $fakultas->nama_fakultas,
                    'total_anggota' => $fakultas->prodi->sum(function ($prodi) {
                        return $prodi->anggota->count();
                    }),
                ];
            });

            // Statistik peminjaman berdasarkan alat
            $topBorrowedItems = DetailPeminjamanAlat::select('id_alat', DB::raw('COUNT(*) as total'))
                ->with('alat') // Include relationship to fetch alat data
                ->groupBy('id_alat')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            return view('dashboard', compact(
                'totalMembers',
                'totalBorrowings',
                'totalDetailKegiatan',
                'membersByFaculty',
                'topBorrowedItems'
            ));
        } else {
            abort(403, 'Akses Ditolak');
        }
    }

    public function getStats()
    {
        $user = Auth::guard('anggota')->user();
        // dd($user->role->name); // Menampilkan nama role untuk verifikasi

        if ($user->role && ($user->role->name === 'admin' || $user->role->name === 'super_user' || $user->role->name === 'inventaris')) {
            $totalMembers = \App\Models\Anggota::count();
            $totalActivities = \App\Models\Kegiatan::count();
            $totalItems = \App\Models\Alat::count();
            $upcomingActivities = \App\Models\Kegiatan::where('tanggal', '>', now())->get(['name', 'tanggal']);

            return response()->json([
                'totalMembers' => $totalMembers,
                'totalActivities' => $totalActivities,
                'totalItems' => $totalItems,
                'upcomingActivities' => $upcomingActivities,
            ]);
        } else {
            abort(403, 'Akses Ditolak');
        }
    }
}
