@extends('layouts/layout.donapp')

@section('title', 'Liste des Dons')

@section('content')

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
    @foreach($donations as $donation)
        <div class="col" wire:key="donation-{{ $donation->id }}">
            @include('donations._card', ['donation' => $donation])
        </div>
    @endforeach
</div>

{{-- Ou pour une grille simple --}}
<div class="row">
    @foreach($donations as $donation)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            @include('donations._card', ['donation' => $donation])
        </div>
    @endforeach
</div>

<div class="row">
    <!-- Sidebar des filtres -->
    <div class="col-lg-3 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtres</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('donations.index') }}" method="GET">

                    <!-- Catégorie -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Catégorie</label>
                        <div class="list-group">
                            @foreach($categories as $category)
                            <label class="list-group-item">
                                <input class="form-check-input me-2" type="checkbox"
                                       name="categories[]" value="{{ $category->id }}"
                                       {{ in_array($category->id, (array)request('categories', [])) ? 'checked' : '' }}>
                                {{ $category->name }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Localisation -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Localisation</label>
                        <select class="form-select" name="city">
                            <option value="">Toutes les villes</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- État -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">État</label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="condition" value="new"
                                       id="cond_new" {{ request('condition') == 'new' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cond_new">
                                    <span class="badge bg-success">Neuf</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="condition" value="excellent"
                                       id="cond_excellent" {{ request('condition') == 'excellent' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cond_excellent">
                                    <span class="badge bg-primary">Très bon</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="condition" value="good"
                                       id="cond_good" {{ request('condition') == 'good' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cond_good">
                                    <span class="badge bg-info">Bon</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Taille -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Taille</label>
                        <select class="form-select" name="size">
                            <option value="">Toutes tailles</option>
                            <option value="XS" {{ request('size') == 'XS' ? 'selected' : '' }}>XS</option>
                            <option value="S" {{ request('size') == 'S' ? 'selected' : '' }}>S</option>
                            <option value="M" {{ request('size') == 'M' ? 'selected' : '' }}>M</option>
                            <option value="L" {{ request('size') == 'L' ? 'selected' : '' }}>L</option>
                            <option value="XL" {{ request('size') == 'XL' ? 'selected' : '' }}>XL</option>
                        </select>
                    </div>

                    <!-- Urgence -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Urgence</label>
                        <select class="form-select" name="urgency">
                            <option value="">Toutes urgences</option>
                            <option value="low" {{ request('urgency') == 'low' ? 'selected' : '' }}>Faible</option>
                            <option value="medium" {{ request('urgency') == 'medium' ? 'selected' : '' }}>Moyenne</option>
                            <option value="high" {{ request('urgency') == 'high' ? 'selected' : '' }}>Haute</option>
                        </select>
                    </div>

                    <!-- Boutons -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-filter"></i> Appliquer les filtres
                        </button>
                        <a href="{{ route('donations.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Voir mon panier -->
        <div class="card mt-3">
            <div class="card-body text-center">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-cart3"></i> Voir le panier
                </a>
            </div>
        </div>
    </div>

    <!-- Liste des dons -->
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Dons disponibles</h1>
            <a href="{{ route('donations.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Publier un don
            </a>
        </div>

        <!-- Barre de recherche -->
        <div class="mb-4">
            <form action="{{ route('donations.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search"
                           placeholder="Rechercher un don..." value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste -->
        @if($donations->isEmpty())
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Aucun don ne correspond à vos critères.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($donations as $donation)
                    <div class="col">
                        <div class="card donation-card h-100">
                            <!-- Badge d'urgence -->
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge badge-urgency-{{ $donation->urgency }}">
                                    @if($donation->urgency == 'high')
                                        <i class="bi bi-exclamation-triangle"></i> Urgent
                                    @elseif($donation->urgency == 'medium')
                                        <i class="bi bi-clock"></i> Moyen
                                    @else
                                        <i class="bi bi-check-circle"></i> Faible
                                    @endif
                                </span>
                            </div>

                            <!-- Image -->
                            <img src="{{ $donation->thumbnail }}"
                                 class="card-img-top"
                                 alt="{{ $donation->title }}"
                                 style="height: 200px; object-fit: cover;">

                            <div class="card-body">
                                <!-- Titre et catégorie -->
                                <h5 class="card-title">{{ Str::limit($donation->title, 50) }}</h5>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <i class="bi bi-tag"></i> {{ $donation->category->name }}
                                    </small>
                                </p>

                                <!-- Description courte -->
                                <p class="card-text">{{ Str::limit($donation->description, 100) }}</p>

                                <!-- Infos supplémentaires -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-geo-alt"></i> {{ $donation->city }}
                                    </span>
                                    <span class="badge bg-info">
                                        <i class="bi bi-box"></i> x{{ $donation->quantity }}
                                    </span>
                                </div>

                                <!-- État -->
                                <div class="mb-3">
                                    <span class="badge condition-badge bg-{{
                                        $donation->condition == 'new' ? 'success' :
                                        ($donation->condition == 'excellent' ? 'primary' : 'info')
                                    }}">
                                        @if($donation->condition == 'new')
                                            <i class="bi bi-star"></i> Neuf
                                        @elseif($donation->condition == 'excellent')
                                            <i class="bi bi-star-half"></i> Très bon
                                        @else
                                            <i class="bi bi-check"></i> Bon
                                        @endif
                                    </span>
                                </div>

                                <!-- Actions -->
                                <div class="d-grid gap-2">
                                    <a href="{{ route('donations.show', $donation) }}"
                                       class="btn btn-outline-primary">
                                        <i class="bi bi-eye"></i> Voir détails
                                    </a>
                                    @if(auth()->check() && auth()->user()->isAssociation())
                                        <form action="{{ route('donations.reserve', $donation) }}"
                                              method="POST" class="d-grid">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-cart-plus"></i> Réserver
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer text-muted">
                                <small>
                                    <i class="bi bi-person"></i> {{ $donation->donor->name }}
                                    • <i class="bi bi-clock"></i> {{ $donation->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $donations->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal pour les images -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endsection
