@extends('layouts.app')

@section('title', 'MAIN TENDUE - Donner, c\'est changer une vie')

@section('styles')
    @vite(['resources/css/home.css', 'resources/css/app.css','resources/js/home.js'])
@endsection

@section('content')
<section class="hero-section">
    <div class="hero-carousel" id="heroCarousel">
        
        <div class="carousel-slide active" style="background: url({{ asset('assets/images/hero/ong_1.jpg') }}) no-repeat; background-size: cover; background-position: center;">
            <div class="slide-overlay"></div>
            <div class="container">
                <div class="slide-content">
                    <h1>Donner, c'est changer une vie</h1>
                    <p class="lead">
                        MAIN TENDUE connecte les donneurs, les associations et les bénéficiaires 
                        pour redistribuer efficacement les dons essentiels.<br>Ne laissez plus vos objets dormir. MainTendue transforme votre générosité en actions concrètes au cœur du Togo. Rejoignez la révolution de l'entraide.
            </p>
                    </p>
                    <div class="hero-buttons">
                        <a href="{{ url('/donations/create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-gift"></i> Faire un don
                        </a>
                        <a href="{{ url('/donations') }}" class="btn btn-outline btn-lg" style="color: white; border-color: white;">
                            <i class="fas fa-search"></i> Chercher des dons
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="carousel-slide" style="background: url({{ asset('assets/images/hero/Joie_vivre_2.jpg') }}) no-repeat; background-size: cover; background-position: center;">
            <div class="slide-overlay"></div>
            <div class="container">
                <div class="slide-content">
                    <h1>Soutenez l'éducation au Togo</h1>
                    <p class="lead">
                        Offrez des fournitures scolaires pour aider les enfants à poursuivre leurs rêves.
                    </p>
                    <div class="hero-buttons">
                        <a href="#" class="btn btn-primary btn-lg">
                            <i class="fas fa-book"></i> Dons scolaires
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="carousel-slide" style="background: url({{ asset('assets/images/hero/Donations_3.jpg') }}) no-repeat; background-size: cover; background-position: center;">
            <div class="slide-overlay"></div>
            <div class="container">
                <div class="slide-content">
                    <h1>Luttez contre le gaspillage alimentaire</h1>
                    <p class="lead">
                        Partagez vos denrées non périssables avec ceux qui en ont besoin.
                    </p>
                    <div class="hero-buttons">
                        <a href="#" class="btn btn-primary btn-lg">
                            <i class="fas fa-utensils"></i> Dons alimentaires
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <button class="carousel-control prev" id="prevSlide">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="carousel-control next" id="nextSlide">
        <i class="fas fa-chevron-right"></i>
    </button>
    
    <div class="carousel-indicators">
        <button class="indicator active" data-slide="0"></button>
        <button class="indicator" data-slide="1"></button>
        <button class="indicator" data-slide="2"></button>
    </div>
</section>

<section class="how-it-works section-padding">
    <div class="container">
        <div class="section-header text-center">
            <h2>Comment ça marche ?</h2>
            <p class="section-subtitle">
                MAIN TENDUE simplifie le processus de don pour une aide rapide et efficace
            </p>
        </div>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>1. Identifier un besoin</h3>
                <p>Repérez un don nécessaire ou une association qui correspond à vos valeurs.</p>
            </div>
            
            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <h3>2. Faites votre don</h3>
                <p>Publiez un article à donner ou proposez-le directement à une association.</p>
            </div>
            
            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>3. Suivez l'impact</h3>
                <p>Observez comment votre contribution fait une différence concrète sur le terrain.</p>
            </div>
        </div>
    </div>
</section>

<section class="stats-section section-padding">
    <div class="container">
        <div class="stats-grid">
            @php
                use App\Models\User;
                use App\Models\Donation;
                use App\Models\Association;
                use App\Models\CollectionPoint;
            @endphp
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ User::count() }}</h3>
                    <p class="stat-label">Utilisateurs</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-gift"></i></div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ Donation::count() }}</h3>
                    <p class="stat-label">Dons</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-hands-helping"></i></div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ Association::count() }}</h3>
                    <p class="stat-label">Associations</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="stat-content">
                    <h3 class="stat-value">{{ CollectionPoint::count() }}</h3>
                    <p class="stat-label">Points de collecte</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="recent-donations section-padding bg-light">
    <div class="container">
        <div class="section-header">
            <h2>Dons Récents</h2>
            <a href="{{ url('/donations') }}" class="btn btn-outline">
                Voir tous <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="donations-grid">
            @php
                $recentDonations = Donation::with('category', 'primaryImage')
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();
            @endphp
            
            @foreach($recentDonations as $donation)
            <div class="donation-card">
                <div class="donation-image">
                    @if($donation->primaryImage)
                        <img src="{{ asset($donation->primaryImage->path) }}" alt="{{ $donation->title }}">
                    @else
                        <div class="no-image"><i class="fas fa-gift"></i></div>
                    @endif
                    <span class="category-badge">{{ $donation->category->name }}</span>
                </div>
                <div class="donation-content">
                    <h3 class="donation-title">{{ Str::limit($donation->title, 50) }}</h3>
                    <p class="donation-description">{{ Str::limit($donation->description, 100) }}</p>
                    <div class="donation-meta">
                        <div class="meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $donation->city }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ $donation->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="donation-actions">
                        <a href="{{ url('/donations/' . $donation->id) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-eye"></i> Voir détails
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.carousel-indicators .indicator');
        const prevBtn = document.getElementById('prevSlide');
        const nextBtn = document.getElementById('nextSlide');
        let currentSlide = 0;
        let slideInterval;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => indicator.classList.remove('active'));
            
            slides[index].classList.add('active');
            indicators[index].classList.add('active');
            currentSlide = index;
        }

        function nextSlide() {
            let newIndex = (currentSlide + 1) % slides.length;
            showSlide(newIndex);
        }

        function prevSlide() {
            let newIndex = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(newIndex);
        }

        // Événements
        nextBtn.addEventListener('click', () => {
            nextSlide();
            resetTimer();
        });

        prevBtn.addEventListener('click', () => {
            prevSlide();
            resetTimer();
        });

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                showSlide(index);
                resetTimer();
            });
        });

        // Timer automatique (4 secondes)
        function startTimer() {
            slideInterval = setInterval(nextSlide, 4000);
        }

        function resetTimer() {
            clearInterval(slideInterval);
            startTimer();
        }

        startTimer();
    });
</script>
@endsection