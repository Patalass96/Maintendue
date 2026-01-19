@extends('layouts.app')

@section('title', 'Profil - ' . $association->legal_name)

@section('content')
<div class="association-profile-page">
    <!-- En-tête -->
    <div class="association-hero">
        <div class="container">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <a href="{{ route('associations.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour aux associations
                </a>
            </div>

            <div class="association-header-content d-flex gap-4 align-items-start">
                @if($association->logo)
                    <img src="{{ Storage::url($association->logo) }}" alt="{{ $association->legal_name }}" class="association-logo rounded" width="150" height="150" style="object-fit: contain;">
                @else
                    <div class="association-logo-placeholder rounded bg-light d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                        <i class="fas fa-university fa-3x text-muted"></i>
                    </div>
                @endif

                <div class="association-header-info flex-grow-1">
                    <h1 class="mb-2">{{ $association->legal_name }}</h1>

                    <!-- Badges -->
                    <div class="badges-section mb-3">
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle"></i> Vérifiée
                        </span>
                        @if($association->is_featured)
                            <span class="badge bg-warning">
                                <i class="fas fa-star"></i> Partenaire vedette
                            </span>
                        @endif
                    </div>

                    <!-- Statistiques clés -->
                    <div class="stats-row">
                        <div class="stat-item">
                            <strong>{{ $stats['total_donations'] }}</strong>
                            <small>dons reçus</small>
                        </div>
                        <div class="stat-item">
                            <strong>{{ number_format($stats['satisfaction_rate'], 1) }}/5</strong>
                            <small>satisfaction</small>
                        </div>
                        <div class="stat-item">
                            <strong>{{ $stats['active_requests'] }}</strong>
                            <small>demandes actives</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container py-5">
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <!-- À propos -->
                <section class="content-section mb-5">
                    <h2 class="mb-4">À propos</h2>
                    <p class="lead">{{ $association->description }}</p>

                    <!-- Besoins -->
                    @if($association->needs_description)
                        <div class="needs-box p-4 bg-light rounded mt-4">
                            <h5 class="mb-3"><i class="fas fa-heart"></i> Nos besoins prioritaires</h5>
                            <p>{{ $association->needs_description }}</p>
                        </div>
                    @endif
                </section>

                <!-- Informations de contact -->
                <section class="content-section mb-5">
                    <h3 class="mb-4">Informations de contact</h3>
                    <div class="contact-info">
                        @if($association->legal_address)
                            <div class="contact-item mb-3">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                                <div>
                                    <strong>Adresse</strong>
                                    <p>{{ $association->legal_address }}</p>
                                </div>
                            </div>
                        @endif

                        @if($association->phone)
                            <div class="contact-item mb-3">
                                <i class="fas fa-phone text-primary"></i>
                                <div>
                                    <strong>Téléphone</strong>
                                    <p><a href="tel:{{ $association->phone }}">{{ $association->phone }}</a></p>
                                </div>
                            </div>
                        @endif

                        @if($association->website)
                            <div class="contact-item mb-3">
                                <i class="fas fa-globe text-primary"></i>
                                <div>
                                    <strong>Site Web</strong>
                                    <p><a href="{{ $association->website }}" target="_blank">{{ $association->website }}</a></p>
                                </div>
                            </div>
                        @endif

                        @if($association->opening_hours)
                            <div class="contact-item mb-3">
                                <i class="fas fa-clock text-primary"></i>
                                <div>
                                    <strong>Horaires d'ouverture</strong>
                                    <p>{{ $association->opening_hours }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </section>

                <!-- Modalités de livraison -->
                <section class="content-section mb-5">
                    <h3 class="mb-4">Modalités de livraison</h3>
                    <div class="delivery-options">
                        @if($association->accepts_direct_delivery)
                            <div class="option-item p-3 bg-light rounded mb-3">
                                <i class="fas fa-hand-holding-heart text-success"></i>
                                <strong>Livraison directe acceptée</strong>
                                <p class="text-muted mb-0">Rayon de livraison: {{ $association->delivery_radius ?? 'À convenir' }} km</p>
                            </div>
                        @endif

                        @if($association->accepts_collection_points)
                            <div class="option-item p-3 bg-light rounded mb-3">
                                <i class="fas fa-store text-success"></i>
                                <strong>Points de collecte acceptés</strong>
                            </div>
                        @endif
                    </div>
                </section>

                <!-- Points de collecte -->
                @if($association->collectionPoints()->count() > 0)
                    <section class="content-section mb-5">
                        <h3 class="mb-4">Points de collecte</h3>
                        <div class="collection-points">
                            @foreach($association->collectionPoints as $point)
                                <div class="point-item p-3 border rounded mb-3">
                                    <h6>{{ $point->name }}</h6>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-map-marker-alt"></i> {{ $point->address }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Demandes actives -->
                @if($association->requests->count() > 0)
                    <section class="content-section">
                        <h3 class="mb-4">Demandes de dons actives</h3>
                        <div class="requests-list">
                            @foreach($association->requests as $request)
                                <div class="request-item p-3 border rounded mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6>{{ $request->title }}</h6>
                                            <p class="text-muted mb-0">{{ Str::limit($request->description, 100) }}</p>
                                        </div>
                                        <a href="{{ route('donations.index', ['request' => $request->id]) }}" class="btn btn-sm btn-primary">
                                            Voir les dons
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Actions -->
                <div class="action-card card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Actions</h5>

                        @auth
                            <a href="{{ route('conversations.start', ['association_id' => $association->id]) }}" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-envelope"></i> Contacter
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-envelope"></i> Se connecter pour contacter
                            </a>
                        @endauth

                        <a href="{{ route('donations.index', ['association' => $association->id]) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-search"></i> Voir les dons pour cette association
                        </a>
                    </div>
                </div>

                <!-- Informations supplémentaires -->
                <div class="info-card card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informations</h6>
                    </div>
                    <div class="card-body">
                        <div class="info-item mb-3">
                            <strong class="text-muted d-block small">Numéro d'enregistrement</strong>
                            {{ $association->registration_number ?? 'Non disponible' }}
                        </div>
                        <div class="info-item mb-3">
                            <strong class="text-muted d-block small">Responsable</strong>
                            {{ $association->contact_person ?? $association->manager->name }}
                        </div>
                        <div class="info-item mb-0">
                            <strong class="text-muted d-block small">Statut de vérification</strong>
                            <span class="badge bg-success">{{ ucfirst($association->verification_status) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.association-hero {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 3rem 0;
    border-bottom: 1px solid #dee2e6;
}

.association-header-content {
    color: #333;
}

.association-logo {
    border: 3px solid white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.badges-section {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.stats-row {
    display: flex;
    gap: 2rem;
}

.stat-item {
    display: flex;
    flex-direction: column;
}

.stat-item strong {
    font-size: 1.5rem;
    color: #0d6efd;
}

.stat-item small {
    color: #6c757d;
    font-size: 0.9rem;
}

.content-section {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.contact-item {
    display: flex;
    gap: 1rem;
}

.contact-item i {
    font-size: 1.5rem;
    margin-top: 0.25rem;
}

.option-item {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.option-item i {
    font-size: 2rem;
}

.action-card,
.info-card {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: none;
}

.info-item strong {
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}
</style>
@endsection

