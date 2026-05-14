<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $roleUser = strtolower($user->role->nama_role ?? '');

        $roles = array_map('strtolower', $roles);

        if (!in_array($roleUser, $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
