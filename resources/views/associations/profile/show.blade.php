@extends('layouts.association')

@section('title', 'Mon Profil - MainTendue')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4">
            @include('association.partials.sidebar')
        </div>
        
        <!-- Main content -->
        <div class="col-lg-9 col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Mon profil</h2>
                <a href="{{ route('association.profile.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Modifier
                </a>
            </div>
            
            <!-- Profil card -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            @if($association->logo)
                                <img src="{{ asset('storage/' . $association->logo) }}" 
                                     alt="{{ $association->legal_name }}" 
                                     class="rounded-circle mb-3" 
                                     width="150" height="150" style="object-fit: cover;">
                            @else
                                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-hands-helping fa-3x text-white"></i>
                                </div>
                            @endif
                            
                            <h4>{{ $association->legal_name }}</h4>
                            <p class="text-muted">{{ $association->contact_person }}</p>
                            
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary" onclick="window.print()">
                                    <i class="fas fa-print me-2"></i>Imprimer le profil
                                </button>
                                <a href="#" class="btn btn-outline-success">
                                    <i class="fas fa-share-alt me-2"></i>Partager
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Statut -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <h6 class="card-title">Statut de vérification</h6>
                            <div class="d-flex align-items-center">
                                @switch($association->verification_status)
                                    @case('verified')
                                        <i class="fas fa-check-circle fa-2x text-success me-3"></i>
                                        <div>
                                            <strong class="text-success">Vérifiée</strong>
                                            <div class="text-muted small">Profil validé</div>
                                        </div>
                                        @break
                                    @case('pending')
                                        <i class="fas fa-clock fa-2x text-warning me-3"></i>
                                        <div>
                                            <strong class="text-warning">En attente</strong>
                                            <div class="text-muted small">Validation en cours</div>
                                        </div>
                                        @break
                                    @case('rejected')
                                        <i class="fas fa-times-circle fa-2x text-danger me-3"></i>
                                        <div>
                                            <strong class="text-danger">Rejetée</strong>
                                            <div class="text-muted small">Contactez l'admin</div>
                                        </div>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <!-- Informations -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Informations générales</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Nom légal</label>
                                    <p class="fw-bold">{{ $association->legal_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Personne de contact</label>
                                    <p class="fw-bold">{{ $association->contact_person }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Téléphone</label>
                                    <p class="fw-bold">{{ $association->phone }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Email</label>
                                    <p class="fw-bold">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label text-muted">Adresse légale</label>
                                    <p class="fw-bold">{{ $association->legal_address }}</p>
                                </div>
                                @if($association->registration_number)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Numéro d'enregistrement</label>
                                    <p class="fw-bold">{{ $association->registration_number }}</p>
                                </div>
                                @endif
                                @if($association->website)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Site web</label>
                                    <p class="fw-bold">
                                        <a href="{{ $association->website }}" target="_blank">{{ $association->website }}</a>
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Description</h5>
                        </div>
                        <div class="card-body">
                            <p>{{ $association->description }}</p>
                            
                            @if($association->needs_description)
                                <hr>
                                <h6>Besoins actuels :</h6>
                                <p class="text-muted">{{ $association->needs_description }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Logistique -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Logistique</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Livraison directe</label>
                                    <p class="fw-bold">
                                        @if($association->accepts_direct_delivery)
                                            <i class="fas fa-check text-success me-2"></i>Acceptée
                                        @else
                                            <i class="fas fa-times text-danger me-2"></i>Non acceptée
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Points de collecte</label>
                                    <p class="fw-bold">
                                        @if($association->accepts_collection_points)
                                            <i class="fas fa-check text-success me-2"></i>Disponibles
                                        @else
                                            <i class="fas fa-times text-danger me-2"></i>Non disponibles
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Rayon d'acceptation</label>
                                    <p class="fw-bold">
                                        @if($association->delivery_radius)
                                            {{ $association->delivery_radius }} km
                                        @else
                                            Non défini
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Horaires</label>
                                    <p class="fw-bold">
                                        @if($association->opening_hours)
                                            {{ $association->opening_hours }}
                                        @else
                                            Non spécifié
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection