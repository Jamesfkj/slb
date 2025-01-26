<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authentifier l'utilisateur
        $request->authenticate();

        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Vérifier si le compte est désactivé
        if ($user->user_type === 'désactivé') {
            Auth::logout(); // Déconnecter l'utilisateur
            $request->session()->invalidate(); // Invalider la session
            $request->session()->regenerateToken(); // Régénérer le token CSRF

            // Rediriger vers la page d'accueil avec un message d'erreur
            return redirect()->route('welcome')->with('error', 'Votre compte a été supprimé.');
        }

        // Régénérer la session pour sécuriser
        $request->session()->regenerate();

        // Rediriger vers la route prévue après la connexion
        return redirect()->intended(route('welcome'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('welcome'));
    }
}
