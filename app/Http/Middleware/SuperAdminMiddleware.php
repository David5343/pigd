<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Usar el middleware de Spatie `role`
        // if (!$user || !$user->hasRole('SuperAdmin')) {
        //     abort(403, 'Unauthorized');
        // }

        return $next($request);
    }
}
