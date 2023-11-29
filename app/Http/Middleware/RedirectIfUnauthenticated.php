<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfUnauthenticated
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() && $request->routeIs('protegida.*'))
        {
            return redirect('/')->with('error', 'sua sessão expirou!');
        }

        return $next($request);
    }
}
