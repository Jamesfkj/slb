<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Commande;

class ajout_panier extends Controller
{
    public function ajoutPanier(Request $request)
    {
        $userId = Auth::id();
        $produitId = $request->input('produit_id');

        // Récupérer le panier actuel de la session
        $panier = session()->get('panier', []);

        // Initialiser le panier pour cet utilisateur s'il n'existe pas encore
        if (!isset($panier[$userId])) {
            $panier[$userId] = [];
        }

        // Ajouter l'ID du produit au panier si ce n'est pas déjà présent
        if (!isset($panier[$userId][$produitId])) {
            $panier[$userId][$produitId] = [
                'id' => $produitId,
                'quantite' => 1
            ];
        } else {
            return redirect()->back()->with('error', 'Ce produit est déjà dans votre panier');
        }

        // Mettre à jour la session
        session(['panier' => $panier]);

        return redirect()->back()->with('success', 'Produit ajouté au panier');
    }


    public function AfficherPanier()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
        } else {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à votre panier.');
        }

        $categories = Categorie::all();
        $commande = Commande::where('users_id', $userId)->first();
        $panier = session()->get('panier', []);

        if (isset($panier[$userId]) && !empty($panier[$userId])) {
            $produitIds = array_keys($panier[$userId]); // Récupérer les IDs des produits
            $produits = Produit::whereIn('id', $produitIds)->get();
            $totalPanier = 0;

            foreach ($produits as $produit) {
                $quantite = isset($panier[$userId][$produit->id]['quantite']) ? $panier[$userId][$produit->id]['quantite'] : 1;
                $totalPanier += $produit->prix * $quantite;
            }

            return view('user.panier', [
                'produits' => $produits,
                'categories' => $categories,
                'userId' => $userId,
                'commande' => $commande,
                'panier' => $panier[$userId], // Passez le panier de l'utilisateur à la vue
                'totalPanier' => $totalPanier, // Transmettre le total du panier à la vue
            ]);
        } elseif (empty($panier[$userId])) {
            return redirect()->route('welcome')->with('error', 'Votre panier est maintenant vide.');
        } else {
            return redirect()->back()->with('error', 'Aucun produit n\'existe dans votre panier.');
        }
    }


    public function modifierQte(Request $request, $id)
    {
        $userId = Auth::id();
        $produit = Produit::findorFail($id);
        $request->validate(
            [
                'quantite' => 'required|numeric|min:1',
            ],
            [
                'quantite.min' => 'La quantité doit être supérieure ou égale à 1',
                'quantite.numeric' => 'La quantité doit être un nombre',
                'quantite.required' => 'Veuillez saisir une quantité',
            ]
        );
        $quantite = $request->input('quantite');
        $panier = session()->get('panier', []);
        //$id est l'id du produit passée à la route
        if (isset($panier[$userId])) {
            if ($produit->qte_stock >= $quantite) {
                $panier[$userId][$id]['quantite'] = $quantite;
            } else{
                return redirect()->back()->with('error', 'Quantité en stock insuffisante pour ce produit');
            }

                session()->put('panier', $panier);
        }

        return redirect()->back()->with('success', 'Quantité modifiée');
    }

    public function RetirerDuPanier($id)
    {
        $userId = Auth::id();
        $panier = session()->get('panier', []);

        if (isset($panier[$userId])) {
            if (isset($panier[$userId][$id])) {
                // Supprimer le produit du panier
                unset($panier[$userId][$id]);
                session()->put('panier', $panier);
            }
            return redirect()->route('panier')->with('success', 'Produit retiré du panier');
        }
    }
}