<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::guard('anggota')->user();

        // Beri akses penuh kepada super_user
        if ($user->role === 'super_user') {
            return $next($request);
        }

        // Cek apakah peran user ada di dalam list $roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika role tidak sesuai, redirect ke halaman akses ditolak
        return abort(403, 'Akses ditolak');
    }
}
