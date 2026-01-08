
@extends('layouts.auth')

@section('title', 'Authentification')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/auth.css'])
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Créer un compte</h2>
            <p class="auth-subtitle">Rejoignez MainTendue et commencez à faire la différence !</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" style="color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 8px; font-size: 13px; margin: 15px 0;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label>Vous êtes :</label>
                <div class="input-with-icon">
                    <i class="fas fa-user-tag"></i>
                    <select name="role">
                        <option value="donateur">Donateur</option>
                       <option value="association">Association</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Nom complet</label>
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" placeholder="Ex:Grace ADZOETSE" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="votre@email.com" required>
                </div>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Minimum 8 caractères" required>
                </div>
            </div>

            <div class="form-group">
                <label>Confirmer le mot de passe</label>
                <div class="input-with-icon">
                    <i class="fas fa-check-double"></i>
                    <input type="password" name="password_confirmation" placeholder="Répétez le mot de passe" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">S'inscrire</button>
        </form>

        <div class="divider"><span>OU</span></div>

        <div class="social-auth">
            <div class="social-btns">
                <a href="#" class="social-link google"><i class="fab fa-google"></i> Google</a>
                <a href="#" class="social-link facebook"><i class="fab fa-facebook-f"></i> Facebook</a>
            </div>
        </div>
    </div>

    <p class="auth-footer">Déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>

    <p class="legal-text">
        En vous inscrivant, vous acceptez nos 
        <a href="{{ route('terms') }}">Conditions générales</a> et notre <a href="{{ route('privacy') }}">Politique de confidentialité</a>.
    </p>
</div>
@endsection

@section('scripts')

  @vite([ 'resources/js/app.js', 'resources/js/form.js'])
  
@endsection


