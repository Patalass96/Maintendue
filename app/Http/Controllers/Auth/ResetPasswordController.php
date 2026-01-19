<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Affiche le formulaire de réinitialisation de mot de passe
     */
    public function showResetForm(Request $request)
    {
        $token = $request->route('token');

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Réinitialise le mot de passe de l'utilisateur
     */
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        // Vérifier le token et récupérer l'utilisateur
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Réinitialise le mot de passe de l'utilisateur en base de données
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));
    }

    /**
     * Récupère les règles de validation
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8|max:255',
            'password_confirmation' => 'required',
        ];
    }

    /**
     * Messages d'erreur personnalisés
     */
    protected function validationErrorMessages()
    {
        return [
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.exists' => 'Aucun compte associé à cette adresse email.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password_confirmation.required' => 'Veuillez confirmer votre mot de passe.',
            'token.required' => 'Le token de réinitialisation est manquant.',
        ];
    }

    /**
     * Récupère les identifiants du formulaire
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );
    }

    /**
     * Réponse positive après la réinitialisation
     */
    protected function sendResetResponse(Request $request, $response)
    {
        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }

    /**
     * Réponse négative après l'échec
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    /**
     * Récupère le chemin de redirection après la réinitialisation
     */
    protected function redirectPath()
    {
        return route('home');
    }

    /**
     * Récupère le broker de réinitialisation de mot de passe
     */
    public function broker()
    {
        return Password::broker();
    }
}
