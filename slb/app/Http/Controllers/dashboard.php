<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\Categorie;
use Carbon\Carbon;

class dashboard extends Controller
{
    public function dashboardPage(Request $request)
    {
        if ($request->filled('date')) {
            $date = Carbon::parse($request->input('date'));
            $today_debut = $date->copy()->startOfDay();
            $today_fin = $date->copy()->endOfDay();
            $titre = $date->format('d/m/Y');
        } else {
            $today_debut = Carbon::today(); // Début de la journée actuelle (00:00:00)
            $today_fin = Carbon::tomorrow(); // Début de la journée suivante (00:00:00)
            $titre = "Aujourd'hui";
        }
        $users = User::where('user_type', 'user')
            ->whereBetween('created_at', [$today_debut, $today_fin])->latest('created_at')
            ->limit(3)
            ->get();

        $commandes=Commande::whereBetween('created_at', [$today_debut, $today_fin])
            ->count();

        $commandes_en_cours = Commande::whereBetween('created_at', [$today_debut, $today_fin])->latest('created_at')
        ->limit(3)
        ->get();

        $commandes_payee = Commande::where('etat', 'payée')
            ->whereBetween('updated_at', [$today_debut, $today_fin])->latest('updated_at')
            ->limit(3)
            ->get();
        $nb_inscrit = User::where('user_type', 'user')
            ->whereBetween('created_at', [$today_debut, $today_fin])
            ->count();

        $comm_en_cours = Commande::where('etat', 'en cours')
            ->whereBetween('created_at', [$today_debut, $today_fin])
            ->count();

        $comm_paye = Commande::where('etat', 'payée')
            ->whereBetween('updated_at', [$today_debut, $today_fin])
            ->count();

        $total = Commande::where('etat', 'payée')
            ->whereBetween('updated_at', [$today_debut, $today_fin])
            ->sum('montant');

        $client = Commande::whereBetween('created_at', [$today_debut, $today_fin])
            ->distinct('users_id')
            ->count('users_id');


        return view('admin.dashboard', [
            'users' => $users,
            'commandes' => $commandes,
            'commandes_en_cours' => $commandes_en_cours,
            'commandes_payee' => $commandes_payee,
            'titre' => $titre,
            'nb_inscrit' => $nb_inscrit,
            'comm_en_cours' => $comm_en_cours,
            'comm_paye' => $comm_paye,
            'total' => $total,
            'client' => $client,
        ]);
    }


    public function consultProduit($id){
        $categorie = Categorie::findorFail($id);
        $titre=$categorie->nom;
        $produits = Produit::where('categorie_id', $id)->get();
        return view('admin.produit', compact('produits','titre'));
    }
}
