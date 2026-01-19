@extends('layouts.app')

@section('title', 'Comptes sociaux connectés')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Comptes sociaux</h1>
            <small class="text-muted">Gérez vos connexions aux réseaux sociaux</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Comptes connectés</h5>
                </div>

                @if($linkedAccounts->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($linkedAccounts as $account)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">
                                            <i class="bi bi-{{ $account->provider === 'google' ? 'google' : ($account->provider === 'github' ? 'github' : 'facebook') }}"></i>
                                            {{ ucfirst($account->provider) }}
                                        </h6>
                                        <small class="text-muted">
                                            @if($account->provider_profile)
                                                {{ json_decode($account->provider_profile)->email ?? json_decode($account->provider_profile)->name ?? 'Connecté' }}
                                            @endif
                                            <br>
                                            Connecté le {{ $account->created_at->format('d/m/Y à H:i') }}
                                        </small>
                                    </div>
                                    <form action="{{ route('social-accounts.disconnect', $account) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-unlink"></i> Déconnecter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card-body text-center py-5">
                        <i class="bi bi-link-45deg" style="font-size: 2rem; color: #ccc;"></i>
                        <p class="text-muted mt-3">Aucun compte social connecté</p>
                    </div>
                @endif
            </div>

            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Connecter un nouveau compte</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Connectez vos comptes sociaux pour faciliter votre login et gérer votre profil.</p>

                    <div class="row g-2">
                        @foreach(['google', 'facebook', 'github', 'twitter'] as $provider)
                            @if(!$linkedAccounts->where('provider', $provider)->count())
                                <div class="col-md-6">
                                    <a href="{{ route('social-accounts.connect', $provider) }}" class="btn btn-outline-secondary w-100">
                                        <i class="bi bi-{{ $provider === 'twitter' ? 'twitter' : $provider }}"></i>
                                        Connecter {{ ucfirst($provider) }}
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">À propos</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Pourquoi connecter les réseaux sociaux?</strong>
                    </p>
                    <ul class="small text-muted">
                        <li>✓ Connexion simplifiée</li>
                        <li>✓ Profil enrichi automatiquement</li>
                        <li>✓ Partage facile sur les réseaux</li>
                        <li>✓ Sécurité renforcée</li>
                    </ul>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Sécurité</h5>
                </div>
                <div class="card-body">
                    <small class="text-muted">
                        Vous pouvez à tout moment déconnecter vos comptes sociaux. Cela n'affectera pas votre capacité à vous connecter avec votre email.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour au profil
        </a>
    </div>
</div>
@endsection
