<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Affiche le formulaire de demande de lien de réinitialisation
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Envoie le lien de réinitialisation de mot de passe par email
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // Envoyer le lien de réinitialisation
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Valide l'adresse email
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            [
                'email.required' => 'L\'adresse email est requise.',
                'email.email' => 'Veuillez entrer une adresse email valide.',
                'email.exists' => 'Aucun compte associé à cette adresse email.',
            ]
        );
    }

    /**
     * Récupère les identifiants du formulaire
     */
    protected function credentials(Request $request)
    {
        return $request->only('email');
    }

    /**
     * Réponse positive après l'envoi du lien
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()
            ->with('status', 'Nous avons envoyé un lien de réinitialisation de mot de passe à votre adresse email.')
            ->with('email', $request->email);
    }

    /**
     * Réponse négative après l'échec de l'envoi
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    /**
     * Récupère le broker de réinitialisation de mot de passe
     */
    public function broker()
    {
        return Password::broker();
    }
}