<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GestProduit extends Controller
{
   public function storeProduit(Request $request){
     $request->validate([
        'categorie'=>'required',
        'nom' => ['required', 'string', 'max:30', 'unique:produit,nom'],
        'prix' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:1',
        'qte_stock' =>'required|integer|min:0',
        'image' =>'required|image|mimes:jpeg,png,jpg,gif|max:1024|dimensions:min_width=100,min_height=100,max_width=300,max_height=300',
        'description' =>'max:100',
     ],
    [
        'categorie.required' => 'La catégorie est obligatoire.',
        'nom.required' => 'Le nom est obligatoire.',
        'nom.string' => 'Le nom doit être une chaîne de caractères.',
        'nom.max' => 'Le nom ne doit pas dépasser 30 caractères.',
        'nom.unique' => 'Ce nom de produit existe déjà.',
        'prix.required' => 'Le prix est obligatoire.',
        'prix.regex' => 'Le prix doit être un nombre réel.',
        'prix.min' => 'Le prix doit être supérieur ou égal à 1.',
        'qte_stock.required' => 'La quantité en stock est obligatoire.',
        'qte_stock.integer' => 'La quantité en stock doit être un nombre entier.',
        'qte_stock.min' => 'La quantité en stock doit être supérieur ou égal à 0.',
        'image.required' => 'L\'image est obligatoire.',
        'image.image' => 'Le fichier doit être une image.',
        'image.mimes' => 'Le format de l\'image doit être jpeg, png, jpg, gif.',
        'image.max' => 'La taille de l\'image doit être inférieure à 1Mo.',
        'image.dimensions' => 'L\'image doit avoir une largeur minimum de 100px et une hauteur minimum de 100px, une largeur maximum de 300px et une hauteur maximum de 300px.',
        'description.string' => 'La description doit être une chaîne de caractères.',
    ]);

    $produit = new Produit();
    $imagepath= $request->file('image')->store('images','public');
    $produit->categorie_id = $request->categorie;
    $produit->nom = $request->nom;
    $produit->prix = $request->prix;
    $produit->qte_stock = $request->qte_stock;
    $produit->image = $imagepath;
    $produit->description = $request->description;
    $produit->save();
    return redirect()->route('formProduit')->with('success', 'Produit enrégistré avec succès.');

   }

   public function consultProduit($id){

    $produits = Produit::where('categorie_id', $id)->get();
    $panier = session()->get('panier', []);

    // Vérifier si l'utilisateur est connecté
    if (Auth::check()) {
        $userId = Auth::user()->id;
        // Récupérer la commande de l'utilisateur connecté
        $commande = Commande::where('users_id', $userId)->first();
        // Vérifier si le panier de l'utilisateur est non vide
        $verification = isset($panier[$userId]) && !empty($panier[$userId]);
    } else {
        $userId = null;
        $commande = null;
        $verification = false;
    }

    // Récupérer les catégories
    $categories = Categorie::all();
    $categorie_name = Categorie::findOrFail($id);
   
    
    // Vérifier si la collection est vide
    if ($produits->isEmpty()) {
        return redirect()->route('welcome')->with('error', 'Aucun produit trouvé correspondant à la catégorie.');
    }
    // Passer les produits à la vue si la collection n'est pas vide
    return view('user.produit', ['produits'=> $produits,'categories'=> $categories,'categorie_name'=> $categorie_name, 'commande'=> $commande,'verification'=> $verification]);
}
 
public function tousProduits(){
    $produits = Produit::all();
    $titre='Tous les produits';
    return view('admin.produit', compact('produits','titre'));
}

public function editProduit($id){
    $produits = Produit::find($id);
    $categories = Categorie::all();
    return view('admin.produitAddPage', compact('produits','categories'));
}

public function updateProduit(Request $request, $id)
{
    $request->validate([
        'categorie'=>'required',
        'nom' => ['required', 'string', 'max:30'],
        'prix' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:1',
        'qte_stock' =>'required|integer|min:0',
        'image' =>'image|mimes:jpeg,png,jpg,gif|max:1024|dimensions:min_width=100,min_height=100,max_width=300,max_height=300',
        'description' =>'max:100',
     ],
    [
        'categorie.required' => 'La catégorie est obligatoire.',
        'nom.required' => 'Le nom est obligatoire.',
        'nom.string' => 'Le nom doit être une chaîne de caractères.',
        'nom.max' => 'Le nom ne doit pas dépasser 30 caractères.',
        'prix.required' => 'Le prix est obligatoire.',
        'prix.regex' => 'Le prix doit être un nombre réel.',
        'prix.min' => 'Le prix doit être supérieur ou égal à 1.',
        'qte_stock.required' => 'La quantité en stock est obligatoire.',
        'qte_stock.integer' => 'La quantité en stock doit être un nombre entier.',
        'qte_stock.min' => 'La quantité en stock doit être supérieur ou égal à 0.',
        'image.image' => 'Le fichier doit être une image.',
        'image.mimes' => 'Le format de l\'image doit être jpeg, png, jpg, gif.',
        'image.max' => 'La taille de l\'image doit être inférieure à 1Mo.',
        'image.dimensions' => 'L\'image doit avoir une largeur minimum de 100px et une hauteur minimum de 100px, une largeur maximum de 300px et une hauteur maximum de 300px.',
        'description.string' => 'La description doit être une chaîne de caractères.',
    ]);

    $produit = Produit::find($id);
    $produit->categorie_id = $request->categorie;
    $produit->nom = $request->nom;
    $produit->prix = $request->prix;
    $produit->qte_stock = $request->qte_stock;
    $produit->description = $request->description;
    if ($request->hasFile('image')) {
        // Supprimer l'ancienne image du stockage si elle existe
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }
        $imagepath = $request->file('image')->store('images', 'public');
        $produit->image = $imagepath;
    }
    $produit->save();
    return redirect()->route('tousProduits')->with('success', 'Produit modifié avec succès.');
}
    public function deleteProduit($id){
        $produit = Produit::find($id);
        // Supprimer l'image du stockage si elle existe
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }
        $produit->delete();
        return redirect()->back()->with('success', 'Produit supprimé avec succès.');
    }
}
