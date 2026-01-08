@extends('layouts.dashboard')

@section('content')
<div class="dashboard-container">
    <div class="header-actions">
        <h1>Gestion des Catégories</h1>
        <button class="btn btn-primary" onclick="toggleModal('addCategoryModal')">
            <i class="fas fa-plus"></i> Nouvelle Catégorie
        </button>
    </div>

    <div class="table-card mt-4">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Ordre</th>
                    <th>Icône</th>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->order_index }}</td>
                    <td><i class="{{ $category->icon }}"></i></td>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td><code>{{ $category->slug }}</code></td>
                    <td>
                        <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $category->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td class="actions">
                        <a href="{{ route('categories.edit', $category) }}" class="btn-edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Supprimer cette catégorie ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="addCategoryModal" class="modal">
    <div class="modal-content">
        <h3>Ajouter une catégorie</h3>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="name" required class="form-input">
            </div>
            <div class="form-group">
                <label>Icône (Classe FontAwesome)</label>
                <input type="text" name="icon" placeholder="fas fa-utensils" class="form-input">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-input"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="toggleModal('addCategoryModal')" class="btn-cancel">Annuler</button>
                <button type="submit" class="btn-submit">Créer</button>
            </div>
        </form>
    </div>
</div>
@endsection