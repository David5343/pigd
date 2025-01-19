<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIfActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->trashed()) {
            // Cierra la sesión si el usuario está desactivado
            Auth::logout();

            return redirect()->route('auth.login')->withErrors([
                'email' => 'Su cuenta ha sido desactivada.',
            ]);
        }

        return $next($request);
    }
}
