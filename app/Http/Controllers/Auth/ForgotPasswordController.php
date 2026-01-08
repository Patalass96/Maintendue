<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Affiche ton formulaire personnalisé
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password'); 
    }
}