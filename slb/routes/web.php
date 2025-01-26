<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestCategorie;
use App\Http\Controllers\GestProduit;
use App\Http\Controllers\ajout_panier;
use App\Http\Controllers\GestCommande;
use App\Http\Controllers\welcome;
use App\Http\Controllers\Recu;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\admin_gest_com;
use App\Http\Controllers\Activite_dash;
use App\Http\Controllers\Liste_dash;
use App\Http\Controllers\GestActualite;

Route::get('/', [welcome::class, 'Acceuil'])->name('welcome')->middleware(['admin','compte_supprime']);
Route::get('/produit/{id}', [GestProduit::class, 'consultProduit'])->name('consultProduit');

Route::middleware(['commander','compte_supprime'])->group(function () {
    // Route pour afficher le profil
    Route::get('/profile/{id}', [ProfileController::class, 'monProfil'])->name('monProfil');
    // Route pour ajouter un produit au panier
    Route::post('/ajouter-panier', [ajout_panier::class, 'ajoutPanier'])->name('ajouterPanier');
    // Route pour afficher le panier
    Route::get('/panier', [ajout_panier::class, 'AfficherPanier'])->middleware('panier')->name('panier');
    // Route pour modifier le quantité d'un produit dans le panier
    Route::post('/panier/modifier-quantite/{id}', [ajout_panier::class, 'modifierQte'])->name('modifierQte');
    // Route pour supprimer un produit du panier
    Route::delete('/panier/{id}', [ajout_panier::class, 'RetirerDuPanier'])->name('retirerDuPanier');
    //Route pour créer une commande
    Route::post('/commande', [GestCommande::class, 'creerCommande'])->name('creerCommande');
    //Route pour consulter mes commandes
    Route::get('/mes-commandes/{etat}', [GestCommande::class, 'mesCommandes'])->name('mesCommandes');
    //Route pour telecharger son recu
    Route::get('/mes-commandes/{id}/recu', [Recu::class, 'generer_recu'])->name('telechargerRecu');
    //Suprimer son compte
    Route::put('/compte/supprimer/{id}', [ProfileController::class, 'SupprimerCompte'])->name('supprimerCompte');
    //Activer son compte
    Route::put('/compte/activer/{id}', [ProfileController::class, 'activerCompte'])->name('activerCompte');
});












