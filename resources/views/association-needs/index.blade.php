@extends('layouts.app')

@section('title', 'Besoins spécifiques')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Besoins spécifiques</h1>
            <small class="text-muted">Définissez les donations que vous recherchez</small>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('associations.needs.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Ajouter un besoin
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse($needs as $need)
            <div class="col-md-6 mb-3">
                <div class="card h-100 {{ !$need->is_active ? 'opacity-50' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $need->item_type }}</h5>
                            <span class="badge {{ $need->urgency === 'urgent' ? 'bg-danger' : ($need->urgency === 'high' ? 'bg-warning' : 'bg-info') }}">
                                {{ ucfirst($need->urgency) }}
                            </span>
                        </div>

                        @if($need->description)
                            <p class="card-text text-muted">{{ Str::limit($need->description, 100) }}</p>
                        @endif

                        <div class="mb-3">
                            <span class="badge bg-light text-dark">
                                Quantité: {{ $need->quantity_needed ?? 'Indéfinie' }}
                            </span>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('associations.needs.show', $need) }}" class="btn btn-sm btn-info flex-grow-1">
                                <i class="bi bi-eye"></i> Voir
                            </a>
                            <a href="{{ route('associations.needs.edit', $need) }}" class="btn btn-sm btn-warning flex-grow-1">
                                <i class="bi bi-pencil"></i> Modifier
                            </a>
                            <form action="{{ route('associations.needs.toggle', $need) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-sm w-100 {{ $need->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                    <i class="bi bi-{{ $need->is_active ? 'lock' : 'unlock' }}"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <small class="text-muted">
                            Créé le {{ $need->created_at->format('d/m/Y') }}
                            @if(!$need->is_active) - Inactif @endif
                        </small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="card text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">Aucun besoin spécifique défini</p>
                    <a href="{{ route('associations.needs.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Créer le premier
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($needs instanceof \Illuminate\Pagination\Paginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $needs->links() }}
        </div>
    @endif
</div>
@endsection
