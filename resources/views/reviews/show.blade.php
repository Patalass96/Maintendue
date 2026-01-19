@extends('layouts.app')

@section('title', 'Avis')

@section('content')
<div class="review-detail-container py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- En-tête avec navigation -->
                <div class="review-header-section mb-4">
                    <a href="{{ route('reviews.index', $review->reviewed) }}" class="btn btn-outline-secondary mb-3">
                        <i class="fas fa-arrow-left"></i> Retour aux avis
                    </a>
                </div>

                <!-- Carte principale de l'avis -->
                <div class="review-detail-card card mb-4">
                    <div class="card-body">
                        <!-- Auteur et note -->
                        <div class="review-author-section d-flex justify-content-between align-items-start mb-4">
                            <div class="author-info d-flex gap-3">
                                @if($review->reviewer->avatar)
                                    <img src="{{ Storage::url($review->reviewer->avatar) }}" alt="{{ $review->reviewer->name }}" class="rounded-circle" width="60">
                                @else
                                    <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        {{ strtoupper(substr($review->reviewer->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-1">{{ $review->reviewer->name }}</h5>
                                    <p class="text-muted mb-2">
                                        <small>{{ $review->created_at->format('d F Y à H:i') }}</small>
                                    </p>
                                    <p class="text-muted mb-0">
                                        <small>
                                            @if($review->reviewer->role === 'association')
                                                <i class="fas fa-shield-alt"></i> Association
                                            @else
                                                <i class="fas fa-user"></i> Donateur
                                            @endif
                                        </small>
                                    </p>
                                </div>
                            </div>

                            <!-- Note -->
                            <div class="text-end">
                                <div class="rating-stars mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }} fa-lg"></i>
                                    @endfor
                                </div>
                                <p class="text-muted mb-0">
                                    <strong>{{ $review->rating }}/5</strong>
                                </p>
                            </div>
                        </div>

                        <!-- Commentaire -->
                        <div class="review-comment-section mb-4">
                            <p class="lead">{{ $review->comment }}</p>
                        </div>

                        <!-- Donation liée -->
                        @if($review->donation)
                            <div class="donation-reference bg-light p-3 rounded mb-4">
                                <strong class="d-block mb-2">
                                    <i class="fas fa-box"></i> Concernant le don:
                                </strong>
                                <div class="d-flex gap-3">
                                    @if($review->donation->images->first())
                                        <img src="{{ Storage::url($review->donation->images->first()->image_path) }}" alt="{{ $review->donation->title }}" class="rounded" width="80" height="80" style="object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="fas fa-image text-white"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-1">
                                            <a href="{{ route('donations.show', $review->donation) }}" class="text-decoration-none">
                                                {{ $review->donation->title }}
                                            </a>
                                        </h6>
                                        <p class="text-muted mb-0">
                                            <small>{{ $review->donation->description }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Réponse de l'utilisateur évalué -->
                        @if($review->response)
                            <div class="response-section bg-primary-light p-3 rounded mb-4">
                                <div class="response-header d-flex align-items-center gap-2 mb-2">
                                    <i class="fas fa-reply text-primary"></i>
                                    <strong>Réponse de {{ $review->reviewed->name }}</strong>
                                </div>
                                <p class="mb-0">{{ $review->response }}</p>
                            </div>
                        @elseif(Auth::id() === $review->reviewed->id && Auth::user()->can('reply', $review))
                            <div class="reply-form-section mb-4">
                                <form action="{{ route('reviews.reply', $review) }}" method="POST">
                                    @csrf
                                    <h6 class="mb-3">Voulez-vous répondre à cet avis ?</h6>
                                    <div class="mb-3">
                                        <textarea class="form-control" name="response" rows="4" placeholder="Écrivez votre réponse..." required minlength="5" maxlength="500"></textarea>
                                        <small class="text-muted d-block mt-1">Maximum 500 caractères</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Envoyer la réponse
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="actions-section mb-4">
                    <div class="d-flex gap-2">
                        @if(Auth::check() && Auth::id() !== $review->reviewer_id)
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#reportModal">
                                <i class="fas fa-flag"></i> Signaler cet avis
                            </button>
                        @endif

                        @if(Auth::id() === $review->reviewed->id || Auth::user()?->role === 'admin')
                            <a href="#" class="btn btn-outline-warning">
                                <i class="fas fa-edit"></i> Gérer
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Section des autres avis du même utilisateur -->
                <div class="related-reviews-section">
                    <h5 class="mb-3">Autres avis de {{ $review->reviewed->name }}</h5>
                    <div class="reviews-preview">
                        @php
                            $otherReviews = \App\Models\Review::where('reviewed_id', $review->reviewed_id)
                                ->where('id', '!=', $review->id)
                                ->where('is_visible', true)
                                ->with(['reviewer'])
                                ->latest()
                                ->take(3)
                                ->get();
                        @endphp

                        @if($otherReviews->count() > 0)
                            @foreach($otherReviews as $otherReview)
                                <div class="review-preview-item p-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <strong>{{ $otherReview->reviewer->name }}</strong>
                                        <div>
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $otherReview->rating ? 'text-warning' : 'text-muted' }} fa-sm"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-muted mb-0">
                                        <small>{{ Str::limit($otherReview->comment, 100) }}</small>
                                    </p>
                                    <a href="{{ route('reviews.show', $otherReview) }}" class="btn btn-sm btn-link mt-2">Voir</a>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Aucun autre avis pour cet utilisateur.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de signalement -->
<div class="modal fade" id="reportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Signaler cet avis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('reviews.report', $review) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-3">Merci de nous aider à maintenir une communauté saine.</p>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Motif du signalement</label>
                        <select class="form-select" id="reason" name="reason" required>
                            <option value="">-- Sélectionnez un motif --</option>
                            <option value="inappropriate">Contenu inapproprié ou offensant</option>
                            <option value="false_information">Fausse information</option>
                            <option value="spam">Spam ou contenu commercial</option>
                            <option value="other">Autre raison</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Explication détaillée</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Décrivez le problème..." required minlength="10" maxlength="500"></textarea>
                        <small class="text-muted">Maximum 500 caractères</small>
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

<style>
.review-detail-container {
    background-color: #f8f9fa;
    min-height: 100vh;
    padding-top: 2rem;
    padding-bottom: 2rem;
}

.review-detail-card {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: none;
}

.rating-stars i {
    margin-right: 4px;
}

.response-section {
    background-color: #f0f7ff;
    border-left: 4px solid #0d6efd;
}

.related-reviews-section {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.review-preview-item:hover {
    background-color: #f8f9fa;
}
</style>
@endsection