Route::middleware(['adminAccess'])->group(function () {
    Route::get('/admin/dashboard', [dashboard::class, 'dashboardPage'])->name('admin');
    //faire des recherches par dates sur le dashbord
    Route::post('/admin/activite', [dashboard::class,'dashboardPage'])->name('activite_date');
    //tOUTES LES ACTIVITES
    Route::get('/admin/activite/toutes', [Activite_dash::class, 'toutesActivite'])->name('toutesActivite');
    //Page de recherche par mois
    Route::get('/admin/activite/formulaire/mois', [Activite_dash::class, 'moisActivite'])->name('surLeMois');
    //Activité sur le mois
    Route::post('/admin/activite/mois', [Activite_dash::class, 'moisActivite'])->name('moisActivite');
    //Page de recherche par année
    Route::get('/admin/activite/formulaire/annee', [Activite_dash::class, 'anneeActivite'])->name('surAnnee');
    //Activité sur l'année
    Route::post('/admin/activite/annee', [Activite_dash::class, 'anneeActivite'])->name('anneeActivite');
    //Page de recherche par intervalle de date
    Route::get('/admin/activite/formulaire/intervalle', [Activite_dash::class, 'intervalleActivite'])->name('surIntervalle');
    //Activité sur l'intervalle de date
    Route::post('/admin/activite/intervalle', [Activite_dash::class, 'intervalleActivite'])->name('intervalleActivite');
    //Afficher la page de produits
    Route::get('/admin/produits/{id}', [dashboard::class, 'consultProduit'])->name('consultProduitAdmin');
    //Afficher les détails de la commande
    Route::get('/admin/commande/{id}', [admin_gest_com::class, 'detailCommande'])->name('detailCommandeAdmin');
    //Affcher la page de toutes les commandes
    Route::get('/admin/commandes/{etat?}', [admin_gest_com::class, 'commandePage'])->name('consultCommandeAdmin');
    //Valider la commande
    Route::put('/admin/commande/valider/{id}', [admin_gest_com::class, 'validerCommande'])->name('validerCommande');
    //Retourner la recherche de commande
    Route::get('/admin/commande/recherche/{etat?}', [admin_gest_com::class, 'rechercherCommande'])->name('rechercherCommande');
    //Retourner la page d'ajout de produits
    Route::get('/admin/ajouter/produits', [GestCategorie::class, 'consultCategorie'])->name('formProduit');
    //Modifier un produit (formulaire)
    Route::get('/admin/modifier/produit/{id}', [GestProduit::class, 'editProduit'])->name('editProduit');
    //Modifier un produit
    Route::put('/admin/produit/{id}/edit', [GestProduit::class, 'updateProduit'])->name('updateProduit');
    //Supprimer un produit
    Route::delete('/admin/produit/{id}/delete', [GestProduit::class, 'deleteProduit'])->name('deleteProduit');
    //Controlleurs pour afficher tous les produits
    Route::get('/admin/produits', [GestProduit::class, 'tousProduits'])->name('tousProduits');
    //Formulaire de catégorie
    Route::get('/admin/ajouter/catégories', [GestCategorie::class, 'formCategorie'])->name('formCategorie');
    //Controlleurs pour save une catégorie
    Route::post('/admin/catégorie/ajouter', [GestCategorie::class, 'storeCategorie'])->name('storeCategorie');
    //Consulter les catégories
    Route::get('/admin/catégorie/consulter', [GestCategorie::class, 'consultCategorie'])->name('consultCategorie');
    //Retourner la page de modification des catégorie
    Route::get('/admin/catégorie/modifier/{id}', [GestCategorie::class, 'editCategorie'])->name('editCategorie');
    //supprimer une catégorie
    Route::delete('/admin/catégorie/supprimer/{id}', [GestCategorie::class, 'deleteCategorie'])->name('deleteCategorie');
    //Controler et enrégistrer les modifications des catégories
    Route::put('/admin/modifier/catégorie/{id}', [GestCategorie::class, 'updateCategorie'])->name('updateCategorie');
    //Controlleurs pour save un produit
    Route::post('/admin/produit/ajouter', [GestProduit::class, 'storeProduit'])->name('storeProduit');
    //liste de tous les inscrits
    Route::get('/admin/inscrits', [Liste_dash::class, 'List_Inscrit'])->name('listeInscrits');
    //Liste des clients
    Route::get('/admin/clients', [Liste_dash::class, 'List_Client'])->name('listeClients');
    //Liste des commandes par client
    Route::get('/admin/commandes/client/{id}', [Liste_dash::class, 'commandesClient'])->name('commandesClient');
    //Formulaire d'actualite
    Route::get('/admin/actualite', [GestActualite::class, 'formActualite'])->name('formActualite');
    //Controlleurs pour save une actualite
    Route::post('/admin/actualite/ajouter', [GestActualite::class,'storeActualite'])->name('storeActualite');
    //Consulter les actualites
    Route::get('/admin/actualite/consulter', [GestActualite::class, 'tousActualite'])->name('tousActualite');
    //Retourner la page de modification des actualites
    Route::get('/admin/actualite/modifier/{id}', [GestActualite::class, 'editActualite'])->name('editActualite');
    //Controler et enrégistrer les modifications des actualites
    Route::put('/admin/actualite/{id}/modifier', [GestActualite::class, 'updateActualite'])->name('updateActualite');
    //supprimer une actualite
    Route::put('/admin/actualite/supprimer/{id}', [GestActualite::class, 'deleteActualite'])->name('deleteActualite');
    //liste afficher une actualite caché
    Route::put('/admin/actualite/afficher/{id}', [GestActualite::class, 'afficherActualite'])->name('afficherActualite');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
