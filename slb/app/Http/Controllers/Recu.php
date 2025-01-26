<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\Article_commandee;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;



class Recu extends Controller
{
    public function generer_recu($id){
        $commande= Commande::findOrFail($id);
        $userId = $commande->users_id;
        $user = User::findOrFail($userId);
        // Vérifier que la commande existe
        $commande = Commande::where('id', $id)->first();
        if (!$commande) {
            abort(404, 'Commande non trouvée');
        }
    
        // Vérifier que les articles associés à la commande existent
        $articles = Article_commandee::where('commande_id', $id)->get();
        if ($articles->isEmpty()) {
            abort(404, 'Aucun article trouvé pour cette commande');
        }
    
        // Récupérer les IDs des produits
        $liste = $articles->pluck('produit_id');
    
        // Récupérer les produits associés à ces IDs
        $produits = Produit::whereIn('id', $liste)->get();
    
        $pdf = Pdf::loadView('user.reçu', [
            'user' => $user,
            'commande' => $commande,
            'produits' => $produits,  
            'articles' => $articles,
        ]);
    
        // Retourner le PDF en téléchargement
        return $pdf->download('reçu.pdf');
    }
    
}
