<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Commande;

class Liste_dash extends Controller
{
    public function List_Inscrit()
    {
        $users = User::whereIn('user_type', ['user','désactivé'])->paginate(6, ['*'], 'page_users');
        return view('admin.List_Inscrit', compact('users'));
    }

    public function List_Client()
    {
        // Obtenir les utilisateurs avec au moins une commande
        $users = User::whereIn('user_type', ['user', 'désactivé'])
            ->join('commande', 'utilisateur.id', '=', 'commande.users_id') // Jointure interne pour inclure uniquement ceux qui ont des commandes
            ->select('utilisateur.id', 'utilisateur.name', 'utilisateur.email', 'utilisateur.telephone', 'utilisateur.created_at')
            ->selectRaw('COUNT(commande.id) as command_count') // Compter les commandes
            ->groupBy('utilisateur.id', 'utilisateur.name', 'utilisateur.email', 'utilisateur.telephone', 'utilisateur.created_at')
            ->paginate(6, ['*'], 'page_users'); // Pagination
        return view('admin.List_client', compact('users'));
    }
    
    public function commandesClient($id){
        $user=User::findOrFail($id);
        $titre='Nom du client : '.$user->name;
        $commandes= Commande::where('users_id',$id)->paginate(6);
        return view('admin.commandesClient', compact('commandes','titre'));
    }

}
