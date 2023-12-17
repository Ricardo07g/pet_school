<?php
namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RedirectIfUnauthenticated
{
    public function handle($request, Closure $next)
    {   
        //var_dump(Auth::user());
        //die();

        switch (true)
        {
            case (!Auth::check() && $request->routeIs('protegida.*')):
                    Session::flush();
                    Auth::logout();
                    return redirect('/')->with('error', 'sua sessão expirou!');
                break;

            case (Auth::check() && Auth::user()->ativo != 1):
                    Session::flush();
                    Auth::logout();
                    return redirect('/')->with('error', 'sua sessão expirou!');
                break;

            default:
                return $next($request);
                break;
        }
    }
}
