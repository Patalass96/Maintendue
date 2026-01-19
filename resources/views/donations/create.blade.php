@extends('layouts/layout.donapp')

@section('title', 'Publier un don')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-gift"></i> Publier un don</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('donations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Section 1: Informations générales -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Informations générales</h5>
                        
                        <!-- Titre -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Titre du don *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Donnez un titre clair et descriptif</small>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Décrivez précisément ce que vous donnez</small>
                        </div>
                    </div>

                    <!-- Section 2: Catégorie et état -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Catégorie et état</h5>
                        
                        <div class="row">
                            <!-- Catégorie -->
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label fw-bold">Catégorie *</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required>
                                    <option value="">Sélectionnez une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- État -->
                            <div class="col-md-6 mb-3">
                                <label for="condition" class="form-label fw-bold">État *</label>
                                <select class="form-select @error('condition') is-invalid @enderror" 
                                        id="condition" name="condition" required>
                                    <option value="">Sélectionnez l'état</option>
                                    <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Neuf</option>
                                    <option value="excellent" {{ old('condition') == 'excellent' ? 'selected' : '' }}>Très bon</option>
                                    <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Bon</option>
                                    <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Correct</option>
                                </select>
                                @error('condition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Détails sur l'état -->
                        <div class="mb-3">
                            <label for="condition_detail" class="form-label fw-bold">Détails sur l'état</label>
                            <textarea class="form-control @error('condition_detail') is-invalid @enderror" 
                                      id="condition_detail" name="condition_detail" rows="2">{{ old('condition_detail') }}</textarea>
                            @error('condition_detail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Ex: Légères égratignures, manque un bouton, etc.</small>
                        </div>
                    </div>

                    <!-- Section 3: Caractéristiques spécifiques -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Caractéristiques spécifiques</h5>
                        
                        <div class="row">
                            <!-- Quantité -->
                            <div class="col-md-4 mb-3">
                                <label for="quantity" class="form-label fw-bold">Quantité *</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                       id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Taille -->
                            <div class="col-md-4 mb-3">
                                <label for="size" class="form-label fw-bold">Taille</label>
                                <input type="text" class="form-control @error('size') is-invalid @enderror" 
                                       id="size" name="size" value="{{ old('size') }}">
                                @error('size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Ex: M, 42, L, etc.</small>
                            </div>

                            <!-- Genre -->
                            <div class="col-md-4 mb-3">
                                <label for="gender" class="form-label fw-bold">Genre</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Non spécifié</option>
                                    <option value="men" {{ old('gender') == 'men' ? 'selected' : '' }}>Homme</option>
                                    <option value="women" {{ old('gender') == 'women' ? 'selected' : '' }}>Femme</option>
                                    <option value="unisex" {{ old('gender') == 'unisex' ? 'selected' : '' }}>Unisexe</option>
                                    <option value="kids" {{ old('gender') == 'kids' ? 'selected' : '' }}>Enfant</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Niveau scolaire (pour les fournitures) -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="school_level" class="form-label fw-bold">Niveau scolaire</label>
                                <select class="form-select @error('school_level') is-invalid @enderror" id="school_level" name="school_level">
                                    <option value="">Non spécifié</option>
                                    <option value="maternelle" {{ old('school_level') == 'maternelle' ? 'selected' : '' }}>Maternelle</option>
                                    <option value="primaire" {{ old('school_level') == 'primaire' ? 'selected' : '' }}>Primaire</option>
                                    <option value="college" {{ old('school_level') == 'college' ? 'selected' : '' }}>Collège</option>
                                    <option value="lycee" {{ old('school_level') == 'lycee' ? 'selected' : '' }}>Lycée</option>
                                    <option value="superieur" {{ old('school_level') == 'superieur' ? 'selected' : '' }}>Supérieur</option>
                                </select>
                                @error('school_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                                                       <!-- Type d'article -->
                            <div class="col-md-6 mb-3">
                                <label for="item_type" class="form-label fw-bold">Type d'article</label>
                                <input type="text" class="form-control @error('item_type') is-invalid @enderror" 
                                       id="item_type" name="item_type" value="{{ old('item_type') }}">
                                @error('item_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Ex: Cahiers, Stylos, Pantalon, etc.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Localisation et logistique -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Localisation et logistique</h5>
                        
                        <div class="row">
                            <!-- Ville -->
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label fw-bold">Ville *</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city', auth()->user()->city ?? '') }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Urgence -->
                            <div class="col-md-6 mb-3">
                                <label for="urgency" class="form-label fw-bold">Niveau d'urgence *</label>
                                <select class="form-select @error('urgency') is-invalid @enderror" id="urgency" name="urgency" required>
                                    <option value="">Sélectionnez l'urgence</option>
                                    <option value="low" {{ old('urgency') == 'low' ? 'selected' : '' }}>Faible</option>
                                    <option value="medium" {{ old('urgency') == 'medium' ? 'selected' : '' }}>Moyen</option>
                                    <option value="high" {{ old('urgency') == 'high' ? 'selected' : '' }}>Élevé</option>
                                </select>
                                @error('urgency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Adresse complète -->
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold">Adresse complète</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="2">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 5: Mode de remise -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Mode de remise</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Comment souhaitez-vous remettre le don ? *</label>
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="delivery_method" 
                                       id="direct" value="direct" {{ old('delivery_method') == 'direct' ? 'checked' : 'checked' }}>
                                <label class="form-check-label" for="direct">
                                    <strong>Remise directe</strong> - Je rencontre l'association pour remettre le don
                                </label>
                            </div>
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="delivery_method" 
                                       id="collection_point" value="collection_point" {{ old('delivery_method') == 'collection_point' ? 'checked' : '' }}>
                                <label class="form-check-label" for="collection_point">
                                    <strong>Point de collecte</strong> - Je dépose le don à un point de collecte
                                </label>
                            </div>
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="delivery_method" 
                                       id="both" value="both" {{ old('delivery_method') == 'both' ? 'checked' : '' }}>
                                <label class="form-check-label" for="both">
                                    <strong>Les deux options</strong> - Je suis ouvert aux deux modes de remise
                                </label>
                            </div>
                            @error('delivery_method')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Point de collecte (conditionnel) -->
                        <div id="collectionPointSection" class="mb-3" style="display: none;">
                            <label for="collection_point_id" class="form-label fw-bold">Sélectionnez un point de collecte</label>
                            <select class="form-select @error('collection_point_id') is-invalid @enderror" 
                                    id="collection_point_id" name="collection_point_id">
                                <option value="">Choisissez un point de collecte</option>
                                @foreach($collectionPoints as $point)
                                    <option value="{{ $point->id }}" 
                                            {{ old('collection_point_id') == $point->id ? 'selected' : '' }}>
                                        {{ $point->name }} - {{ $point->address }}
                                    </option>
                                @endforeach
                            </select>
                            @error('collection_point_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date de rendez-vous (conditionnel) -->
                        <div id="meetingDateSection" class="mb-3" style="display: none;">
                            <label for="meeting_date" class="form-label fw-bold">Date de rendez-vous proposée</label>
                            <input type="datetime-local" class="form-control @error('meeting_date') is-invalid @enderror" 
                                   id="meeting_date" name="meeting_date" value="{{ old('meeting_date') }}">
                            @error('meeting_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 6: Images -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Images du don</h5>
                        
                        <div class="mb-3">
                            <label for="images" class="form-label fw-bold">Ajoutez des photos</label>
                            <input type="file" class="form-control @error('images') is-invalid @enderror" 
                                   id="images" name="images[]" multiple accept="image/*">
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Taille max: 5MB par image. Formats acceptés: JPG, PNG, GIF</div>
                        </div>

                        <!-- Prévisualisation des images -->
                        <div id="imagePreview" class="row g-2 mb-3"></div>
                    </div>

                    <!-- Section 7: Options supplémentaires -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Options supplémentaires</h5>
                        
                        <!-- Date d'expiration (pour denrées alimentaires) -->
                        <div class="mb-3">
                            <label for="expiration_date" class="form-label fw-bold">Date d'expiration</label>
                            <input type="date" class="form-control @error('expiration_date') is-invalid @enderror" 
                                   id="expiration_date" name="expiration_date" value="{{ old('expiration_date') }}">
                            @error('expiration_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Renseignez uniquement pour les denrées alimentaires</small>
                        </div>

                        <!-- Cibler une association spécifique -->
                        <div class="mb-3">
                            <label for="association_id" class="form-label fw-bold">Cibler une association spécifique (optionnel)</label>
                            <select class="form-select @error('association_id') is-invalid @enderror" 
                                    id="association_id" name="association_id">
                                <option value="">Toutes les associations</option>
                                @foreach($associations as $association)
                                    <option value="{{ $association->id }}" 
                                            {{ old('association_id') == $association->id ? 'selected' : '' }}>
                                        {{ $association->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('association_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Si vous souhaitez que votre don soit visible uniquement par une association particulière</small>
                        </div>

                        <!-- Publication programmée -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="schedule_publication" name="schedule_publication">
                            <label class="form-check-label" for="schedule_publication">
                                Publier plus tard (dans 24h)
                            </label>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('donations.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle"></i> Publier le don
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Aide contextuelle -->
        <div class="card mt-3">
            <div class="card-body bg-light">
                <h6><i class="bi bi-info-circle"></i> Conseils pour une bonne publication</h6>
                <ul class="mb-0">
                    <li><small>Prenez des photos claires et sous différents angles</small></li>
                    <li><small>Soyez précis dans la description de l'état</small></li>
                    <li><small>Indiquez votre disponibilité pour la remise</small></li>
                    <li><small>Une publication complète augmente vos chances</small></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript pour la gestion dynamique du formulaire -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des modes de remise
    const deliveryMethodRadios = document.querySelectorAll('input[name="delivery_method"]');
    const collectionPointSection = document.getElementById('collectionPointSection');
    const meetingDateSection = document.getElementById('meetingDateSection');
    
    function toggleDeliverySections() {
        const selectedValue = document.querySelector('input[name="delivery_method"]:checked').value;
        
        // Point de collecte
        if (selectedValue === 'collection_point' || selectedValue === 'both') {
            collectionPointSection.style.display = 'block';
        } else {
            collectionPointSection.style.display = 'none';
        }
        
        // Date de rendez-vous (pour remise directe)
        if (selectedValue === 'direct' || selectedValue === 'both') {
            meetingDateSection.style.display = 'block';
        } else {
            meetingDateSection.style.display = 'none';
        }
    }
    
    // Écouter les changements
    deliveryMethodRadios.forEach(radio => {
        radio.addEventListener('change', toggleDeliverySections);
    });
    
    // Initialiser
    toggleDeliverySections();
    
    // Prévisualisation des images
    const imageInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');
    
    imageInput.addEventListener('change', function() {
        imagePreview.innerHTML = '';
        
        Array.from(this.files).forEach((file, index) => {
            if (index >= 6) return; // Limite à 6 images
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-4 col-md-3';
                col.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-thumbnail w-100" style="height: 100px; object-fit: cover;">
                        <button type="button" class="btn-close position-absolute top-0 end-0 bg-white" 
                                onclick="removeImage(${index})" style="font-size: 0.6rem;"></button>
                    </div>
                `;
                imagePreview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });
    
    // Auto-remplir la ville depuis le profil
    const cityInput = document.getElementById('city');
    if (cityInput.value === '' && window.userCity) {
        cityInput.value = window.userCity;
    }
    
    // Validation en temps réel
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
});

// Fonction pour retirer une image
function removeImage(index) {
    const dt = new DataTransfer();
    const input = document.getElementById('images');
    const { files } = input;
    
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (index !== i) dt.items.add(file);
    }
    
    input.files = dt.files;
    input.dispatchEvent(new Event('change'));
}

// Inclure la ville utilisateur dans window (si disponible)
@if(auth()->check() && auth()->user()->city)
    window.userCity = "{{ auth()->user()->city }}";
@endif
</script>

<style>
/* Styles pour la prévisualisation d'images */
#imagePreview img {
    transition: transform 0.3s;
}

#imagePreview img:hover {
    transform: scale(1.05);
}

/* Styles pour les sections conditionnelles */
#collectionPointSection, #meetingDateSection {
    transition: all 0.3s ease;
    overflow: hidden;
}

/* Responsive */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .form-label.fw-bold {
        font-size: 0.9rem;
    }
}
</style>
@endsection