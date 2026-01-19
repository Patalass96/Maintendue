@extends('layouts.app')

@section('title', 'Publier un avis')

@section('content')
<div class="review-create-container py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- En-tête -->
                <div class="review-create-header mb-5">
                    <h1 class="mb-2">Partager votre avis</h1>
                    <p class="text-muted">Aidez la communauté en donnant votre retour sur cette transaction.</p>
                </div>

                <!-- Informations du don -->
                <div class="donation-info-card card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Concernant le don</h5>
                        <div class="d-flex gap-4">
                            @if($donation->images->first())
                                <img src="{{ Storage::url($donation->images->first()->image_path) }}" alt="{{ $donation->title }}" class="rounded" width="120" height="120" style="object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                    <i class="fas fa-image text-white fa-2x"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-2">{{ $donation->title }}</h6>
                                <p class="text-muted mb-2">{{ Str::limit($donation->description, 150) }}</p>
                                <div class="donation-meta">
                                    <span class="badge bg-info">{{ $donation->category->name }}</span>
                                    <span class="badge bg-secondary">{{ $donation->condition }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulaire d'avis -->
                <div class="review-form-card card">
                    <div class="card-body">
                        <form action="{{ route('reviews.store', $donation) }}" method="POST" id="reviewForm">
                            @csrf

                            <!-- Note -->
                            <div class="mb-4">
                                <label class="form-label mb-3">
                                    <strong>Votre note</strong>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="rating-input">
                                    <div class="stars-picker">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required class="star-input">
                                            <label for="star{{ $i }}" class="star-label">
                                                <i class="fas fa-star"></i>
                                            </label>
                                        @endfor
                                    </div>
                                    <div class="rating-display mt-3">
                                        <div class="rating-text">
                                            <span id="ratingNumber" class="rating-number">0</span>
                                            <span id="ratingLabel" class="rating-label-text ms-2">Sélectionnez une note</span>
                                        </div>
                                    </div>
                                </div>
                                @error('rating')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Commentaire -->
                            <div class="mb-4">
                                <label for="comment" class="form-label">
                                    <strong>Votre avis</strong>
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea
                                    class="form-control @error('comment') is-invalid @enderror"
                                    id="comment"
                                    name="comment"
                                    rows="6"
                                    placeholder="Partagez votre expérience avec cette transaction. Soyez honnête et constructif..."
                                    required
                                    minlength="10"
                                    maxlength="1000"
                                    data-bs-toggle="tooltip"
                                    title="Votre avis doit contenir entre 10 et 1000 caractères">
                                </textarea>
                                <small class="text-muted d-block mt-2">
                                    <span id="charCount">0</span>/1000 caractères
                                </small>
                                @error('comment')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <!-- Guide de rédaction -->
                                <div class="writing-guide mt-3 p-3 bg-light rounded border-start border-info">
                                    <strong class="d-block mb-2">
                                        <i class="fas fa-lightbulb text-info"></i> Conseils:
                                    </strong>
                                    <ul class="small mb-0 ps-3">
                                        <li>Décrivez votre expérience de manière honnête et objective</li>
                                        <li>Mentionnez l'état du produit/service reçu</li>
                                        <li>Commentez la communication et la réactivité</li>
                                        <li>Soyez constructif - criticquez le comportement, pas la personne</li>
                                        <li>Évitez les insultes, le spam et les contenus offensants</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Conditions d'acceptation -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="agree"
                                        name="agree"
                                        required>
                                    <label class="form-check-label" for="agree">
                                        Je certifie que cet avis est basé sur une expérience réelle et je reconnais avoir lu nos <a href="{{ route('terms') }}" target="_blank">conditions d'utilisation</a>.
                                    </label>
                                </div>
                                @error('agree')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check-circle"></i> Publier l'avis
                                </button>
                                <a href="{{ route('donations.show', $donation) }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-times-circle"></i> Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Information supplémentaire -->
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle"></i>
                    <strong>Remarque importante:</strong> Les avis sont modérés par notre équipe avant publication. Les avis non conformes à nos politiques seront supprimés.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.review-create-container {
    background-color: #f8f9fa;
    min-height: 100vh;
}

.stars-picker {
    display: flex;
    gap: 10px;
    flex-direction: row-reverse;
    justify-content: flex-end;
    width: fit-content;
}

.star-input {
    display: none;
}

.star-label {
    font-size: 32px;
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s;
}

.star-input:hover ~ .star-label,
.star-input:checked ~ .star-label,
.star-label:hover,
.star-label:hover ~ .star-label {
    color: #ffc107;
}

.star-input:checked ~ .star-label {
    color: #ffc107;
}

.rating-number {
    font-size: 28px;
    font-weight: bold;
    color: #ffc107;
}

.rating-label-text {
    font-size: 16px;
    color: #6c757d;
}

.writing-guide {
    border-left: 4px solid #0dcaf0 !important;
}

#charCount {
    font-weight: bold;
    color: #6c757d;
}

textarea:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.donation-info-card {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: none;
}

.review-form-card {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Compteur de caractères
    const commentField = document.getElementById('comment');
    const charCount = document.getElementById('charCount');

    commentField.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });

    // Mise à jour du label de note
    const starInputs = document.querySelectorAll('.star-input');
    const ratingNumber = document.getElementById('ratingNumber');
    const ratingLabel = document.getElementById('ratingLabel');

    const labels = {
        5: 'Excellent - Très satisfait',
        4: 'Bon - Satisfait',
        3: 'Moyen - Neutre',
        2: 'Faible - Insatisfait',
        1: 'Très mauvais - Très insatisfait'
    };

    starInputs.forEach(input => {
        input.addEventListener('change', function() {
            ratingNumber.textContent = this.value;
            ratingLabel.textContent = labels[this.value];
        });
    });

    // Validation du formulaire
    const form = document.getElementById('reviewForm');
    form.addEventListener('submit', function(e) {
        if (!document.getElementById('agree').checked) {
            e.preventDefault();
            alert('Veuillez accepter les conditions d\'utilisation.');
        }
    });
});
</script>
@endsection
