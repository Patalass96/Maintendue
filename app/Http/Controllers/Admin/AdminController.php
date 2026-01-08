<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;



class AdminController extends Controller
{
    /**
     * Affiche le tableau de bord principal de l'administrateur.
     */
    public function index()
    {


        // 1. Compter les utilisateurs selon les rôles définis dans ton modèle User
        // On utilise les constantes ROLE_DONATOR et ROLE_ASSOCIATION pour éviter les erreurs de frappe
        $totalUsers = User::where('role', User::ROLE_DONATOR)->count();
        $totalAssociations = User::where('role', User::ROLE_ASSOCIATION)->where('is_active', true)->count();

        // 2. Récupérer les associations en attente de validation
        // Ce sont celles avec le rôle association mais is_active à false (par défaut dans ta migration)
        $pendingAssociations = User::where('role', User::ROLE_ASSOCIATION)
            ->where('is_active', false)
            ->latest()
            ->take(5)
            ->get();

        // 3. (Optionnel) Statistiques pour les graphiques
        // Ici on pourrait calculer les dons par catégorie si tu avais déjà la table Donations

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAssociations',
            'pendingAssociations'
        ));
    }

    /**
     * Méthode pour valider une association (Action du bouton "Valider")
     */
    public function validateAssociation($id)
    {

        $user = User::findOrFail($id);
        $user->update(['is_active' => true]);

        return back()->with('success', "L'association {$user->name} a été validée avec succès.");
    }

    /**
     * Méthode pour rejeter/suspendre un utilisateur (Action du bouton "Rejeter")
     */
    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        // Pour un rejet définitif, tu pourrais utiliser $user->delete() 
        // ou simplement le laisser inactif
        $user->update(['is_active' => false]);

        return back()->with('error', "L'accès pour {$user->name} a été refusé.");
    }

    // public function handleValidation($id = null)
    // {
    //     if (request()->isMethod('GET')) {
    //         // Afficher la liste des associations à valider
    //         $associations = association::where('status', 'pending')->get();
    //         return view('admin.validate-form', compact('associations'));
    //     }

    //     // Traitement POST
    //     $association = Association::findOrFail($id);
    //     $association->update(['status' => 'validated']);
    //     return redirect()->back()->with('success', 'Association validée !');
    // }


    /**
     * Affiche la liste des utilisateurs (Vue Admin)
     */
    public function users()
    {
        $users = User::all(); // Ou votre logique pour récupérer les utilisateurs
        return view('admin.users', compact('users'));
    }

    /**
     * Affiche les paramètres administratifs (Vue Admin)
     */
    public function moderation()
    {
        // Logique pour afficher les paramètres
        return view('admin.moderation');
    }


    public function reports()
    {
        // Logique pour afficher les paramètres
        return view('admin.reports');
    }
    public function associations()
    {
        // Logique pour afficher les paramètres
        return view('admin.associations');
    }


    // public functio  n validateAssociation()
    //     {
    //         // Logique pour afficher les paramètres
    //         return view('admin.validateAssociation');




    public function statistique()
    {
        // Logique pour afficher les paramètres
        return view('admin.statistique');
    }


    public function settings()
    {
        // Logique pour afficher les paramètres
        return view('admin.settings');
    }
}
