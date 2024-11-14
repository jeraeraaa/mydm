<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('anggota')->user();
        // dd($user->role->name); // Menampilkan nama role untuk verifikasi

        if ($user->role && ($user->role->name === 'admin' || $user->role->name === 'super_user')) {
            return view('dashboard');
        } else {
            abort(403, 'Akses Ditolak');
        }
    }
}
