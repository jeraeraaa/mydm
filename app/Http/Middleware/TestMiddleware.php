<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class TestMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('TestMiddleware is being called');
        dd('Middleware is working');
        return $next($request);
    }
}
