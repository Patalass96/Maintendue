<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Où rediriger après la connexion si la méthode authenticated n'est pas utilisée.
     */
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Logique de redirection personnalisée après connexion réussie.
     */
    protected function authenticated(Request $request, $user)
    {
        // Vérifier si le compte est actif
        if (!$user->is_active) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
            ]);
        }

        // Redirection selon le rôle
        switch ($user->role) {
            case 'admin':
                // Pour les admins, pas de vérification is_verified nécessaire
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Bienvenue Administrateur !');

            case 'association':
                // Vérifier si l'association a un profil
                if (!$user->association) {
                    return redirect()->route('associations.complete-profile')
                        ->with('info', 'Complétez votre profil association pour commencer.');
                }

                // Vérifier le statut de vérification manuelle
                $association = $user->association;
                if ($association->verification_status !== 'verified') {
                    return redirect()->route('associations.complete-profile')
                        ->with('warning', 'Votre association est en attente de validation par nos administrateurs.');
                }

                return redirect()->route('associations.dashboard')
                    ->with('success', 'Bienvenue Association !');

            case 'donateur':
                // Les donateurs se connectent directement
                return redirect()->route('user.dashboard')
                    ->with('success', 'Bienvenue Donateur !');

            default:
                // Fallback
                return redirect()->route('home')
                    ->with('success', 'Bienvenue !');
        }
    }

    /**
     * Personnaliser les messages d'erreur
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => 'Identifiants incorrects ou compte inactif.',
        ]);
    }

    /**
     * Redirection après déconnexion
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('home')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}