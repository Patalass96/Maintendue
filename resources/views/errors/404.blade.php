@extends('layouts.app')

@section('title', 'Page non trouvée - 404')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card text-center">
        <div class="error-icon" style="font-size: 80px; color: #3b82f6; margin-bottom: 20px;">
            <i class="fas fa-search-location"></i>
        </div>
        <h1 style="font-size: 60px; font-weight: 800; color: #111827; margin: 0;">404</h1>
        <h2 style="margin-bottom: 15px;">Oups ! Page introuvable</h2>
        <p class="auth-subtitle">
            Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
        </p>
        
        <div class="auth-actions" style="justify-content: center;">
            <a href="{{ url('/') }}" class="btn-primary-auth" style="text-decoration: none; max-width: 250px;">
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection