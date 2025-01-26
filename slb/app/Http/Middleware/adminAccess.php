<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class adminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->user_type=='admin') {
        return $next($request);
    }
    elseif (Auth::check()&&Auth::user()->user_type!== 'admin') {
        return redirect('/')->with('error', 'Vous n\'avez pas droit à l\'espace administrateur!');
    }
    else{
        return redirect('/login')->with('error', 'Vous n\'avez pas droit à l\'espace administrateur ou connectez-vous pour y acceder!');
    }
}
}
