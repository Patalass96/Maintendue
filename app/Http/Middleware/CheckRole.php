<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  \Closure  $next
     * @param  string  $role  <-- On ajoute ce paramètre pour recevoir le rôle depuis web.php
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Vérifier si l'utilisateur est bien connecté
        if (!Auth::check()) {
            return redirect()->route('login');
       }
        
       // 2. Vérifier si le rôle de l'utilisateur correspond au rôle requis par la route
        // On suppose que ta colonne en base de données s'appelle 'role'
        if ($request->user()->role !== $role) {
            // Si le rôle ne correspond pas, on bloque l'accès (Erreur 403)
            abort(403, "Accès refusé : Vous n'avez pas le rôle $role.");

    }
   return $next($request);
    }

}

