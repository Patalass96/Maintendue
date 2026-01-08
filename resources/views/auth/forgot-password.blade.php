@extends('layouts.auth')

@section('title', 'Récupération de compte')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/auth.css'])
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-logo">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
    </div>

    <div class="auth-card">
        <h2>Mot de passe oublié ?</h2>
        <p class="auth-subtitle">Entrez votre email pour recevoir un lien de réinitialisation.</p>

        @if (session('status'))
            <div class="alert alert-success" style="color: #155724; background: #d4edda; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 15px;">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" style="color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 15px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label>Email de récupération</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="votre@email.com" required autofocus>
                </div>
            </div>

            <button type="submit" class="btn-submit">Envoyer le lien</button>
        </form>

        <p class="auth-footer"><a href="{{ route('login') }}">Retour à la connexion</a></p>
    </div>
</div>
@endsection

@section('scripts')
    @vite(['resources/js/app.js', 'ressources/js/form.js'])
@endsection