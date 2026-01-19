@extends('layouts.layout.donapp')

@section('title', $donation->title)

@section('content')
    <div class="donation-detail py-5 bg-white">
        <div class="container mt-4">
            <!-- Fil d'ariane / Back button -->
            <nav aria-label="breadcrumb" class="mb-4 animateanimated animatefadeIn">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('donations.index') }}"
                            class="text-decoration-none text-muted"><i class="fas fa-arrow-left me-2"></i>Retour aux
                            dons</a></li>
                    <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">
                        {{ Str::limit($donation->title, 30) }}
                    </li>
                </ol>
            </nav>

            <div class="row g-5">
                <!-- Colonne de Gauche : Images et Détails -->
                <div class="col-lg-8 animateanimated animatefadeInLeft">
                    <!-- Galerie d'images -->
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                        <div class="main-image-container position-relative">
                            <img src="{{ asset('storage/' . ($donation->primaryImage->path ?? 'donations/default.png')) }}"
                                class="img-fluid w-100" style="max-height: 500px; object-fit: cover;"
                                alt="{{ $donation->title }}" id="mainDonationImage">
                            <div class="badge-overlay position-absolute top-0 start-0 m-4">
                                <span class="badge bg-primary text-white rounded-pill px-3 py-2 shadow-lg fw-bold">
                                    {{ $donation->category->name }}
                                </span>
                            </div>

                            @if ($donation->urgency && $donation->urgency !== 'normal')
                                <div class="position-absolute top-0 end-0 m-4">
                                    <span
                                        class="badge bg-danger text-white rounded-pill px-3 py-2 shadow-lg fw-bold animateanimated animatepulse animate__infinite">
                                        <i class="fas fa-exclamation-circle me-1"></i> Urgent
                                    </span>
                                </div>
                            @endif
                        </div>

                        @if ($donation->images->count() > 1)
                            <div class="thumbnails-container d-flex gap-2 p-3 bg-light custom-scrollbar overflow-auto">
                                @foreach ($donation->images as $image)
                                    <div class="thumbnail-item {{ $image->is_primary ? 'active' : '' }}"
                                        onclick="changeMainImage('{{ asset('storage/' . $image->path) }}', this)">
                                        <img src="{{ asset('storage/' . $image->path) }}" class="rounded-3 border"
                                            style="width: 80px; height: 60px; object-fit: cover; cursor: pointer;">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="details-section">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h1 class="fw-800 text-dark mb-0">{{ $donation->title }}</h1>
                            <div class="action-buttons d-flex gap-2">
                                <button class="btn btn-light rounded-circle shadow-sm" title="Partager">
                                    <i class="fas fa-share-alt text-primary"></i>
                                </button>
                                <button class="btn btn-light rounded-circle shadow-sm" title="Signaler">
                                    <i class="fas fa-flag text-danger opacity-50"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-4 mb-5 pb-4 border-bottom">
                            <div class="info-item d-flex align-items-center">
                                <div class="icon-box bg-primary-subtle rounded-circle p-3 me-3">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Localisation</p>
                                    <p class="fw-bold mb-0 text-dark">{{ $donation->city }}</p>
                                </div>
                            </div>
                            <div class="info-item d-flex align-items-center">
                                <div class="icon-box bg-success-subtle rounded-circle p-3 me-3">
                                    <i class="fas fa-tag text-success"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">État</p>
                                    <p class="fw-bold mb-0 text-dark">{{ ucfirst($donation->condition) }}</p>
                                </div>
                            </div>
                            <div class="info-item d-flex align-items-center">
                                <div class="icon-box bg-purple-subtle rounded-circle p-3 me-3"
                                    style="background-color: #f3e8ff;">
                                    <i class="fas fa-clock text-purple" style="color: #9333ea;"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Publié il y a</p>
                                    <p class="fw-bold mb-0 text-dark">{{ $donation->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="description-content mb-5">
                            <h4 class="fw-700 mb-3 text-dark">Description du don</h4>
                            <div class="text-muted leading-relaxed" style="font-size: 1.1rem;">
                                {!! nl2br(e($donation->description)) !!}
                            </div>
                        </div>

                        <div class="additional-info grid gap-4 mb-5 d-flex flex-wrap">
                            @if ($donation->quantity)
                                <div class="info-card bg-light p-3 rounded-4 flex-fill border">
                                    <p class="text-muted small mb-1">Quantité</p>
                                    <p class="fw-bold text-dark mb-0">{{ $donation->quantity }}</p>
                                </div>
                            @endif
                            @if ($donation->gender)
                                <div class="info-card bg-light p-3 rounded-4 flex-fill border">
                                    <p class="text-muted small mb-1">Genre cible</p>
                                    <p class="fw-bold text-dark mb-0">{{ ucfirst($donation->gender) }}</p>
                                </div>
                            @endif
                            @if ($donation->size)
                                <div class="info-card bg-light p-3 rounded-4 flex-fill border">
                                    <p class="text-muted small mb-1">Taille</p>
                                    <p class="fw-bold text-dark mb-0">{{ $donation->size }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 animateanimated animatefadeInRight">
                    <div class="sticky-top" style="top: 100px;">
                        <!-- Carte Donateur -->
                        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                            <h5 class="fw-bold mb-4">À propos du donateur</h5>
                            <div class="donor-profile d-flex align-items-center mb-4">
                                <div class="position-relative">
                                    <img src="{{ $donation->donor->profile_photo_url ?? asset('assets/images/default-avatar.png') }}"
                                        class="rounded-circle border p-1" width="64" height="64" alt="Donor">
                                    <span
                                        class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle p-1"
                                        style="width: 15px; height: 15px;" title="En ligne"></span>
                                </div>
                                <div class="ms-3">
                                    <h6 class="fw-bold mb-1 text-dark">{{ $donation->donor->name }}</h6>
                                    <p class="text-muted small mb-0"><i
                                            class="fas fa-check-circle text-success me-1"></i>Profil vérifié</p>
                                </div>
                            </div>

                            <div class="donor-stats d-flex justify-content-between mb-4 bg-light p-3 rounded-3">
                                <div class="text-center">
                                    <p class="text-muted small mb-1">Dons faits</p>
                                    <p class="fw-bold text-primary mb-0">{{ $donation->donor->donations_count ?? 0 }}</p>
                                </div>
                                <div class="text-center px-3 border-start border-end">
                                    <p class="text-muted small mb-1">Ville</p>
                                    <p class="fw-bold text-primary mb-0">{{ $donation->donor->city ?? $donation->city }}
                                    </p>
                                </div>
                                <div class="text-center">
                                    <p class="text-muted small mb-1">Inscrit le</p>
                                    <p class="fw-bold text-primary mb-0">{{ $donation->donor->created_at->format('M Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="d-grid gap-3">
                                @auth
                                    @if (auth()->user()->role === 'association')
                                        <form action="{{ route('donations.reserve', $donation) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow hover-scale">
                                                <i class="fas fa-hand-holding-heart me-2"></i> Faire une demande
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-info py-2 rounded-3 small">
                                            <i class="fas fa-info-circle me-2"></i>Seules les associations peuvent demander ce
                                            don.
                                        </div>
                                    @endif

                                    <form action="{{ route('conversations.start', $donation) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-outline-primary w-100 rounded-pill py-2 fw-bold">
                                            <i class="fas fa-comment-dots me-2"></i> Envoyer un message
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary w-100 rounded-pill py-3 fw-bold">
                                        Se connecter pour demander
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Sécurite / Tips -->
               <div class="card bg-light rounded-4 p-4 shadow-sm border-start border-4 border-warning">

                            <h6 class="fw-bold"><i class="fas fa-shield-alt text-warning me-2"></i>Conseils de sécurité
                            </h6>
                            <ul class="text-muted small mb-0 ps-3 mt-3">
                                <li class="mb-2">Privilégiez les lieux publics pour la remise du don.</li>
                                <li class="mb-2">Vérifiez l'état de l'article dès réception.</li>
                                <li>Ne communiquez jamais vos informations bancaires.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="similar-donations mt-5 pt-5 border-top">
                <h3 class="fw-800 text-dark mb-4">Articles similaires</h3>
                <div class="row g-4">
                    @foreach ($similarDonations ?? [] as $similar)
                        <div class="col-md-3">
                            @include('donations._card', [
                                'donation' => $similar,
                                'delay' => $loop->index * 0.1,
                            ])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <style>
            .fw-800 {
                font-weight: 800;
            }

            .fw-700 {
                font-weight: 700;
            }

            .thumbnail-item {
                opacity: 0.6;
                transition: all 0.3s;
            }

            .thumbnail-item:hover,
            .thumbnail-item.active {
                opacity: 1;
                transform: translateY(-2px);
            }

            .thumbnail-item.active img {
                border-color: var(--primary-color) !important;
                box-shadow: 0 0 10px rgba(14, 165, 233, 0.2);
            }

            .main-image-container {
                cursor: zoom-in;
            }

            .hover-scale {
                transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            .hover-scale:hover {
                transform: scale(1.05);
            }

            .info-card {
                min-width: 150px;
                transition: all 0.3s;
            }

            .info-card:hover {
                background-color: #fff !important;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            }

            .bg-purple-subtle {
                background-color: #f3e8ff;
            }

            /* Scrollbar pour les miniatures */
            .custom-scrollbar::-webkit-scrollbar {
                height: 6px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 10px;
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            function changeMainImage(src, element) {
                document.getElementById('mainDonationImage').src = src;
                // Update active class
                document.querySelectorAll('.thumbnail-item').forEach(el => el.classList.remove('active'));
                element.classList.add('active');
            }
        </script>
    @endpush

@endsection
