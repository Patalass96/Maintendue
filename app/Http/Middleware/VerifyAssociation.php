<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyAssociation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Vérifier si l'utilisateur est connecté
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        // 2. Vérifier si l'utilisateur a le rôle 'association'
        if ($user->role !== 'association') {
            abort(403, 'Accès réservé aux associations.');
        }

        // 3. Vérifier si le compte est actif
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Votre compte association a été désactivé.');
        }

        // 4. Vérifier si l'association a un profil
        if (!$user->association) {
            return redirect()->route('associations.complete-profile')
                ->with('warning', 'Veuillez compléter votre profil association pour continuer.');
        }

        // 5. Vérifier le statut de vérification
        $association = $user->association;
        
        switch ($association->verification_status) {
            case 'pending':
                return redirect()->route('associations.complete-profile')
                    ->with('info', 'Votre association est en attente de validation. Vous recevrez un email une fois validée.');
            
            case 'rejected':
                return redirect()->route('associations.complete-profile')
                    ->with('error', 'Votre association a été rejetée. Contactez l\'administration pour plus d\'informations.');
            
            case 'verified':
                // Tout est bon, continuer
                return $next($request);
            
            default:
                return redirect()->route('associations.complete-profile')
                    ->with('error', 'Statut de vérification inconnu.');
        }
    }
}
// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

// use Illuminate\Support\Facades\Auth;

// class VerifyAssociiation
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//   public function handle(Request $request, Closure $next): Response 
//  {

//     $user = auth()->user();

//     if (!$user) {
//         return redirect()->route('login')
//         ->with('error', 'Veuillez vous connecter pour accéder à cette page.');
//     }

//     // On utilise 'is_active' ou 'is_verified' selon ce qu'on a mis dans le modèle
//     if ($user->role === 'association' && !$user->is_verified) {
//         return redirect('/association/complete-profile')
//                ->with('error', 'Votre compte association est en attente de validation.');
//     }
        
//     return $next($request);
// }
// }
