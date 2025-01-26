<?php

namespace App\Http\Controllers;

use Illuminate\Console\View\Components\Component;
use Illuminate\Http\Request;
use App\Models\Categorie;
use Illuminate\Support\Facades\Route;

class GestCategorie extends Controller
{
    public function formCategorie(){
        return view('admin.addCatégorie');
    }

    public function categoriePage(){
        return view('user.categoriePage');
    }

    public function storeCategorie(Request $request){
         $request->validate(
            [
                'nom' => ['required', 'string', 'max:30', 'regex:/^[a-zA-ZàâäéèêëîÉïôöùûüÿç\'\s]*$/','unique:categorie,nom'],
                'description' => 'required|string|max:100',
            ],
            [
                'nom.required' => 'Veuillez saisir le nom de la catégorie',
                'nom.string' => 'Le nom de la catégorie doit être une chaîne de caractères',
                'nom.max' => 'Le nom de la catégorie ne doit pas dépasser 30 caractères',
                'nom.regex' => 'Le nom de la catégorie ne doit contenir que des lettres et des espaces',
                'description.required' => 'Veuillez saisir une description de la catégorie',
                'description.string' => 'La description de la catégorie doit être une chaîne de caractères',
                'description.max' => 'La description de la catégorie ne doit pas dépasser 100 caractères',
                'nom.unique' => 'Ce nom de catégorie existe déjà.',
            ]
        );
        // Enregistrement de la catégorie dans la base de données
        $categorie = new Categorie();
        $categorie->nom = $request->input('nom');
        $categorie->description = $request->input('description');
        $categorie->save();
        return redirect()->route('formCategorie')->with('success','Catégorie enregistrée avec succès');
    }
    public function consultCategorie(){
        $categories = Categorie::all();
        if(request()->is('admin/catégorie/consulter'))
            return view('admin.consultCategorie', compact('categories'));
        elseif(request()->is('admin/ajouter/produits'))
            return view('admin.produitAddPage', compact('categories'));
        elseif(request()->is('panier'))
            return view('user.panier', compact('categories'));
    }

    public function deleteCategorie($id){
        $delete = Categorie::destroy($id);
        if($delete){
            return redirect()->route('consultCategorie')->with('message','Catégorie supprimée avec succès');
        }else{
            return redirect()->route('consultCategorie')->with('error','Une erreur est survenue lors de la suppression');
        }
    }
// Retourner la page de modification de la catégorie
    public function editCategorie($id){
        $categories = Categorie::findorFail($id);
        return view('admin.addCatégorie', compact('categories'));
    }
//Pour enregistrer et controller les modifications
    public function updateCategorie(Request $request, $id){
        $categorie = Categorie::findOrFail($id);
        $request->validate(
            [
                'nom' => ['required', 'string', 'max:30', 'regex:/^[a-zA-ZàâäéèêëîïôÉöùûüÿç\'\s]*$/', 'unique:categorie,nom'],
                'description' => 'required|string|max:100',
            ],
            [
                'nom.required' => 'Veuillez saisir le nom de la catégorie',
                'nom.string' => 'Le nom de la catégorie doit être une chaîne de caractères',
                'nom.unique' => 'Ce nom de catégorie existe déjà.',
                'nom.max' => 'Le nom de la catégorie ne doit pas dépasser 30 caractères',
                'nom.regex' => 'Le nom de la catégorie ne doit contenir que des lettres et des espaces',
                'description.required' => 'Veuillez saisir une description de la catégorie',
                'description.string' => 'La description de la catégorie doit être une chaîne de caractères',
                'description.max' => 'La description de la catégorie ne doit pas dépasser 100 caractères',
            ]
        );
        $categorie->nom = $request->input('nom');
        $categorie->description = $request->input('description');
        $categorie->save();
        return redirect()->route('consultCategorie')->with('message','Catégorie modifiée avec succès');
    }
}
