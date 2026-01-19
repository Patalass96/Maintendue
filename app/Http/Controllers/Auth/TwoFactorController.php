<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\SendOtpNotification;

class TwoFactorController extends Controller
{
    /**
     * Show the 2FA form.
     */
    public function index()
    {
        return view('auth.two-factor-challenge');
    }

    /**
     * Verify the OTP code.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        if ($request->code === $user->otp_code && now()->lessThanOrEqualTo($user->otp_expires_at)) {
            $user->resetOtp();
            session(['2fa_verified' => true]);

            // Supprimer le code de test de la session
            session()->forget('otp_code_display');

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isAssociation()) {
                if ($user->isVerifiedAssociation()) {
                    return redirect()->route('associations.complete-profile');
                }
                return redirect()->route('associations.pending')->with('status', 'Votre compte association est en attente de validation.');
            } elseif ($user->isDonator()) {
                return redirect()->route('donator.dashboard');
            }

            // return redirect()->route('home');
        }

        return back()->withErrors(['code' => 'Le code est invalide ou a expiré.']);
    }

    /**
     * Resend the OTP code.
     */
    public function resend()
    {
        $user = Auth::user();
        $otp = $user->generateOtp();
        // Déterminer si on doit envoyer un vrai email ou afficher le code
        $emailDomain = substr(strrchr($user->email, "@"), 1);
        $isTestEmail = in_array($emailDomain, ['test.com', 'example.com', 'localhost']);

        if ($isTestEmail) {
            // Email de test : Afficher le code dans les logs et la session
            session(['otp_code_display' => $otp]);

            Log::info("OTP regénéré pour test", [
                'user_id' => $user->id,
                'email' => $user->email,
                'otp' => $otp
            ]);

            return back()->with('status', 'Un nouveau code a été généré (affiché ci-dessus).');
        } else {
            // Email réel : Envoyer par email
            try {
                $user->notify(new SendOtpNotification($otp));

                Log::info("OTP renvoyé par email", [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);

                return back()->with('status', 'Un nouveau code a été envoyé à votre adresse email.');
            } catch (\Exception $e) {
                Log::error("Erreur renvoi mail OTP", [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage()
                ]);

                // En cas d'erreur, afficher le code
                session(['otp_code_display' => $otp]);
                return back()->with('email_error', 'Erreur d\'envoi email. Le code est affiché ci-dessus.');
            }
        }
    }
}