<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Commande;
use IntlDateFormatter;
use DateTime;
use Carbon\Carbon;

class Activite_dash extends Controller
{
    public function toutesActivite()
    {
        $titre = "Toutes les activites";
        $users = User::where('user_type', 'user')->latest('created_at')
            ->limit(3)
            ->get();
        ;
        $commandes = Commande::count();
        $commandes_en_cours = Commande::latest('created_at')
            ->limit(3)
            ->get();
        $commandes_payee = Commande::where('etat', 'payee')->latest('updated_at')->limit(3)->get();
        $nb_inscrit = User::where('user_type', 'user')->count();
        $comm_en_cours = Commande::where('etat', 'en cours')->count();
        $comm_paye = Commande::where('etat', 'payée')->count();
        $total = Commande::where('etat', 'payée')->sum('montant');
        $client = Commande::distinct('users_id')->count();

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

    public function moisActivite(Request $request)
    {
        // Si aucune année et aucun mois ne sont soumis, on utilise l'année et le mois en cours
        $annee = $request->input('annee', date('Y'));
        $mois = $request->input('mois', date('m'));

        // Validation des entrées si elles sont soumises


        // Calcul des dates de début et de fin du mois
        $date_debut = Carbon::create($annee, $mois, 1)->startOfMonth();
        $date_fin = Carbon::create($annee, $mois, 1)->endOfMonth();

        // Récupération du nom du mois en français
        $formatter = new IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            null,
            null,
            'MMMM'
        );
        $nom_du_mois = $formatter->format(DateTime::createFromFormat('!m', $mois));

        // Définition du titre
        $titre = "Activités du mois de $nom_du_mois $annee";

        // Requêtes pour récupérer les données en fonction du mois
        $users = User::where('user_type', 'user')
            ->whereBetween('created_at', [$date_debut, $date_fin])->latest('created_at')
            ->limit(3)
            ->get();
        ;

        $commandes_en_cours = Commande::whereBetween('created_at', [$date_debut, $date_fin])->latest('created_at')
            ->limit(3)
            ->get();

        $commandes_payee = Commande::where('etat', 'payée')
            ->whereBetween('updated_at', [$date_debut, $date_fin])->latest('updated_at')
            ->limit(3)
            ->get();

        $nb_inscrit = User::where('user_type', 'user')
            ->whereBetween('created_at', [$date_debut, $date_fin])
            ->count();

        $commandes = Commande::whereBetween('created_at', [$date_debut, $date_fin])
            ->count();

        $comm_en_cours = Commande::where('etat', 'en cours')
            ->whereBetween('created_at', [$date_debut, $date_fin])
            ->count();

        $comm_paye = Commande::where('etat', 'payée')
            ->whereBetween('updated_at', [$date_debut, $date_fin])
            ->count();

        $total = Commande::where('etat', 'payée')
            ->whereBetween('updated_at', [$date_debut, $date_fin])
            ->sum('montant');

        $client = Commande::whereBetween('created_at', [$date_debut, $date_fin])
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

    public function anneeActivite(Request $request)
    {
        if ($request->filled('annee')) {
            $year = $request->input('annee');
            $startOfYear = Carbon::create($year, 1, 1)->startOfDay();
            $endOfYear = Carbon::create($year, 12, 31)->endOfDay();
            $titre = "Actiité de l'année " . $year;
        } else {
            $startOfYear = Carbon::now()->startOfYear();
            $endOfYear = Carbon::now()->endOfYear();
            $titre = "Année en cours";
        }

        $users = User::where('user_type', 'user')
            ->whereBetween('created_at', [$startOfYear, $endOfYear])->latest('created_at')
            ->limit(3)
            ->get();

        $commandes = Commande::whereBetween('created_at', [$startOfYear, $endOfYear])->count();

        $commandes_en_cours = Commande::whereBetween('created_at', [$startOfYear, $endOfYear])
            ->latest('created_at')
            ->limit(3)
            ->get();

        $commandes_payee = Commande::where('etat', 'payée')
            ->whereBetween('updated_at', [$startOfYear, $endOfYear])
            ->latest('updated_at')
            ->limit(3)
            ->get();

        $nb_inscrit = User::where('user_type', 'user')
            ->whereBetween('created_at', [$startOfYear, $endOfYear])
            ->count();

        $comm_en_cours = Commande::where('etat', 'en cours')
            ->whereBetween('created_at', [$startOfYear, $endOfYear])
            ->count();

        $comm_paye = Commande::where('etat', 'payée')
            ->whereBetween('updated_at', [$startOfYear, $endOfYear])
            ->count();

        $total = Commande::where('etat', 'payée')
            ->whereBetween('updated_at', [$startOfYear, $endOfYear])
            ->sum('montant');

        $client = Commande::whereBetween('created_at', [$startOfYear, $endOfYear])
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

    public function intervalleActivite(Request $request)
    {
        $dateDebut = $request->input('annee1');
        $dateFin = $request->input('annee2');

        //  utiliser les dates d'aujourd'hui si vide
        if (is_null($dateDebut) && is_null($dateFin)) {
            $dateDebut = Carbon::now()->startOfDay();
            $dateFin = Carbon::now()->endOfDay();
            $titre = "Activité d'aujourd'hui";
        } else {
            // Convertir les dates en objets Carbon
            $dateDebut = Carbon::parse($dateDebut)->startOfDay();
            $dateFin = Carbon::parse($dateFin)->endOfDay();
            $titre = "Activité entre le " . $dateDebut->format('d/m/Y') . " et le " . $dateFin->format('d/m/Y');
        }

        // Vérifier si la date de fin est postérieure à la date de début
        if ($dateDebut->gt($dateFin)) {
            return redirect()->back()->withErrors(['error' => 'La date de fin doit être postérieure à la date de début.']);
        }

        $users = User::where('user_type', 'user')
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->latest('created_at')
            ->limit(3)
            ->get();

        $commandes_en_cours = Commande::whereBetween('created_at', [$dateDebut, $dateFin])->latest('created_at')
            ->limit(3)
            ->get();
        $commandes_payee = Commande::whereBetween('updated_at', [$dateDebut, $dateFin])
            ->where('etat', 'payée')
            ->latest('updated_at')
            ->limit(3)
            ->get();

        $nb_inscrit = User::where('user_type', 'user')
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->count();

        $commandes = Commande::whereBetween('created_at', [$dateDebut, $dateFin])->count();

        $comm_en_cours = Commande::where('etat', 'en cours')
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->count();

        $comm_paye = Commande::where('etat', 'payée')
            ->whereBetween('updated_at', [$dateDebut, $dateFin])
            ->count();

        $total = Commande::where('etat', 'payée')
            ->whereBetween('updated_at', [$dateDebut, $dateFin])
            ->sum('montant');

        $client = Commande::whereBetween('created_at', [$dateDebut, $dateFin])
            ->distinct('users_id')
            ->count('users_id');

        // Formatage du titre avec la plage de dates
        $formatter = new IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            null,
            null,
            'MMMM yyyy'
        );
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


}
