<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actualite;

class GestActualite extends Controller
{
    public function formActualite(){
        return view('admin.formActualite');
    }

    public function storeActualite(Request $request){
        $request->validate([
            'titre' =>'required|string|max:255',
            'contenu' =>'required|string',
        ]);
        // Enregistrement des données dans la base de données
        $actualite = new Actualite();
        $actualite->titre = $request->input('titre');
        $actualite->contenu = $request->input('contenu');
        $actualite->save();
        return redirect()->back()->with('success', 'Actualité publier avec succèes');
    }

    public function deleteActualite($id){
        $actualite=Actualite::findOrFail($id);
        $actualite->etat='caché';
        $actualite->save();
        return redirect()->back()->with('success', 'Actualité retirée avec succès');
    }

    public function tousActualite(){
        $actualites = Actualite::all();
        return view('admin.showActualite', compact('actualites'));
    }

    public function editActualite($id){
        $actualite = Actualite::find($id);
        return view('admin.formActualite', compact('actualite'));
    }

    public function afficherActualite($id){
        $actualite=Actualite::findOrFail($id);
        $actualite->etat='visible';
        $actualite->save();
        return redirect()->back()->with('success', 'Actualité publiée avec succès');
    }

    public function updateActualite(Request $request, $id){
        $request->validate([
            'titre' =>'required|string|max:255',
            'contenu' =>'required|string',
        ]);
        // Mettre à jour les données dans la base de données
        $actualite = Actualite::find($id);
        $actualite->titre = $request->input('titre');
        $actualite->contenu = $request->input('contenu');
        $actualite->save();
        return redirect()->route('tousActualite')->with('success', 'Actualité modifiée avec succès');
    }
}
