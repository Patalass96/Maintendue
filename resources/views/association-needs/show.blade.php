@extends('layouts.app')

@section('title', $need->item_type)

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">{{ $need->item_type }}</h1>
            <small class="text-muted">
                Besoin spécifique de l'association
                <a href="{{ route('associations.show', $need->association) }}">{{ $need->association->name }}</a>
            </small>
        </div>
        <div class="col-md-4 text-end">
            @can('update', $need)
                <a href="{{ route('associations.needs.edit', $need) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Modifier
                </a>
                <form action="{{ route('associations.needs.destroy', $need) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </form>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Information</h5>

                    @if($need->description)
                        <p class="card-text">{{ $need->description }}</p>
                        <hr>
                    @endif

                    <div class="row">
                        @if($need->quantity_needed)
                            <div class="col-md-6">
                                <strong>Quantité souhaitée:</strong>
                                <p>{{ $need->quantity_needed }}</p>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <strong>Catégorie cible:</strong>
                            <p>
                                @if($need->target_category)
                                    {{ $need->target_category->name }}
                                @else
                                    Toutes les catégories
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Urgence</h5>
                    <span class="badge {{ $need->urgency === 'urgent' ? 'bg-danger' : ($need->urgency === 'high' ? 'bg-warning' : ($need->urgency === 'medium' ? 'bg-info' : 'bg-secondary')) }}">
                        {{ ucfirst($need->urgency) }}
                    </span>

                    <hr>

                    <h5 class="card-title">Statut</h5>
                    <p>
                        @if($need->is_active)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-danger">Inactif</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Association</h5>
                    <p class="mb-2">
                        <a href="{{ route('associations.show', $need->association) }}">
                            {{ $need->association->name }}
                        </a>
                    </p>
                    <small class="text-muted">
                        Créé le {{ $need->created_at->format('d/m/Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('associations.needs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à mes besoins
        </a>
    </div>
</div>
@endsection
