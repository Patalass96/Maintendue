@extends('layouts.app')

@section('title', $need->exists ? 'Modifier le besoin' : 'Créer un besoin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">{{ $need->exists ? 'Modifier le besoin' : 'Ajouter un nouveau besoin' }}</h1>
        </div>
    </div>

    <form action="{{ $need->exists ? route('associations.needs.update', $need) : route('associations.needs.store') }}" method="POST" class="row">
        @csrf
        @if($need->exists)
            @method('PUT')
        @endif

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="item_type" class="form-label">Type de donation recherchée *</label>
                        <select id="item_type" name="item_type" class="form-select @error('item_type') is-invalid @enderror" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="Vêtements" {{ old('item_type', $need->item_type) === 'Vêtements' ? 'selected' : '' }}>Vêtements</option>
                            <option value="Nourriture" {{ old('item_type', $need->item_type) === 'Nourriture' ? 'selected' : '' }}>Nourriture</option>
                            <option value="Fournitures scolaires" {{ old('item_type', $need->item_type) === 'Fournitures scolaires' ? 'selected' : '' }}>Fournitures scolaires</option>
                            <option value="Meubles" {{ old('item_type', $need->item_type) === 'Meubles' ? 'selected' : '' }}>Meubles</option>
                            <option value="Équipement médical" {{ old('item_type', $need->item_type) === 'Équipement médical' ? 'selected' : '' }}>Équipement médical</option>
                            <option value="Jouets" {{ old('item_type', $need->item_type) === 'Jouets' ? 'selected' : '' }}>Jouets</option>
                            <option value="Livres" {{ old('item_type', $need->item_type) === 'Livres' ? 'selected' : '' }}>Livres</option>
                            <option value="Articles de sport" {{ old('item_type', $need->item_type) === 'Articles de sport' ? 'selected' : '' }}>Articles de sport</option>
                            <option value="Électronique" {{ old('item_type', $need->item_type) === 'Électronique' ? 'selected' : '' }}>Électronique</option>
                            <option value="Autre" {{ old('item_type', $need->item_type) === 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('item_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description du besoin</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                            rows="4" placeholder="Décrivez précisément ce dont vous avez besoin...">{{ old('description', $need->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="quantity_needed" class="form-label">Quantité souhaitée</label>
                            <input type="text" id="quantity_needed" name="quantity_needed" class="form-control"
                                placeholder="ex: 50 kg, 100 pièces" value="{{ old('quantity_needed', $need->quantity_needed) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="urgency" class="form-label">Niveau d'urgence *</label>
                            <select id="urgency" name="urgency" class="form-select @error('urgency') is-invalid @enderror" required>
                                <option value="low" {{ old('urgency', $need->urgency) === 'low' ? 'selected' : '' }}>Basse</option>
                                <option value="medium" {{ old('urgency', $need->urgency) === 'medium' ? 'selected' : '' }}>Moyenne</option>
                                <option value="high" {{ old('urgency', $need->urgency) === 'high' ? 'selected' : '' }}>Élevée</option>
                                <option value="urgent" {{ old('urgency', $need->urgency) === 'urgent' ? 'selected' : '' }}>Urgente</option>
                            </select>
                            @error('urgency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="target_category_id" class="form-label">Catégorie cible (optionnel)</label>
                        <select id="target_category_id" name="target_category_id" class="form-select">
                            <option value="">-- Toutes les catégories --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('target_category_id', $need->target_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Limite à une catégorie spécifique si nécessaire</small>
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
                                {{ old('is_active', $need->is_active ?? true) ? 'checked' : '' }}>
                            Actif
                        </label>
                        <small class="d-block text-muted mt-1">
                            Les donateurs verront ce besoin dans votre profil
                        </small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2"></i> {{ $need->exists ? 'Mettre à jour' : 'Créer' }}
                        </button>
                        <a href="{{ route('associations.needs.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
