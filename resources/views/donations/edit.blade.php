@extends('layouts.layout.donapp')

@section('title', 'Modifier mon don - ' . $donation->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8 animateanimated animatefadeIn">
            <!-- Bouton Retour -->
            <div class="mb-4">
                <a href="{{ route('donations.show', $donation) }}" class="text-decoration-none text-muted hover-primary">
                    <i class="fas fa-arrow-left me-2"></i> Retour au don
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <!-- En-tête -->
                <div class="card-header border-0 py-4 px-4 bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary-subtle text-primary p-3 rounded-circle me-3">
                            <i class="fas fa-edit fa-lg"></i>
                        </div>
                        <div>
                            <h2 class="h4 mb-1 fw-800">Modifier mon don</h2>
                            <p class="mb-0 text-muted small">Mettez à jour les informations de votre annonce solidaires.</p>
                        </div>
                    </div>
                </div>
<div class="card-body p-4 p-md-5">
                    <form action="{{ route('donations.update', $donation) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Section 1 : Informations de base -->
                        <div class="form-section mb-5">
                            <h5 class="fw-700 mb-4 text-dark d-flex align-items-center">
                                <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px; font-size: 0.8rem;">1</span>
                                Informations générales
                            </h5>

                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold small text-uppercase tracking-wider">Titre de l'annonce</label>
                                <input type="text" name="title" id="title" class="form-control rounded-3 py-2 @error('title') is-invalid @enderror"
                                       placeholder="Ex: Sac à dos scolaire en bon état" value="{{ old('title', $donation->title) }}" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-0">
                                <label for="description" class="form-label fw-bold small text-uppercase tracking-wider">Description</label>
                                <textarea name="description" id="description" rows="5" class="form-control rounded-3 @error('description') is-invalid @enderror"
                                          placeholder="Décrivez l'objet plus en détail..." required>{{ old('description', $donation->description) }}</textarea>
@error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Section 2 : Catégorie & Caractéristiques -->
                        <div class="form-section mb-5">
                            <h5 class="fw-700 mb-4 text-dark d-flex align-items-center">
                                <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px; font-size: 0.8rem;">2</span>
                                Détails de l'article
                            </h5>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="category_id" class="form-label fw-bold small text-uppercase tracking-wider">Catégorie</label>
                                    <select name="category_id" id="category_id" class="form-select rounded-3 py-2 @error('category_id') is-invalid @enderror" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $donation->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
<div class="col-md-6">
                                    <label for="condition" class="form-label fw-bold small text-uppercase tracking-wider">État</label>
                                    <select name="condition" id="condition" class="form-select rounded-3 py-2 @error('condition') is-invalid @enderror" required>
                                        <option value="new" {{ old('condition', $donation->condition) == 'new' ? 'selected' : '' }}>Neuf</option>
                                        <option value="excellent" {{ old('condition', $donation->condition) == 'excellent' ? 'selected' : '' }}>Excellent état</option>
                                        <option value="good" {{ old('condition', $donation->condition) == 'good' ? 'selected' : '' }}>Bon état</option>
                                        <option value="fair" {{ old('condition', $donation->condition) == 'fair' ? 'selected' : '' }}>État moyen</option>
                                    </select>
                                    @error('condition') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="quantity" class="form-label fw-bold small text-uppercase tracking-wider">Quantité</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control rounded-3 py-2" value="{{ old('quantity', $donation->quantity) }}" min="1">
                                </div>

                                <div class="col-md-4">
                                    <label for="size" class="form-label fw-bold small text-uppercase tracking-wider">Taille (Optionnel)</label>
                                    <input type="text" name="size" id="size" class="form-control rounded-3 py-2" placeholder="Ex: L, 42, A4" value="{{ old('size', $donation->size) }}">
                                </div>
<div class="col-md-4">
                                    <label for="urgency" class="form-label fw-bold small text-uppercase tracking-wider">Niveau d'urgence</label>
                                    <select name="urgency" id="urgency" class="form-select rounded-3 py-2">
                                        <option value="low" {{ $donation->urgency == 'low' ? 'selected' : '' }}>Faible</option>
                                        <option value="medium" {{ $donation->urgency == 'medium' ? 'selected' : '' }}>Normale</option>
                                        <option value="high" {{ $donation->urgency == 'high' ? 'selected' : '' }}>Haute</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3 : Photos existantes et Nouvelles -->
                        <div class="form-section mb-5">
                            <h5 class="fw-700 mb-4 text-dark d-flex align-items-center">
                                <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px; font-size: 0.8rem;">3</span>
                                Gestion des images
                            </h5>

                            <!-- Images actuelles -->
                            @if($donation->images->count() > 0)
                            <div class="mb-4">
Fulbert — 19:42
<label class="form-label fw-bold small text-uppercase tracking-wider mb-3">Images actuelles (Cochez pour supprimer)</label>
                                <div class="row g-3">
                                    @foreach($donation->images as $image)
                                    <div class="col-4 col-md-3">
                                        <div class="position-relative existing-image-wrapper">
                                            <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded-3 border" style="height: 100px; width: 100%; object-fit: cover;">
                                            <div class="position-absolute top-0 end-0 m-1">
                                                <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="form-check-input bg-danger border-white shadow-sm">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="upload-zone p-4 border-2 border-dashed rounded-4 text-center bg-light transition-all hover-white">
                                <div class="icon-container mb-3 text-primary">
                                    <i class="fas fa-images fa-3x opacity-50"></i>
                                </div>
                                <h6 class="fw-bold">Ajouter de nouvelles photos</h6>
                                <p class="text-muted small mb-3">Cliquez ou glissez-déposez vos fichiers ici</p>
                                <input type="file" name="images[]" id="images" class="form-control @error('images.') is-invalid @enderror" multiple accept="image/">
                                @error
('images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Section 4 : Localisation & Remise -->
                        <div class="form-section mb-5">
                            <h5 class="fw-700 mb-4 text-dark d-flex align-items-center">
                                <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px; font-size: 0.8rem;">4</span>
                                Logistique
                            </h5>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="city" class="form-label fw-bold small text-uppercase tracking-wider">Ville</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-map-marker-alt text-primary opacity-50"></i></span>
                                        <input type="text" name="city" id="city" class="form-control rounded-end-3 py-2" placeholder="Ex: Lomé, Atakpamé..." value="{{ old('city', $donation->city) }}" required>
                                    </div>
                                </div>
<div class="col-md-6">
                                    <label class="form-label fw-bold small text-uppercase tracking-wider">Mode de remise</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check custom-radio-pill flex-fill">
                                            <input class="btn-check" type="radio" name="delivery_method" id="method_point" value="collection_point"
                                                   {{ old('delivery_method', $donation->delivery_method) == 'collection_point' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary w-100 rounded-pill py-2" for="method_point">Point Collecte</label>
                                        </div>
                                        <div class="form-check custom-radio-pill flex-fill">
                                            <input class="btn-check" type="radio" name="delivery_method" id="method_direct" value="direct"
                                                   {{ old('delivery_method', $donation->delivery_method) == 'direct' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary w-100 rounded-pill py-2" for="method_direct">Remise Directe</label>
                                        </div>
                                    </div>
                                </div>
<div class="col-12" id="collection_point_selector" style="{{ old('delivery_method', $donation->delivery_method) == 'direct' ? 'display:none;' : '' }}">
                                    <label for="collection_point_id" class="form-label fw-bold small text-uppercase tracking-wider">Choisir le point de relais</label>
                                    <select name="collection_point_id" id="collection_point_id" class="form-select rounded-3 py-2">
                                        <option value="" disabled {{ !$donation->collection_point_id ? 'selected' : '' }}>Choisir un point...</option>
                                        @foreach($collectionPoints as $point)
                                            <option value="{{ $point->id }}" {{ old('collection_point_id', $donation->collection_point_id) == $point->id ? 'selected' : '' }}>
                                                {{ $point->name }} - {{ $point->address }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Actions finales -->
                        <div class="d-grid gap-3 pt-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold shadow-sm hover-scale">
                                <i class="fas fa-check-circle me-2"></i> Enregistrer les modifications
                            </button>
                            <a href="{{ route('donations.show', $donation) }}" class="btn btn-link text-muted text-decoration-none small text-center">
                                Annuler les changements
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    .fw-800 { font-weight: 800; }
    .fw-700 { font-weight: 700; }

    .bg-primary-subtle { background-color: #e0f2fe; }

    .upload-zone {
        border: 2px dashed #e2e8f0;
        cursor: pointer;
    }

    .upload-zone:hover {
        border-color: var(--primary-color);
        background-color: #fff !important;
    }

    .hover-white:hover { background-color: #fff !important; }

    .hover-scale {
        transition: transform 0.2s;
    }
    .hover-scale:hover {
        transform: scale(1.02);
    }

    .existing-image-wrapper:hover img {
        filter: brightness(0.7);
    }
    .existing-image-wrapper input[type="checkbox"] {
        cursor: pointer;
        transform: scale(1.5);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
    }

    .hover-primary:hover {
        color: var(--primary-color) !important;
    }

    /* Custom Radio Buttons using Bootstrap btn-check */
    .btn-check:checked + .btn-outline-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle collect point selector
        const methodRadios = document.querySelectorAll('input[name="delivery_method"]');
        const pointSelector = document.getElementById('collection_point_selector');

        methodRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'collection_point') {
                    pointSelector.style.display = 'block';
                    pointSelector.classList.add('animateanimated', 'animatefadeIn');
                } else {
                    pointSelector.style.display = 'none';
                }
            });
        });

        // Optional: Custom file input feedback would go here
    });
</script>
@endpush
@endsection
