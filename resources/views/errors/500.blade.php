@extends('layouts.app')

@section('title', 'Erreur Serveur - 500')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card text-center">
        <div class="error-icon" style="font-size: 80px; color: #ef4444; margin-bottom: 20px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h1 style="font-size: 60px; font-weight: 800; color: #111827; margin: 0;">500</h1>
        <h2 style="margin-bottom: 15px;">Erreur interne du serveur</h2>
        <p class="auth-subtitle">
            Un problème inattendu est survenu. Notre équipe technique a été alertée. 
            Veuillez réessayer dans quelques instants.
        </p>
        
        <div class="auth-actions" style="justify-content: center;">
            <a href="{{ url('/') }}" class="btn-primary-auth" style="text-decoration: none; max-width: 250px; background-color: #4b5563;">
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection