@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Questions Fréquemment Posées</h1>
            <small class="text-muted">Gestion des FAQ</small>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouvelle question
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">
                    Toutes les catégories
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('admin.faqs.index', ['category' => $category->id]) }}" class="btn btn-outline-secondary">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 30px;">
                            <i class="bi bi-arrows-move"></i>
                        </th>
                        <th>Question</th>
                        <th>Catégorie</th>
                        <th>Visibilité</th>
                        <th>Créé le</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="faqs-sortable">
                    @forelse($faqs as $faq)
                        <tr draggable="true" data-faq-id="{{ $faq->id }}" class="faq-row">
                            <td class="text-muted handle" style="cursor: grab;">
                                <i class="bi bi-grip-vertical"></i>
                            </td>
                            <td class="fw-500">{{ Str::limit($faq->question, 60) }}</td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $faq->category->name ?? 'Non catégorisé' }}</span>
                            </td>
                            <td>
                                @if($faq->is_visible)
                                    <span class="badge bg-success">Visible</span>
                                @else
                                    <span class="badge bg-secondary">Masquée</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $faq->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.faqs.show', $faq) }}" class="btn btn-sm btn-info" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-warning" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr?')">
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
                                Aucune question trouvée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($faqs instanceof \Illuminate\Pagination\Paginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $faqs->links() }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortable = document.getElementById('faqs-sortable');

    sortable.addEventListener('dragstart', function(e) {
        e.dataTransfer.effectAllowed = 'move';
        e.target.closest('tr').classList.add('opacity-50');
    });

    sortable.addEventListener('dragend', function(e) {
        e.target.closest('tr').classList.remove('opacity-50');
    });

    sortable.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    });

    sortable.addEventListener('drop', function(e) {
        e.preventDefault();
        const targetRow = e.target.closest('tr');
        const sourceRow = document.querySelector('tr.opacity-50');

        if (targetRow && sourceRow && targetRow !== sourceRow) {
            sortable.insertBefore(sourceRow, targetRow);
            updateOrder();
        }
    });

    function updateOrder() {
        const rows = sortable.querySelectorAll('tr');
        const order = [];

        rows.forEach((row, index) => {
            order.push({
                id: row.getAttribute('data-faq-id'),
                order: index
            });
        });

        fetch('{{ route("admin.faqs.reorder") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ order })
        }).catch(err => console.error('Erreur:', err));
    }
});
</script>
@endsection
