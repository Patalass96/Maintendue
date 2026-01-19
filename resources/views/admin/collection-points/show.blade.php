@extends('layouts.app')

@section('title', $collectionPoint->name)

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">{{ $collectionPoint->name }}</h1>
            <small class="text-muted">Point de collecte</small>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.collection-points.edit', $collectionPoint) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <form action="{{ route('admin.collection-points.destroy', $collectionPoint) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informations</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Association:</strong>
                            @if($collectionPoint->association)
                                <p>
                                    <a href="{{ route('associations.show', $collectionPoint->association) }}">
                                        {{ $collectionPoint->association->name }}
                                    </a>
                                </p>
                            @else
                                <p class="text-muted">Non assigné</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <strong>Statut:</strong>
                            <p>
                                @if($collectionPoint->is_active)
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-danger">Inactif</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr>

                    <strong>Adresse:</strong>
                    <p>
                        {{ $collectionPoint->address }}<br>
                        {{ $collectionPoint->postal_code }} {{ $collectionPoint->city }}<br>
                        @if($collectionPoint->country)
                            {{ $collectionPoint->country }}
                        @endif
                    </p>

                    @if($collectionPoint->description)
                        <hr>
                        <strong>Description:</strong>
                        <p>{{ $collectionPoint->description }}</p>
                    @endif

                    @if($collectionPoint->hours_open || $collectionPoint->phone)
                        <hr>
                        <div class="row">
                            @if($collectionPoint->hours_open)
                                <div class="col-md-6">
                                    <strong>Horaires:</strong>
                                    <p>{{ $collectionPoint->hours_open }}</p>
                                </div>
                            @endif
                            @if($collectionPoint->phone)
                                <div class="col-md-6">
                                    <strong>Téléphone:</strong>
                                    <p><a href="tel:{{ $collectionPoint->phone }}">{{ $collectionPoint->phone }}</a></p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Détails</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Créé le</small>
                        <p class="mb-0">{{ $collectionPoint->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Dernière modification</small>
                        <p class="mb-0">{{ $collectionPoint->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>

                    <hr>

                    <form action="{{ route('admin.collection-points.toggle', $collectionPoint) }}" method="POST" class="d-grid">
                        @csrf
                        <button type="submit" class="btn {{ $collectionPoint->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                            <i class="bi bi-{{ $collectionPoint->is_active ? 'lock' : 'unlock' }}"></i>
                            {{ $collectionPoint->is_active ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <a href="{{ route('admin.collection-points.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection
