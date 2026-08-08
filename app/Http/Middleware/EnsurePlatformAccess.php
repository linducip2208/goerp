<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\UserRole;
use Symfony\Component\HttpFoundation\Response;

class EnsurePlatformAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) return redirect('/admin/login');

        $role = UserRole::tryFrom($user->role ?? '');
        if (!$role || !$role->isPlatform()) {
            abort(403, 'Akses ditolak. Hanya Platform Admin yang dapat mengakses halaman ini.');
        }
        return $next($request);
    }
}
