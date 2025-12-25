<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    
public function handleProviderCallback($provider)
{
    $socialUser = Socialite::driver($provider)->user();

    // 1. Chercher si ce compte social existe déjà
    $socialAccount = SocialAccount::where('provider', $provider)
        ->where('provider_id', $socialUser->getId())
        ->first();

    if ($socialAccount) {
        Auth::login($socialAccount->user);
        return redirect()->intended('/dashboard');
    }

    // 2. Sinon, chercher l'utilisateur par email ou le créer
    $user = User::firstOrCreate(
        ['email' => $socialUser->getEmail()],
        [
            'name' => $socialUser->getName(),
            'password' => Hash::make(Str::random(24)),
            'avatar' => $socialUser->getAvatar(),
        ]
    );

    // 3. Lier le compte social à l'utilisateur
    $user->socialAccounts()->create([
        'provider' => $provider,
        'provider_id' => $socialUser->getId(),
        'access_token' => $socialUser->token,
        'refresh_token' => $socialUser->refreshToken,
    ]);

    Auth::login($user);
    return redirect()->intended('/dashboard');
}


}
