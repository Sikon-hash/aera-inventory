<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $userRole = auth()->user()->role->nama_role;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'Akses ditolak.');
    }
}
