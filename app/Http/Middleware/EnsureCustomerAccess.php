<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\UserRole;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomerAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) return redirect('/app/login');

        $role = UserRole::tryFrom($user->role ?? '');
        if ($role && $role->isPlatform()) {
            return redirect('/admin');
        }
        return $next($request);
    }
}
