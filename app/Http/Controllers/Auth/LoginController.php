<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    
    /**
     * Affiche le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.authentificate');
    }

    /**
     * Traite la tentative de connexion
     */
    public function login(Request $request)
    {
        // 1. Validation des données
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Tentative de connexion (Auth)
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 3. Vérification si le compte est actif (colonne is_active dans ton modèle)
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Votre compte est suspendu.']);
            }

            // 4. Redirection intelligente basée sur Les constantes de Rôle
            return $this->authentifcated($request, $user);
        }

        // Si échec
        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * Redirection selon le rôle (MVC Logic)
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isAssociation()) {
            return redirect()->route('association.dashboard');
        }

        // Par défaut pour les donateurs
        return redirect()->intended('/home');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

