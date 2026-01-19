@extends('layouts.validate')

@section('title', 'Détail du Signalement')
@section('page-title', 'Gestion du Signalement')

@section('content')
<div class="report-detail-container">
    <div class="container-fluid">
        <!-- Fil d'Ariane -->
        <div class="breadcrumb-section mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.moderation.reports.index') }}">Signalements</a></li>
                    <li class="breadcrumb-item active">Signalement #{{ $report->id }}</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <!-- Carte en-tête du signalement -->
                <div class="report-header-card card mb-4">
                    <div class="card-header bg-{{ $report->status === 'pending' ? 'warning' : ($report->status === 'resolved' ? 'success' : 'info') }} text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Signalement #{{ $report->id }}</h5>
                                <small>{{ $report->created_at->format('d F Y à H:i') }}</small>
                            </div>
                            <span class="badge badge-lg bg-{{ $report->status === 'pending' ? 'warning' : ($report->status === 'resolved' ? 'success' : 'secondary') }}">
                                @switch($report->status)
                                    @case('pending')
                                        <i class="fas fa-clock"></i> En attente
                                        @break
                                    @case('reviewed')
                                        <i class="fas fa-eye"></i> Examiné
                                        @break
                                    @case('resolved')
                                        <i class="fas fa-check-circle"></i> Résolu
                                        @break
                                    @case('dismissed')
                                        <i class="fas fa-times-circle"></i> Rejeté
                                        @break
                                @endswitch
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Informations de base -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted">Motif</h6>
                                <p class="mb-3">
                                    <span class="badge bg-danger">
                                        @switch($report->reason)
                                            @case('spam')
                                                <i class="fas fa-inbox"></i> Spam
                                                @break
                                            @case('inappropriate')
                                                <i class="fas fa-exclamation-triangle"></i> Contenu inapproprié
                                                @break
                                            @case('fraud')
                                                <i class="fas fa-shield-alt"></i> Fraude
                                                @break
                                            @case('other')
                                                <i class="fas fa-question-circle"></i> Autre
                                                @break
                                        @endswitch
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Type</h6>
                                <p>
                                    <span class="badge bg-info">{{ class_basename($report->reported_type) }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Auteur du signalement -->
                        <div class="reporter-info mb-4 p-3 bg-light rounded">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-user"></i> Signalé par
                            </h6>
                            <div class="d-flex align-items-center gap-2">
                                @if($report->reporter->avatar)
                                    <img src="{{ Storage::url($report->reporter->avatar) }}" alt="{{ $report->reporter->name }}" class="rounded-circle" width="40">
                                @else
                                    <div class="avatar-placeholder bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($report->reporter->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <strong>{{ $report->reporter->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $report->reporter->email }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Entité signalée -->
                        @php
                            $reported = $report->reported;
                        @endphp
                        <div class="reported-item mb-4 p-3 bg-danger bg-opacity-10 border-start border-danger rounded">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-exclamation-circle"></i> Entité signalée
                            </h6>

                            @if($reported instanceof \App\Models\User)
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($reported->avatar)
                                            <img src="{{ Storage::url($reported->avatar) }}" alt="{{ $reported->name }}" class="rounded-circle" width="50">
                                        @else
                                            <div class="avatar-placeholder bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                {{ strtoupper(substr($reported->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $reported->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $reported->email }}</small>
                                            <br>
                                            <span class="badge bg-secondary">{{ ucfirst($reported->role) }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.users.show', $reported) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Voir le profil
                                    </a>
                                </div>
                            @elseif($reported instanceof \App\Models\Donation)
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex gap-3">
                                        @if($reported->images->first())
                                            <img src="{{ Storage::url($reported->images->first()->image_path) }}" alt="{{ $reported->title }}" class="rounded" width="80" height="80" style="object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                <i class="fas fa-image text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $reported->title }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($reported->description, 80) }}</small>
                                            <br>
                                            <span class="badge bg-info">{{ $reported->category->name }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('donations.show', $reported) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="fas fa-eye"></i> Voir le don
                                    </a>
                                </div>
                            @elseif($reported instanceof \App\Models\Association)
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $reported->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $reported->description }}</small>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Description du signalement -->
                        <div class="report-description mb-4">
                            <h6 class="text-muted mb-2">Description du problème</h6>
                            <div class="p-3 bg-light rounded">
                                <p class="mb-0">{{ $report->description }}</p>
                            </div>
                        </div>

                        <!-- Notes administrateur -->
                        @if($report->admin_notes)
                            <div class="admin-notes mb-4">
                                <h6 class="text-muted mb-2">Notes administrateur</h6>
                                <div class="p-3 bg-info bg-opacity-10 border-start border-info rounded">
                                    <p class="mb-0">{{ $report->admin_notes }}</p>
                                    @if($report->resolver)
                                        <small class="text-muted d-block mt-2">
                                            Par {{ $report->resolver->name }} le {{ $report->resolved_at->format('d F Y à H:i') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Actions de modération -->
                        @if($report->status !== 'resolved' && $report->status !== 'dismissed')
                            <div class="moderation-actions">
                                <h6 class="text-muted mb-3">Actions de modération</h6>

                                <!-- Marquer comme examiné -->
                                @if($report->status === 'pending')
                                    <form action="{{ route('admin.moderation.reports.mark-reviewed', $report) }}" method="POST" class="mb-3">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning w-100">
                                            <i class="fas fa-eye"></i> Marquer comme examiné
                                        </button>
                                    </form>
                                @endif

                                <!-- Résoudre le signalement -->
                                <button class="btn btn-success w-100 mb-3" data-bs-toggle="modal" data-bs-target="#resolveModal">
                                    <i class="fas fa-check-circle"></i> Résoudre
                                </button>

                                <!-- Rejeter le signalement -->
                                <button class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#dismissModal">
                                    <i class="fas fa-times-circle"></i> Rejeter
                                </button>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Ce signalement a déjà été traité.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colonne latérale -->
            <div class="col-lg-4">
                <!-- Informations du signalement -->
                <div class="info-card card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-info-circle"></i> Détails</h6>
                    </div>
                    <div class="card-body">
                        <div class="detail-item mb-3">
                            <strong class="text-muted d-block">ID</strong>
                            <code>#{{ $report->id }}</code>
                        </div>
                        <div class="detail-item mb-3">
                            <strong class="text-muted d-block">Statut</strong>
                            <span class="badge bg-{{ $report->status === 'pending' ? 'warning' : 'success' }}">
                                {{ ucfirst($report->status) }}
                            </span>
                        </div>
                        <div class="detail-item mb-3">
                            <strong class="text-muted d-block">Date de création</strong>
                            {{ $report->created_at->format('d F Y H:i') }}
                        </div>
                        @if($report->resolved_at)
                            <div class="detail-item mb-3">
                                <strong class="text-muted d-block">Date de résolution</strong>
                                {{ $report->resolved_at->format('d F Y H:i') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="actions-card card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-cogs"></i> Actions</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.moderation.reports.index') }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-list"></i> Retour à la liste
                        </a>
                        <button class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Résoudre -->
<div class="modal fade" id="resolveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Résoudre le signalement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.moderation.reports.resolve', $report) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Notes administrateur</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4" required minlength="10" maxlength="1000"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="action" class="form-label">Action à appliquer</label>
                        <select class="form-select" id="action" name="action">
                            <option value="none">Aucune (signalement valide mais pas d'action)</option>
                            <option value="warn">Avertir l'utilisateur</option>
                            <option value="suspend">Suspendre l'utilisateur</option>
                            <option value="remove">Supprimer le contenu</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Résoudre</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Rejeter -->
<div class="modal fade" id="dismissModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejeter le signalement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.moderation.reports.dismiss', $report) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="dismiss_notes" class="form-label">Raison du rejet</label>
                        <textarea class="form-control" id="dismiss_notes" name="admin_notes" rows="4" required minlength="10" maxlength="500"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-warning">Rejeter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Supprimer -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supprimer le signalement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce signalement ? Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.moderation.reports.destroy', $report) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.report-detail-container {
    padding: 2rem 0;
    background-color: #f8f9fa;
    min-height: 100vh;
}

.report-header-card {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: none;
}

.reporter-info,
.reported-item,
.report-description,
.admin-notes {
    border-radius: 8px;
}

.info-card,
.actions-card {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: none;
}

.detail-item strong {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-lg {
    padding: 0.5rem 1rem;
    font-size: 14px;
}
</style>
@endsection
