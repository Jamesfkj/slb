<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Commande;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
    
        $request->user()->save();

        return redirect()->back()->with('success', 'Profile modifié');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function monProfil($id){
        $user = User::find($id);
        $nb_commande=Commande::where('users_id', $user->id)->count();
        $comm_en_cours = Commande::where('users_id', $user->id)->where('etat', 'en cours')->count();
        $comm_payees = Commande::where('users_id', $user->id)->where('etat', 'payee')->count();
        return view('user.profil', compact('user', 'nb_commande', 'comm_payees', 'comm_en_cours'));
    }

    public function SupprimerCompte($id)
{
    $user = User::findOrFail($id);

    // Désactiver le compte utilisateur
    $user->user_type = 'désactivé';
    $user->save();

    if (auth()->id() == $user->id) {
        auth()->logout(); 
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Rediriger vers la page d'accueil avec un message de succès
        return redirect()->route('welcome')->with('error', 'Votre compte a été supprimé.');
    }

    // Si l'utilisateur désactivé n'est pas l'utilisateur connecté, rediriger l'admin vers une page spécifique
    return redirect()->back()->with('success', 'Compte désactivé avec succès.');
}

public function activerCompte($id){
    $user = User::findOrFail($id);

    // Activer le compte utilisateur
    $user->user_type = 'user';
    $user->save();

    return redirect()->back()->with('success', 'Compte réactivé avec succès.');
}
}
