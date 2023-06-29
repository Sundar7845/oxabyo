<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Closure;

class EnsureAdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! Auth::user()->isAdmin(Auth::user())) {       
            
            Auth::logout();
            Session::flush();
            return redirect('/login');
        }

        return $next($request);
    }
}
