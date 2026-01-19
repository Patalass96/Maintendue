@php
    // Déterminer la couleur du badge d'urgence
    $urgencyColors = [
        'high' => 'danger',
        'medium' => 'warning',
        'low' => 'success'
    ];
    
    // Déterminer le texte du badge d'état
    $conditionTexts = [
        'new' => 'Neuf',
        'excellent' => 'Très bon',
        'good' => 'Bon',
        'fair' => 'Correct'
    ];
    
    $conditionColors = [
        'new' => 'success',
        'excellent' => 'primary',
        'good' => 'info',
        'fair' => 'secondary'
    ];
    
    // URL de l'image (utilise l'accesseur thumbnail de votre modèle)
    $imageUrl = $donation->thumbnail ?? asset('images/default-donation.jpg');
@endphp

<div class="card donation-card h-100 shadow-sm border-0">
    <!-- Badge d'urgence (position absolue) -->
    @if($donation->urgency == 'high')
    <div class="position-absolute top-0 start-0 m-2">
        <span class="badge bg-danger px-2 py-1">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> Urgent
        </span>
    </div>
    @endif
    
    <!-- Badge de statut -->
    @if($donation->status != 'available')
    <div class="position-absolute top-0 end-0 m-2">
        <span class="badge bg-{{ $donation->status == 'reserved' ? 'warning' : 'success' }} px-2 py-1">
            {{ $donation->status == 'reserved' ? 'Réservé' : 'Livré' }}
        </span>
    </div>
    @endif

    <!-- Image du don -->
    <div class="card-img-top position-relative overflow-hidden" style="height: 200px;">
        <img src="{{ $imageUrl }}" 
             class="w-100 h-100 object-fit-cover" 
             alt="{{ $donation->title }}"
             loading="lazy">
        
        <!-- Overlay pour catégorie -->
        <div class="position-absolute bottom-0 start-0 w-100 p-2" 
             style="background: linear-gradient(transparent, rgba(0,0,0,0.7))">
            <span class="badge bg-dark bg-opacity-75">
                <i class="bi bi-tag me-1"></i> {{ $donation->category->name }}
            </span>
        </div>
    </div>

    <!-- Corps de la carte -->
    <div class="card-body d-flex flex-column">
        <!-- Titre -->
        <h5 class="card-title text-truncate mb-2" title="{{ $donation->title }}">
            {{ $donation->title }}
        </h5>
        
        <!-- Description courte -->
        <p class="card-text text-muted small flex-grow-1 mb-3" style="min-height: 40px;">
            {{ Str::limit($donation->description, 80) }}
        </p>
        
        <!-- Métadonnées -->
        <div class="mb-3">
            <!-- Localisation -->
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-geo-alt text-primary me-2"></i>
                <small class="text-muted">{{ $donation->city }}</small>
            </div>
            
            <!-- Quantité et état -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-secondary">
                        <i class="bi bi-box me-1"></i> x{{ $donation->quantity }}
                    </span>
                </div>
                <div>
                    <span class="badge bg-{{ $conditionColors[$donation->condition] ?? 'secondary' }}">
                        {{ $conditionTexts[$donation->condition] ?? $donation->condition }}
                    </span>
                </div>
            </div>
            
            <!-- Urgence (si pas haute, car déjà affichée en badge) -->
            @if($donation->urgency != 'high' && $donation->urgency != 'low')
            <div class="mt-2">
                <small class="text-{{ $urgencyColors[$donation->urgency] ?? 'secondary' }}">
                    <i class="bi bi-clock-history me-1"></i>
                    @if($donation->urgency == 'medium')
                        Urgence moyenne
                    @endif
                </small>
            </div>
            @endif
        </div>
        
        <!-- Donateur -->
        <div class="d-flex align-items-center mb-3 pt-2 border-top">
            <div class="flex-shrink-0">
                <img src="{{ $donation->donor->avatar ? Storage::url($donation->donor->avatar) : asset('images/default-avatar.png') }}" 
                     class="rounded-circle" 
                     width="32" 
                     height="32" 
                     alt="{{ $donation->donor->name }}"
                     style="object-fit: cover;">
            </div>
            <div class="flex-grow-1 ms-2">
                <small class="d-block text-muted">Donateur</small>
                <small class="fw-semibold">{{ $donation->donor->name }}</small>
            </div>
            @if($donation->donor->average_rating)
            <div class="text-warning small">
                {{ number_format($donation->donor->average_rating, 1) }} 
                <i class="bi bi-star-fill"></i>
            </div>
            @endif
        </div>
    </div>

    <!-- Pied de carte avec actions -->
    <div class="card-footer bg-white border-top-0 pt-0">
        <!-- Bouton Voir détails -->
        <a href="{{ route('donations.show', $donation) }}" 
           class="btn btn-outline-primary btn-sm w-100 mb-2">
            <i class="bi bi-eye me-1"></i> Voir détails
        </a>
        
        <!-- Bouton Réserver (uniquement pour les associations et si disponible) -->
        @auth
            @if(auth()->user()->isAssociation() && $donation->status == 'available')
                @if($donation->city == auth()->user()->city || $donation->urgency == 'high')
                <form action="{{ route('donations.reserve', $donation) }}" method="POST" 
                      class="reservation-form" data-donation-id="{{ $donation->id }}">
                    @csrf
                    <button type="submit" 
                            class="btn btn-success btn-sm w-100 btn-reserve"
                            data-donation-title="{{ $donation->title }}">
                        <i class="bi bi-cart-plus me-1"></i> Réserver
                    </button>
                </form>
                @else
                <button class="btn btn-outline-secondary btn-sm w-100" disabled 
                        title="Ce don n'est pas dans votre ville">
                    <i class="bi bi-geo-alt me-1"></i> Hors zone
                </button>
                @endif
            @endif
            
            <!-- Indicateur pour le donateur que c'est son don -->
            @if(auth()->id() == $donation->donor_id)
            <div class="text-center mt-2">
                <span class="badge bg-info">
                    <i class="bi bi-person-check me-1"></i> Votre don
                </span>
            </div>
            @endif
        @else
            <!-- Lien de connexion pour les non-authentifiés -->
            <a href="{{ route('login') }}?redirect={{ url()->current() }}" 
               class="btn btn-outline-primary btn-sm w-100">
                <i class="bi bi-box-arrow-in-right me-1"></i> Connectez-vous
            </a>
        @endauth
        
        <!-- Date de publication -->
        <div class="text-center mt-2">
            <small class="text-muted">
                <i class="bi bi-calendar3 me-1"></i>
                {{ $donation->created_at->diffForHumans() }}
            </small>
        </div>
    </div>
</div>

{{-- Version mobile-first avec breakpoints --}}
<div class="card donation-card h-100">
    <div class="row g-0 h-100">
        <!-- Image sur mobile, en haut sur desktop -->
        <div class="col-md-4">
            <img src="{{ $imageUrl }}" 
                 class="img-fluid rounded-start h-100 w-100 object-fit-cover" 
                 alt="{{ $donation->title }}">
        </div>
        
        <!-- Contenu -->
        <div class="col-md-8">
            <div class="card-body h-100 d-flex flex-column">
                <!-- En-tête -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="card-title mb-0">{{ Str::limit($donation->title, 40) }}</h6>
                    <span class="badge bg-{{ $urgencyColors[$donation->urgency] }} ms-2">
                        {{ $donation->urgency == 'high' ? '!' : '' }}
                    </span>
                </div>
                
                <!-- Catégorie et ville -->
                <div class="mb-2">
                    <span class="badge bg-secondary bg-opacity-25 text-dark me-1">
                        {{ $donation->category->name }}
                    </span>
                    <small class="text-muted">
                        <i class="bi bi-geo-alt"></i> {{ $donation->city }}
                    </small>
                </div>
                
                <!-- Description courte -->
                <p class="card-text small text-muted flex-grow-1 mb-2">
                    {{ Str::limit($donation->description, 60) }}
                </p>
                
                <!-- Métadonnées en ligne -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-light text-dark border">
                        x{{ $donation->quantity }}
                    </span>
                    <span class="badge bg-{{ $conditionColors[$donation->condition] }}">
                        {{ $conditionTexts[$donation->condition] }}
                    </span>
                    <small class="text-muted">
                        {{ $donation->created_at->diffForHumans() }}
                    </small>
                </div>
                
                <!-- Actions -->
                <div class="mt-auto">
                    <div class="d-grid gap-2">
                        <a href="{{ route('donations.show', $donation) }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye"></i> Détails
                        </a>
                        
                        @auth
                            @if(auth()->user()->isAssociation() && $donation->status == 'available')
                            <form action="{{ route('donations.reserve', $donation) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="bi bi-cart-plus"></i> Réserver
                                </button>
                            </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.donation-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.donation-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    border-color: #dee2e6;
}

.card-img-top {
    transition: transform 0.5s ease;
}

.donation-card:hover .card-img-top {
    transform: scale(1.05);
}

.btn-reserve {
    transition: all 0.2s ease;
}

.btn-reserve:hover:not(:disabled) {
    transform: scale(1.02);
}

.object-fit-cover {
    object-fit: cover;
}
</style>

<script>
// Script pour gérer la réservation avec confirmation
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-reserve').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const donationTitle = this.getAttribute('data-donation-title');
            const form = this.closest('form');
            
            if (confirm(`Confirmez-vous la réservation du don : "${donationTitle}" ?`)) {
                // Ajouter un indicateur de chargement
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Réservation...';
                this.disabled = true;
                
                // Soumettre le formulaire
                form.submit();
            }
        });
    });
    
    // Animation lors de l'ajout d'une nouvelle carte (pour Livewire/Echo)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1 && node.classList && node.classList.contains('donation-card')) {
                    node.style.opacity = '0';
                    node.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        node.style.transition = 'all 0.5s ease';
                        node.style.opacity = '1';
                        node.style.transform = 'translateY(0)';
                    }, 10);
                }
            });
        });
    });
    
    // Observer les changements dans le conteneur de dons
    const donationsContainer = document.querySelector('.row'); // Adaptez le sélecteur
    if (donationsContainer) {
        observer.observe(donationsContainer, { childList: true, subtree: true });
    }
});
</script>