<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePlatformAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect('/admin/login');
        }

        return $next($request);
    }
}
