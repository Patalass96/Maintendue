@extends('layouts.auth')  <!-- ou le nom de ton layout principal -->

@section('title', 'Authentification')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/auth.css'])
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-logo">
        <img src="{{ asset('assets/images/logos/MainTendue.png') }}" alt="Logo">
    </div>

    <div class="auth-card">
        <h2>Bienvenue sur MainTendue</h2>
        <p class="auth-subtitle">Accédez à votre espace MainTendue</p>

        @if ($errors->any())
            <div class="alert alert-danger" style="color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 8px; font-size: 13px; margin: 15px 0;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="votre@email.com" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <div class="form-utils">
                <label><input type="checkbox" name="remember"> Se souvenir de moi</label>
                <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn-submit">Se connecter</button>
        </form>

        <p class="auth-footer">Pas encore de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a></p>
    </div>
</div>
@endsection

@section('scripts')
    @vite(['resources/js/app.js', 'resources/js/form.js'])
@endsection
