@extends('layouts.app')

@section('title', $faq->question)

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h5 mb-0">{{ Str::limit($faq->question, 100) }}</h1>
            <small class="text-muted">Catégorie: {{ $faq->category->name ?? 'Non catégorisé' }}</small>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6 class="card-title text-muted">Question</h6>
            <p class="card-text">{{ $faq->question }}</p>

            <hr>

            <h6 class="card-title text-muted">Réponse</h6>
            <p class="card-text">{{ $faq->answer }}</p>

            <hr>

            <div class="row">
                <div class="col-md-4">
                    <strong>Catégorie:</strong>
                    <p>{{ $faq->category->name ?? 'Non catégorisé' }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Statut:</strong>
                    <p>
                        @if($faq->is_visible)
                            <span class="badge bg-success">Visible</span>
                        @else
                            <span class="badge bg-secondary">Masquée</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-4">
                    <strong>Ordre:</strong>
                    <p>{{ $faq->order_index ?? 'Non défini' }}</p>
                </div>
            </div>

            <hr>

            <small class="text-muted">
                Créé le {{ $faq->created_at->format('d/m/Y à H:i') }}
                | Modifié le {{ $faq->updated_at->format('d/m/Y à H:i') }}
            </small>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>
@endsection
