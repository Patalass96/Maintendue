<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    /**
     * Affiche le tableau de bord principal de l'administrateur.
     */
    public function index()
    {
        // Compter les utilisateurs selon les rôles
        $totalUsers = User::where('role', User::ROLE_DONATOR)->count();
        $totalAssociationsCount = User::where('role', User::ROLE_ASSOCIATION)->count();
        $totalDonations = \App\Models\Donation::count();

        // Compter les associations vérifiées
        $totalAssociations = Association::count();

        $totalDonations = Donation::count();

        // Récupérer les associations en attente de validation
        $pendingAssociations = Association::where('verification_status', "pending")
            ->with('manager')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalAssociations' => $totalAssociations, // Variable corrigée
            'totalDonations' => $totalDonations,
            'pendingAssociations' => $pendingAssociations
        ]);
    }

    /**
     * Méthode pour valider une association
     */
    public function validateAssociation($id)
    {
        $association = Association::findOrFail($id);
        $association->update(['verification_status' => "verified"]);


        // Activer également l'utilisateur manager si nécessaire
        if ($association->manager) {
            $association->manager->update(['is_active' => true]);
        }

        return back()->with('success', "L'association {$association->name} a été validée avec succès.");
    }

    /**
     * Méthode pour rejeter/suspendre un utilisateur(Action du bouton "Rejeter")
     */
    public function rejectUser($id)
    {
        $association = Association::findOrFail($id);
        $association->update(['verification_status' => "rejected"]);

        return back()->with('error', "L'accès pour {$association->name} a été refusé.");
    }

    /**
     * Affiche la vue de validation des associations
     */
    public function validateAssociations()
    {
        $associations = Association::where('verification_status', 'pending')
        ->with('manager')
        ->latest()
        ->paginate(10);
        return view('admin.validateAssociation', compact('associations'));
    }
    

    // === GESTION DES UTILISATEURS ===

    public function users()
    {
        $users = User::with('association')->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function show($id)
    {
        $user = User::with('association')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|numeric',
            'firstname' => 'required|string|max:255'
        ]);

        $user->update($request->all());
        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour');
    }

    public function destroy(User $user)
    {
        // Vérifier si l'utilisateur a des données associées avant suppression
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé');
    }

    public function suspend($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => false]);
        return back()->with('success', 'Utilisateur suspendu avec succès');
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => true]);
        return back()->with('success', 'Utilisateur activé avec succès');
    }

    public function promote($id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => 'admin']);
        return back()->with('success', 'Utilisateur promu administrateur');
    }

    // === AUTRES VUES ADMIN ===

    public function moderation()
    {
        return view('admin.moderation');
    }

    public function reports()
    {
        return view('admin.reports');
    }

    public function associations()
    {
        $associations = Association::with('manager')->latest()->get();
        return view('admin.associations', compact('associations'));
    }

    public function statistique()
    {
        // Ajoutez des statistiques ici si nécessaire
        return view('admin.statistique');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
