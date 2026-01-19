<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialAccountController extends Controller
{
    /**
     * Affiche la liste des comptes sociaux de l'utilisateur
     */
    public function index()
    {
        $this->middleware('auth');

        $user = Auth::user();
        $socialAccounts = $user->socialAccounts;

        // Fournisseurs disponibles
        $providers = ['google', 'facebook', 'github', 'twitter'];
        $connectedProviders = $socialAccounts->pluck('provider')->toArray();
        $availableProviders = array_diff($providers, $connectedProviders);

        return view('profile.social-accounts', compact('socialAccounts', 'availableProviders', 'providers'));
    }

    /**
     * Redirige vers le fournisseur OAuth
     */
    public function connect($provider)
    {
        $this->validateProvider($provider);

        // Vérifier que le compte n'est pas déjà lié
        if (Auth::user()->socialAccounts()->where('provider', $provider)->exists()) {
            return back()->with('error', "Vous avez déjà lié ce compte $provider.");
        }

        return Socialite::driver($provider)
            ->redirect();
    }

    /**
     * Callback après authentification OAuth
     */
    public function callback($provider)
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('profile.social-accounts')
                ->with('error', "Erreur lors de la connexion avec $provider.");
        }

        $existingAccount = SocialAccount::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if ($existingAccount) {
            if ($existingAccount->user_id === Auth::id()) {
                return redirect()->route('profile.social-accounts')
                    ->with('info', 'Ce compte est déjà lié.');
            } else {
                return redirect()->route('profile.social-accounts')
                    ->with('error', 'Ce compte est déjà lié à un autre utilisateur.');
            }
        }

        // Créer le compte social
        SocialAccount::create([
            'user_id' => Auth::id(),
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            'provider_name' => $socialUser->getName(),
            'provider_email' => $socialUser->getEmail(),
        ]);

        return redirect()->route('profile.social-accounts')
            ->with('success', "Compte $provider lié avec succès.");
    }

    /**
     * Détache un compte social
     */
    public function disconnect(SocialAccount $socialAccount)
    {
        $this->authorize('delete', $socialAccount);

        $provider = $socialAccount->provider;
        $socialAccount->delete();

        return back()->with('success', "Compte $provider détaché avec succès.");
    }

    /**
     * Valide le fournisseur
     */
    private function validateProvider($provider)
    {
        $providers = ['google', 'facebook', 'github', 'twitter'];

        if (!in_array($provider, $providers)) {
            abort(404, 'Fournisseur non supporté');
        }
    }
}
