<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class compte_bani
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type === 'désactivé') {
                Auth::logout(); 
                $request->session()->invalidate(); 
                $request->session()->regenerateToken(); 

                return redirect()->route('welcome')->with('error', 'Votre compte a été désactivé.');
            }
        }

        return $next($request);
    }
}
