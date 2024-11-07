<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Akses super user ke semua halaman
        if ($user->role === 'superuser') {
            return $next($request);
        }

        // Akses berdasarkan peran yang diteruskan
        if ($user->role === $role) {
            return $next($request);
        }

        return redirect('/'); // redirect jika peran tidak sesuai
    }
}
