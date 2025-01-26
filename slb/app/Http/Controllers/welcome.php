<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use Illuminate\Support\Facades\Auth;
use App\Models\Commande;
use App\Models\Actualite;

class welcome extends Controller
{
    public function Acceuil(){
        $categories = Categorie::all();
        $actualites = Actualite::where('etat','visible')->get();
        if(Auth::check()){
            $user=Auth::user();
            $userId=$user->id;
            //Vérifier si l'utilisateur a une commande
            $commande=Commande::where('users_id',$user->id)->first();
            //Vérifier si l'utilisateur a un panier en session
            $panier=session()->get('panier',[]);
            $verification=isset($panier[$userId]) && !empty($panier[$userId]);
            return view('user.welcome', compact('categories','commande','verification', 'actualites'));
        }else{
            return view('user.welcome', compact('categories','actualites'));
        }
    }
}
