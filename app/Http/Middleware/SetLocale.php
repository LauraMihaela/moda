<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $language = "es";
        $currentUser = auth()->user();
        // if (is_null($currentUser) || empty($currentUser)){
        if(session()->has('lang')){
            $language = session()->get('lang');
        }
        // }
        // Cambia idioma de app
        app()->setLocale($language);
        return $next($request);
    }
}
