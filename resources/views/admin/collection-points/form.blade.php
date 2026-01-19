@extends('layouts.app')

@section('title', $collectionPoint->exists ? 'Modifier le point de collecte' : 'Créer un point de collecte')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">{{ $collectionPoint->exists ? 'Modifier le point de collecte' : 'Créer un nouveau point' }}</h1>
        </div>
    </div>

    <form action="{{ $collectionPoint->exists ? route('admin.collection-points.update', $collectionPoint) : route('admin.collection-points.store') }}" method="POST" class="row">
        @csrf
        @if($collectionPoint->exists)
            @method('PUT')
        @endif

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom du point *</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $collectionPoint->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="association_id" class="form-label">Association *</label>
                        <select id="association_id" name="association_id" class="form-select @error('association_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner une association --</option>
                            @foreach($associations as $association)
                                <option value="{{ $association->id }}" {{ old('association_id', $collectionPoint->association_id) == $association->id ? 'selected' : '' }}>
                                    {{ $association->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('association_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Adresse *</label>
                        <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror"
                            value="{{ old('address', $collectionPoint->address) }}" required>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">Ville *</label>
                            <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror"
                                value="{{ old('city', $collectionPoint->city) }}" required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="postal_code" class="form-label">Code postal *</label>
                            <input type="text" id="postal_code" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror"
                                value="{{ old('postal_code', $collectionPoint->postal_code) }}" required>
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="country" class="form-label">Pays</label>
                            <input type="text" id="country" name="country" class="form-control"
                                value="{{ old('country', $collectionPoint->country ?? 'France') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $collectionPoint->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="hours_open" class="form-label">Horaires d'ouverture</label>
                            <input type="text" id="hours_open" name="hours_open" class="form-control"
                                placeholder="ex: Lun-Ven 9h-17h" value="{{ old('hours_open', $collectionPoint->hours_open) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="tel" id="phone" name="phone" class="form-control"
                                value="{{ old('phone', $collectionPoint->phone) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="is_active" class="form-check-label">
                            <input type="checkbox" id="is_active" name="is_active" class="form-check-input"
                                {{ old('is_active', $collectionPoint->is_active) ? 'checked' : '' }}>
                            Actif
                        </label>
                        <small class="d-block text-muted mt-1">
                            Le point sera visible et disponible pour les collectes
                        </small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2"></i> {{ $collectionPoint->exists ? 'Mettre à jour' : 'Créer' }}
                        </button>
                        <a href="{{ route('admin.collection-points.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
