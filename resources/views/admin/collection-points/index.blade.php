@extends('layouts.app')

@section('title', 'Points de Collecte')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Points de Collecte</h1>
            <small class="text-muted">Gestion des points de collecte physiques</small>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.collection-points.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouveau point
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Association</th>
                        <th>Adresse</th>
                        <th>Statut</th>
                        <th>Créé le</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($collectionPoints as $point)
                        <tr>
                            <td class="fw-500">{{ $point->name }}</td>
                            <td>
                                @if($point->association)
                                    <a href="{{ route('associations.show', $point->association) }}" class="text-decoration-none">
                                        {{ $point->association->name }}
                                    </a>
                                @else
                                    <span class="badge bg-secondary">Non assigné</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ Str::limit($point->address, 40) }}</small>
                            </td>
                            <td>
                                @if($point->is_active)
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-danger">Inactif</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $point->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.collection-points.show', $point) }}" class="btn btn-sm btn-info" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.collection-points.edit', $point) }}" class="btn btn-sm btn-warning" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.collection-points.toggle', $point) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $point->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}" title="{{ $point->is_active ? 'Désactiver' : 'Activer' }}">
                                        <i class="bi bi-{{ $point->is_active ? 'lock' : 'unlock' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.collection-points.destroy', $point) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Aucun point de collecte trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($collectionPoints instanceof \Illuminate\Pagination\Paginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $collectionPoints->links() }}
        </div>
    @endif
</div>
@endsection
