@extends('layouts.association')

@section('title', 'Mes Demandes - Main Tendue')

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
                <h2>Mes demandes de dons</h2>
                <a href="{{ route('associations.requests.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nouvelle demande
                </a>
            </div>
            
            <!-- Filtres -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Statut</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Tous les statuts</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepté</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                                <option value="fulfilled" {{ request('status') == 'fulfilled' ? 'selected' : '' }}>Comblé</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">Tous types</option>
                                <option value="clothing" {{ request('type') == 'clothing' ? 'selected' : '' }}>Vêtements</option>
                                <option value="food" {{ request('type') == 'food' ? 'selected' : '' }}>Alimentaire</option>
                                <option value="school" {{ request('type') == 'school' ? 'selected' : '' }}>Scolaire</option>
                                <option value="furniture" {{ request('type') == 'furniture' ? 'selected' : '' }}>Meubles</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="date" class="form-label">Date</label>
                            <select class="form-select" id="date" name="date">
                                <option value="">Toutes dates</option>
                                <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                                <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>Cette semaine</option>
                                <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>Ce mois</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Filtrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Liste des demandes -->
            @if($requests->count() > 0)
                <div class="row">
                    @foreach($requests as $request)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{ $request->title ?? 'Demande sans titre' }}</h5>
                                    <span class="badge bg-{{ $request->status == 'pending' ? 'warning' : ($request->status == 'accepted' ? 'success' : 'danger') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ $request->message }}</p>
                                    
                                    @if($request->donation)
                                        <hr>
                                        <h6>Don lié :</h6>
                                        <div class="d-flex align-items-center">
                                            @if($request->donation->primaryImage)
                                                <img src="{{ $request->donation->primaryImage->url }}" 
                                                     alt="Don" 
                                                     class="rounded me-3"
                                                     width="60" height="60" style="object-fit: cover;">
                                            @endif
                                            <div>
                                                <strong>{{ $request->donation->title }}</strong>
                                                <div class="text-muted small">
                                                    {{ $request->donation->category->name ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $request->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('associations.requests.show', $request) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>Voir
                                        </a>
                                        
                                        @if($request->status == 'pending')
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-check me-1"></i>Modifier
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times me-1"></i>Supprimer
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $requests->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bullhorn fa-4x text-muted mb-4"></i>
                    <h3>Aucune demande</h3>
                    <p class="text-muted mb-4">
                        Vous n'avez pas encore créé de demande de don.<br>
                        Créez votre première demande pour informer les donateurs de vos besoins.
                    </p>
                    <a href="{{ route('associations.requests.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Créer une demande
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection