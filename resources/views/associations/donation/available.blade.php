@extends('layouts.association')

@section('title', 'Dons disponibles - Main Tendue')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar (réutilisez la même que dashboard) -->
        <div class="col-lg-3 col-md-4">
            @include('association.partials.sidebar')
        </div>

        <!-- Main content -->
        <div class="col-lg-9 col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dons disponibles</h2>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fas fa-filter me-2"></i>Filtrer
                    </button>
                </div>
            </div>

            <!-- Filtres rapides -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="btn-group" role="group">
                        <a href="{{ route('association/donation.available') }}?filter=all"
                           class="btn btn-outline-primary {{ !request('filter') || request('filter') == 'all' ? 'active' : '' }}">
                            Tous les dons
                        </a>
                        <a href="{{ route('association/donation.available') }}?filter=near"
                           class="btn btn-outline-primary {{ request('filter') == 'near' ? 'active' : '' }}">
                            Proches de moi
                        </a>
                        <a href="{{ route('association/donation.available') }}?filter=urgent"
                           class="btn btn-outline-danger {{ request('filter') == 'urgent' ? 'active' : '' }}">
                            <i class="fas fa-clock me-1"></i>Urgents
                        </a>
                    </div>
                </div>
            </div>

            <!-- Liste des dons -->
            @if($donations->count() > 0)
                <div class="row">
                    @foreach($donations as $donation)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                @if($donation->images->first())
                                    <img src="{{ asset('storage/' . $donation->images->first()->path) }}"
                                         class="card-img-top"
                                         alt="{{ $donation->title }}"
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                         style="height: 200px;">
                                        <i class="fas fa-gift fa-3x text-muted"></i>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">{{ $donation->title }}</h5>
                                        <span class="badge bg-primary">{{ $donation->category->name ?? 'Non catégorisé' }}</span>
                                    </div>

                                    <p class="card-text text-muted small">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $donation->location ?? 'Non spécifié' }}
                                    </p>

                                    <p class="card-text">{{ Str::limit($donation->description, 100) }}</p>

                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <small class="text-muted">État:</small>
                                            <div>{{ $donation->condition }}</div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Publié:</small>
                                            <div>{{ $donation->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <a href="{{ route('donations.show', $donation) }}"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>Voir détails
                                        </a>

                                        <form action="{{ route('association.donations.accept', $donation) }}"
                                              method="POST"
                                              onsubmit="return confirm('Voulez-vous vraiment accepter ce don ?')">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                <i class="fas fa-check me-1"></i>Accepter le don
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $donations->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-gift fa-4x text-muted mb-4"></i>
                    <h3>Aucun don disponible</h3>
                    <p class="text-muted mb-4">
                        Il n'y a pas de dons disponibles pour le moment.<br>
                        Revenez plus tard ou élargissez vos critères de recherche.
                    </p>
                    <a href="{{ route('association.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Filtres -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('association.donations.available') }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filtrer les dons</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category" class="form-label">Catégorie</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="distance" class="form-label">Distance maximale</label>
                        <select class="form-select" id="distance" name="distance">
                            <option value="">Toutes distances</option>
                            <option value="5" {{ request('distance') == '5' ? 'selected' : '' }}>5 km</option>
                            <option value="10" {{ request('distance') == '10' ? 'selected' : '' }}>10 km</option>
                            <option value="20" {{ request('distance') == '20' ? 'selected' : '' }}>20 km</option>
                            <option value="50" {{ request('distance') == '50' ? 'selected' : '' }}>50 km</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="condition" class="form-label">État</label>
                        <select class="form-select" id="condition" name="condition">
                            <option value="">Tous états</option>
                            <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Neuf</option>
                            <option value="very_good" {{ request('condition') == 'very_good' ? 'selected' : '' }}>Très bon état</option>
                            <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Bon état</option>
                            <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Usé mais fonctionnel</option>
                        </select>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="urgent" name="urgent" value="1" {{ request('urgent') ? 'checked' : '' }}>
                        <label class="form-check-label" for="urgent">
                            <i class="fas fa-clock text-danger me-1"></i>
                            Dons urgents seulement
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Donation Cards */
    .donation-card {
        transition: all 0.3s;
        border: none;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .donation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .donation-card .card-img-top {
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .donation-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .donation-card .card-body {
        padding: 1.25rem;
    }

    .donation-card .card-title {
        color: #2e59d9;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .donation-card .card-text {
        color: #6c757d;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* Badges */
    .donation-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
    }

    .badge-category {
        background: #e3f2fd;
        color: #1565c0;
    }

    .badge-condition-new {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .badge-condition-urgent {
        background: #ffebee;
        color: #c62828;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    /* Filter buttons */
    .filter-btn-group .btn {
        border-radius: 20px;
        padding: 0.5rem 1.25rem;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .filter-btn-group .btn:hover {
        transform: translateY(-2px);
    }

    .filter-btn-group .btn.active {
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(78, 115, 223, 0.25);
    }

    /* Empty state */
    .empty-state {
        padding: 3rem 1rem;
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
    }

    /* Modal filters */
    .filter-modal .modal-content {
        border-radius: 10px;
        border: none;
    }

    .filter-modal .modal-header {
        background: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        border-radius: 10px 10px 0 0;
    }

    .filter-modal .form-check-input:checked {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    /* Map preview (si vous avez une carte) */
    .donation-map {
        height: 150px;
        border-radius: 5px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    /* Distance indicator */
    .distance-indicator {
        display: inline-flex;
        align-items: center;
        font-size: 0.8rem;
        color: #6c757d;
    }

    .distance-indicator .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 5px;
    }

    .distance-near .dot { background: #1cc88a; }
    .distance-medium .dot { background: #f6c23e; }
    .distance-far .dot { background: #e74a3b; }

    /* Responsive grid */
    @media (max-width: 768px) {
        .donation-card .card-img-top {
            height: 150px;
        }

        .filter-btn-group {
            overflow-x: auto;
            flex-wrap: nowrap;
            padding-bottom: 10px;
        }

        .filter-btn-group .btn {
            white-space: nowrap;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtres dynamiques
        const filterButtons = document.querySelectorAll('.filter-btn-group .btn');
        const donationCards = document.querySelectorAll('.donation-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Mettre à jour l'état actif
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('href').split('=')[1] || 'all';

                // Filtrer les cartes
                donationCards.forEach(card => {
                    const cardFilter = card.dataset.filter || 'all';

                    if (filter === 'all' || cardFilter.includes(filter)) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 100);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });

        // Accept donation confirmation
        const acceptForms = document.querySelectorAll('form[action*="accept"]');
        acceptForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir accepter ce don ?')) {
                    e.preventDefault();
                    return false;
                }

                // Afficher un loader sur le bouton
                const button = this.querySelector('button[type="submit"]');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Traitement...';
                button.disabled = true;

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 3000);
            });
        });

        // Calcul des distances (exemple)
        function calculateDistances() {
            const userLat = 48.8566; // Paris (exemple)
            const userLng = 2.3522;

            document.querySelectorAll('.donation-distance').forEach(element => {
                const lat = parseFloat(element.dataset.lat);
                const lng = parseFloat(element.dataset.lng);

                if (!isNaN(lat) && !isNaN(lng)) {
                    const distance = getDistanceFromLatLonInKm(userLat, userLng, lat, lng);
                    element.textContent = `${Math.round(distance)} km`;

                    // Ajouter une classe selon la distance
                    element.classList.remove('distance-near', 'distance-medium', 'distance-far');
                    if (distance < 5) {
                        element.classList.add('distance-near');
                    } else if (distance < 20) {
                        element.classList.add('distance-medium');
                    } else {
                        element.classList.add('distance-far');
                    }
                }
            });
        }

        function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
            const R = 6371; // Rayon de la Terre en km
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a =
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        function deg2rad(deg) {
            return deg * (Math.PI/180);
        }

        // Appeler si les données de distance sont disponibles
        if (document.querySelector('.donation-distance')) {
            calculateDistances();
        }

        // Animation des cartes au chargement
        donationCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Géolocalisation (optionnel)
        if (navigator.geolocation && document.querySelector('#useMyLocation')) {
            document.querySelector('#useMyLocation').addEventListener('click', function() {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        // Mettre à jour les champs de formulaire
                        document.querySelector('#userLat').value = lat;
                        document.querySelector('#userLng').value = lng;

                        // Recharger avec les nouvelles coordonnées
                        window.location.href = window.location.pathname + '?lat=' + lat + '&lng=' + lng;
                    },
                    function(error) {
                        console.error('Erreur de géolocalisation:', error);
                        alert('Impossible d\'obtenir votre position. Vérifiez les permissions.');
                    }
                );
            });
        }
    });
</script>
@endpush

@endsection
