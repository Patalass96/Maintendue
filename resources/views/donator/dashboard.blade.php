@extends('layouts/layout.donapp')

@section('content')
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h1 class="h3 mb-0">Mon Tableau de Bord (Donateur)</h1>
                <p class="text-muted">Bienvenue, {{ Auth::user()->name }} ! Merci pour votre générosité.</p>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="premium-stat-card glass-card hover-lift" style="background: var(--p-primary-glow);">
                    <div class="stat-icon-wrapper" style="background: var(--grad-primary);">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Total des dons</p>
                        <h2 class="fw-800 mb-0">{{ $stats['total_donations'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="premium-stat-card glass-card hover-lift" style="background: var(--p-secondary-glow);">
                    <div class="stat-icon-wrapper" style="background: var(--grad-success);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Dons livrés</p>
                        <h2 class="fw-800 mb-0">{{ $stats['delivered_donations'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="premium-stat-card glass-card hover-lift" style="background: var(--p-accent-glow);">
                    <div class="stat-icon-wrapper" style="background: var(--grad-warning);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">En attente</p>
                        <h2 class="fw-800 mb-0">{{ $stats['pending_donations'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="glass-card border-0 rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white bg-opacity-50 border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-800 text-dark">
                            <i class="fas fa-list-ul me-2 text-primary"></i>Mes derniers dons
                        </h5>
                        <a href="{{ route('donations.create') }}" class="btn-premium btn-premium-primary">
                            <i class="fas fa-plus-circle"></i> Publier un don
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Don</th>
                                        <th>Catégorie</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th class="text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($donations as $donation)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . ($donation->primaryImage->path ?? 'donations/default.png')) }}"
                                                        class="rounded-3 me-3" width="48" height="48" alt="">
                                                    <div>
                                                        <div class="fw-bold">{{ $donation->title }}</div>
                                                        <small
                                                            class="text-muted">{{ Str::limit($donation->description, 30) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $donation->category->name }}</td>
                                            <td>
                                                @php
                                                    $statusClass = match ($donation->status) {
                                                        'available' => 'bg-info',
                                                        'accepted' => 'bg-warning',
                                                        'delivered' => 'bg-success',
                                                        'rejected' => 'bg-danger',
                                                        default => 'bg-secondary'
                                                    };
                                                @endphp
                                                <span
                                                    class="badge {{ $statusClass }} rounded-pill">{{ ucfirst($donation->status) }}</span>
                                            </td>
                                            <td>{{ $donation->created_at->format('d/m/Y') }}</td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('donations.show', $donation) }}"
                                                    class="btn btn-light btn-sm rounded-circle">
                                                    <i class="fas fa-eye text-primary"></i>
                                                </a>
                                                <a href="{{ route('donations.edit', $donation) }}"
                                                    class="btn btn-light btn-sm rounded-circle ms-1">
                                                    <i class="fas fa-edit text-success"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <p>Vous n'avez pas encore publié de don.</p>
                                                <a href="{{ route('donations.create') }}"
                                                    class="btn btn-primary rounded-pill">Commencer à donner</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3">
                            {{ $donations->links() }}
                        </div>
                    </div>
                </div>
            </div>
                <div class="glass-card border-0 rounded-4 p-5 mb-4">
                    <h5 class="fw-800 mb-4"><i class="fas fa-lightbulb me-2 text-warning"></i>Conseils pour vos dons</h5>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="p-3 bg-primary-light rounded-circle me-3">
                                    <i class="fas fa-camera text-primary"></i>
                                </div>
                                <span class="small">Prenez des photos claires de vos articles.</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="p-3 bg-success-light rounded-circle me-3">
                                    <i class="fas fa-tag text-success"></i>
                                </div>
                                <span class="small">Décrivez l'état réel de l'objet honnêtement.</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="p-3 bg-info-light rounded-circle me-3">
                                    <i class="fas fa-map-marker-alt text-info"></i>
                                </div>
                                <span class="small">Précisez le mode de remise de l'objet.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
