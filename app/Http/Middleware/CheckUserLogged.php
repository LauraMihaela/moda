<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLogged
{
    /**
     * Handle an incoming request.
     * Comprueba si el usuario está o no logueado, para que, en caso de que no lo esté,
     * vuelva a la vista de logueo al intentar acceder a vistas no autorizadas
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se obtiene el usuario autenticado. Si no hay usuario $user es null
        $user = Auth::user();

        if(is_null($user)){
            return redirect('/')->withErrors("Su sesión ha expirado");
        }

        return $next($request);
    }
}
