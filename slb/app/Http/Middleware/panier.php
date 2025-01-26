<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class panier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $panier = session()->get('panier', []);
            if (!isset($panier[$userId])) {
                return redirect()->back()->with('error', 'Votre panier est vide');
            }
        }
        return $next($request);
    }
}
