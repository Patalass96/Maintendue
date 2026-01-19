@extends('layouts.admin')

@section('title', 'Détails Utilisateur')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h4 class="mb-0 fw-bold"><i class="fas fa-user me-2"></i>Détails de {{ $user->name ?? $user->firstname }}
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Nom complet</label>
                        <p class="fw-bold">{{ $user->name ?? $user->firstname . ' ' . $user->lastname }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="fw-bold">{{ $user->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Rôle</label>
                        <p><span class="badge bg-primary">{{ ucfirst($user->role) }}</span></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Statut</label>
                        <p>
                            @if ($user->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-danger">Inactif / Suspendu</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Date d'inscription</label>
                        <p>{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                    </a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-edit me-1"></i> Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
