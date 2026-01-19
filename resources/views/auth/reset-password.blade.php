@extends('layouts.auth')

@section('title', 'Réinitialiser le mot de passe')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/auth.css'])
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-logo">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
    </div>

    <div class="auth-card">
        <h2>Réinitialiser votre mot de passe</h2>
        <p class="auth-subtitle">Créez un nouveau mot de passe sécurisé pour votre compte.</p>

        @if ($errors->any())
            <div class="alert alert-danger" style="color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 15px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label>Adresse email</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" value="{{ $email }}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label>Nouveau mot de passe</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input
                        type="password"
                        name="password"
                        placeholder="Minimum 8 caractères"
                        required
                        autofocus
                    >
                </div>
                <small style="color: #666; font-size: 12px;">
                    Votre mot de passe doit contenir au moins 8 caractères
                </small>
            </div>

            <div class="form-group">
                <label>Confirmer le mot de passe</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirmer le mot de passe"
                        required
                    >
                </div>
            </div>

            <button type="submit" class="btn-submit">Réinitialiser le mot de passe</button>
        </form>

        <p class="auth-footer">
            <a href="{{ route('login') }}">Retour à la connexion</a>
        </p>
    </div>
</div>
@endsection

@section('scripts')
    @vite(['resources/js/app.js', 'resources/js/form.js'])
@endsection
