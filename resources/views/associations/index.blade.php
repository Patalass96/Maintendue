@extends('layouts.association')

@section('title', 'Nos Associations Partenaires')

@section('content')
    <div class="associations-page">
        <div class="hero-minimal">
            <div class="container">
                <h1>Nos Associations Partenaires</h1>
                <p>Découvrez les organisations qui œuvrent au quotidien pour aider ceux qui en ont besoin.</p>
            </div>
        </div>

        <section class="section-padding">
            <div class="container">
                <div class="associations-grid">
                    @forelse($associations as $association)
                        <div class="association-card">
                            <div class="association-logo">
                                @if($association->logo)
                                    <img src="{{ asset('storage/' . $association->logo) }}" alt="{{ $association->legal_name }}">
                                @else
                                    <div class="logo-placeholder">
                                        <i class="fas fa-university"></i>
                                    </div>
                                @endif
</div>
                            <div class="association-content">
                                <h3>{{ $association->legal_name }}</h3>
                                <p class="description">{{ Str::limit($association->description, 120) }}</p>
                                <div class="association-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> {{ $association->legal_address }}</span>
                                    @if($association->stats_total_donations > 0)
                                        <span><i class="fas fa-box"></i> {{ $association->stats_total_donations }} dons reçus</span>
                                    @endif
                                </div>
                                <div class="association-actions">
                                    <a href="{{ route('associations.show', $association->id) }}" class="btn btn-secondary btn-sm">Voir le profil</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="no-results" style="grid-column: 1/-1; text-align: center; padding: 60px;">
                            <i class="fas fa-search"
                                style="font-size: 3rem; color: var(--gray); opacity: 0.3; margin-bottom: 20px;"></i>
                            <p>Aucune association trouvée pour le moment.</p>
                        </div>
                    @endforelse
                </div>

                <div class="pagination-container">
                    {{ $associations->links() }}
                </div>
            </div>
        </section>
    </div>
<style>
        .hero-minimal {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .hero-minimal h1 {
            color: white;
            margin: 0;
            font-size: 2.5rem;
        }

        .hero-minimal p {
            margin-top: 10px;
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .associations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        .association-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
.association-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .association-logo {
            height: 180px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .association-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .logo-placeholder {
            font-size: 4rem;
            color: var(--gray);
            opacity: 0.2;
        }

        .association-content {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .association-content h3 {
            margin: 0 0 12px 0;
            font-size: 1.25rem;
            color: var(--black);
        }

        .association-content .description {
            color: var(--gray);
            font-size: 0.95rem;
            margin-bottom: 20px;
            flex-grow: 1;
            line-height: 1.5;
        }

        .association-meta {
            margin-bottom: 20px;
            font-size: 0.85rem;
            color: var(--gray);
        }

        .association-meta span {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .association-meta i {
            width: 16px;
            color: var(--primary-color);
        }

        .pagination-container {
            margin-top: 50px;
            display: flex;
            justify-content: center;
        }
    </style>
@endsection
