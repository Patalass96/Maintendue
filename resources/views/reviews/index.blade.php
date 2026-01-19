@extends('layouts.app')

@section('title', 'Avis - ' . $user->name)

@section('content')
<div class="reviews-container py-4">
    <div class="reviews-header mb-5">
        <div class="user-profile-section mb-4">
            <div class="user-avatar-large">
                @if($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle" width="80">
                @else
                    <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="user-info-section">
                <h1>{{ $user->name }}</h1>
                <div class="rating-stats d-flex align-items-center gap-3 mt-2">
                    <div class="average-rating">
                        <span class="rating-number">{{ number_format($stats['average'], 1) }}</span>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= round($stats['average']) ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="rating-count">
                        <strong>{{ $stats['total'] }}</strong> avis
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques détaillées -->
        <div class="rating-breakdown mt-4">
            <h5 class="mb-3">Répartition des évaluations</h5>
            <div class="breakdown-grid">
                @for($rating = 5; $rating >= 1; $rating--)
                    @php
                        $count = $stats['count_by_rating'][$rating] ?? 0;
                        $percentage = $stats['total'] > 0 ? ($count / $stats['total']) * 100 : 0;
                    @endphp
                    <div class="breakdown-item">
                        <div class="rating-label">
                            <span>{{ $rating }} <i class="fas fa-star text-warning"></i></span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="rating-count">{{ $count }}</div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Liste des avis -->
    <div class="reviews-list mt-5">
        <h3 class="mb-4">Avis reçus</h3>

        @if($reviews->count() > 0)
            @foreach($reviews as $review)
                <div class="review-card mb-4 p-4 border rounded">
                    <div class="review-header d-flex justify-content-between align-items-start mb-3">
                        <div class="reviewer-info d-flex align-items-center gap-3">
                            @if($review->reviewer->avatar)
                                <img src="{{ Storage::url($review->reviewer->avatar) }}" alt="{{ $review->reviewer->name }}" class="rounded-circle" width="50">
                            @else
                                <div class="avatar-placeholder bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    {{ strtoupper(substr($review->reviewer->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-0">{{ $review->reviewer->name }}</h6>
                                <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                        <div class="review-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                    </div>

                    <p class="review-comment mb-3">{{ $review->comment }}</p>

                    @if($review->donation)
                        <div class="review-donation-info mb-3">
                            <small class="text-muted">
                                <i class="fas fa-gift"></i>
                                Concernant: <a href="{{ route('donations.show', $review->donation) }}">{{ $review->donation->title }}</a>
                            </small>
                        </div>
                    @endif

                    @if($review->response)
                        <div class="review-response bg-light p-3 rounded">
                            <strong class="d-block mb-2">Réponse de {{ $user->name }}:</strong>
                            <p class="mb-0">{{ $review->response }}</p>
                        </div>
                    @elseif(Auth::id() === $user->id && Auth::user()->can('reply', $review))
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#replyModal{{ $review->id }}">
                            <i class="fas fa-reply"></i> Répondre
                        </button>

                        <!-- Modal de réponse -->
                        <div class="modal fade" id="replyModal{{ $review->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Répondre à l'avis</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('reviews.reply', $review) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="response" class="form-label">Votre réponse</label>
                                                <textarea class="form-control" id="response" name="response" rows="4" required minlength="5" maxlength="500"></textarea>
                                                <small class="text-muted">Maximum 500 caractères</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Envoyer la réponse</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="review-actions mt-3 pt-3 border-top">
                        <a href="{{ route('reviews.show', $review) }}" class="btn btn-sm btn-link">
                            <i class="fas fa-eye"></i> Voir l'avis complet
                        </a>
                        @if(Auth::id() !== $review->reviewer_id)
                            <button class="btn btn-sm btn-link text-danger" data-bs-toggle="modal" data-bs-target="#reportModal{{ $review->id }}">
                                <i class="fas fa-flag"></i> Signaler
                            </button>

                            <!-- Modal de signalement -->
                            <div class="modal fade" id="reportModal{{ $review->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Signaler cet avis</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('reviews.report', $review) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="reason" class="form-label">Motif du signalement</label>
                                                    <select class="form-select" id="reason" name="reason" required>
                                                        <option value="">Sélectionnez un motif</option>
                                                        <option value="inappropriate">Contenu inapproprié</option>
                                                        <option value="false_information">Fausse information</option>
                                                        <option value="spam">Spam</option>
                                                        <option value="other">Autre</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3" required minlength="10" maxlength="500"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger">Signaler</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <nav class="mt-5">
                {{ $reviews->links('pagination::bootstrap-4') }}
            </nav>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                Aucun avis pour cet utilisateur pour le moment.
            </div>
        @endif
    </div>
</div>

<style>
.reviews-container {
    max-width: 900px;
    margin: 0 auto;
}

.rating-stats {
    font-size: 14px;
}

.rating-number {
    font-size: 28px;
    font-weight: bold;
    color: #ffc107;
}

.rating-breakdown {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.breakdown-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
}

.review-card {
    background: white;
    border: 1px solid #dee2e6 !important;
    transition: box-shadow 0.2s;
}

.review-card:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.review-response {
    border-left: 4px solid #0d6efd;
}
</style>
@endsection
