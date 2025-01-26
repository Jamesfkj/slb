<?php

namespace App\Http\Controllers;

use App\Models\Article_commandee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Support\Str;

class GestCommande extends Controller
{
    public function creer_num_recu($username)
    {
        $deux_prem_lettre = strtoupper(substr($username, 0, 2));
        do {
            $nb_aleatoire = Str::random(4);
            $num_recu = $deux_prem_lettre.$nb_aleatoire;
            $commande = Commande::where('numero_commande', $num_recu)->first();
        } while ($commande !== null);
        
        return $num_recu;
    }
    public function creerCommande()
{
    $userId = Auth::id();
    $user = User::findOrFail($userId); 
    $num_recu = $this->creer_num_recu($user->name);
    $panier = session()->get('panier', []);
    if (!isset($panier[$userId]) || empty($panier[$userId])) {
        return redirect()->back()->with('error', 'Votre panier est vide.');
    }

    $produitIds = array_keys($panier[$userId]); // Récupérer les IDs des produits

    // Calcul du montant total
    $totalPanier = 0;
    $produitsData = [];
    foreach ($produitIds as $produitId) {
        $produit = Produit::find($produitId);
        if ($produit) {
            $quantite = $panier[$userId][$produitId]['quantite'] ?? 1;
            $prixDeVente = $produit->prix; // Assurez-vous d'avoir le prix de vente du produit
            $totalPanier += $prixDeVente * $quantite;
            $produitsData[$produitId] = [
                'qte_commande' => $quantite,
                'prix_de_vente' => $prixDeVente,
            ];
        }
    }

    // Création de la commande pour cette liste des produits
    $commande = new Commande();
    $commande->users_id = $userId;
    $commande->montant = $totalPanier;
    $commande->numero_commande = $num_recu;
    $commande->save();

    // Création des relations entre la commande et les produits du panier
    $commande->produits()->attach($produitsData);

    // Vider le panier de l'utilisateur quand il enregistre la commande
    session()->forget("panier.$userId");

    return redirect()->route('mesCommandes', ['etat' => 'en cours'])->with('success', 'Votre commande a été créée avec succès.');
}
public function mesCommandes($etat)
{
    $userId = Auth::id();
    $panier = session()->get('panier', []);
    $verification = !empty($panier[$userId] ?? null);

    $query = Commande::where('users_id', $userId);

    if (in_array($etat, ['en cours', 'payée'])) {
        $query->where('etat', $etat);
    }

    $commandes = $query->orderBy('created_at', 'desc')->get();

    return view('user.commande', [
        'commandes' => $commandes,
        'verification' => $verification,
    ]);
}

public function detailCommande($id){
    $commande = Commande::findorFail($id);
    
    return view('user.detailCommande', compact('commande', 'produits'));
}

}
                 