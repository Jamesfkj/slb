<?php
namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Article_commandee;
use App\Models\Produit;
use Carbon\Carbon;

class admin_gest_com extends Controller
{
    public function commandePage($etat = null)
    {
        $query = Commande::query();

        if (in_array($etat, ['en cours', 'payée'])) {
            $query->where('etat', $etat);
            $titre = 'Commandes : ' . $etat;
            $placeholder='Rechercher une commande ' . $etat. '...';
        } else {
            $titre = 'Toutes les commandes';
            $query->whereNotNull('etat');
            $placeholder='Rechercher une commande ...';
        }

        $commandes = $query->paginate(5);

        return view('admin.commande', compact('commandes', 'titre', 'etat', 'placeholder'));
    }

    public function rechercherCommande(Request $request, $etat = null) {
        // Validation de l'entrée
        $request->validate([
            'query' => 'required|string',
        ], [
            'query.required' => 'Veuillez saisir un numéro de commande',
            'query.string' => 'Le numéro de commande doit être une chaîne de caractères',
        ]);
    
        // Construction de la requête
        $query = Commande::query();
    
        
        if (in_array($etat, ['en cours', 'payée'])){
            $query->where('etat', $etat);
            $placeholder='Rechercher une commande ' . $etat. '...';       
        }else{
            $query->whereNotNull('etat');
            $placeholder='Rechercher une commande ...';
        }
    
        // Rechercher la commande avec le numéro donné
        $commandes = $query->where('numero_commande', $request->input('query'))->first(); 
    
        // Vérifiez si la commande existe
        if ($commandes) {
            $titre = $etat ? 'Commande ' . $commandes->numero_commande : 'Commande : ' . $commandes->numero_commande;
            return view('admin.recherche_commande', compact('commandes', 'titre', 'etat','placeholder'));
        } else {
            return redirect()->back()->with('error', 'Commande non trouvée');
        }
    }
    
    public function GererQuantité($id){
        $articles = Article_commandee::where('commande_id', $id)->get(); 
        foreach ($articles as $article) {
            $produit = Produit::where('id', $article->produit_id)->first();
            if ($produit) { // Assurez-vous que le produit existe
                $produit->qte_stock -= $article->qte_commande;
                $produit->save();
            }
        }
    }
    
    public function validerCommande($id, Request $request)
    {
        $commande = Commande::findOrFail($id);
        $numeroCommande = $commande->numero_commande;
    
        $etat = $request->input('etat');
        $commande->etat = $etat;
        $commande->save();
    
        if ($etat === 'payée') {
            $this->GererQuantité($id); 
        }
    
        return redirect()->route('rechercherCommande', ['query' => $numeroCommande, 'etat' => 'payée'])
            ->with('success', 'Commande validée avec succès');
    }
    

    public function detailCommande($id){
        $commande = Commande::findOrFail($id);
        $userId=$commande->users_id;
        $user=User::find($userId);

        $dateStr = $user->date_naiss;
        // Convertir la chaîne en objet Carbon
        $dateObj = Carbon::createFromFormat('Y-m-d', $dateStr);
        // Convertir l'objet Carbon au nouveau format
        $newDateStr = $dateObj->format('d/m/Y');


        $articlesCommandes = Article_commandee::with('produit')
            ->where('commande_id', $commande->id)
            ->get();
        return view('admin.detail_commande', compact('commande', 'user', 'articlesCommandes','newDateStr'));
    }
}



