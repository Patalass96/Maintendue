@extends('layouts.app')

@section('title', $faq->exists ? 'Modifier la question' : 'Nouvelle question')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">{{ $faq->exists ? 'Modifier la question' : 'Créer une nouvelle question' }}</h1>
        </div>
    </div>

    <form action="{{ $faq->exists ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" method="POST" class="row">
        @csrf
        @if($faq->exists)
            @method('PUT')
        @endif

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="question" class="form-label">Question *</label>
                        <textarea id="question" name="question" class="form-control @error('question') is-invalid @enderror"
                            rows="3" required>{{ old('question', $faq->question) }}</textarea>
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">La question principale</small>
                    </div>

                    <div class="mb-3">
                        <label for="answer" class="form-label">Réponse *</label>
                        <textarea id="answer" name="answer" class="form-control @error('answer') is-invalid @enderror"
                            rows="6" required>{{ old('answer', $faq->answer) }}</textarea>
                        @error('answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">La réponse détaillée</small>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie *</label>
                        <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner une catégorie --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $faq->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="is_visible" class="form-check-label">
                            <input type="checkbox" id="is_visible" name="is_visible" class="form-check-input"
                                {{ old('is_visible', $faq->is_visible) ? 'checked' : '' }}>
                            Visible publiquement
                        </label>
                        <small class="d-block text-muted mt-1">
                            La question sera affichée dans la section FAQ publique
                        </small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2"></i> {{ $faq->exists ? 'Mettre à jour' : 'Créer' }}
                        </button>
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
