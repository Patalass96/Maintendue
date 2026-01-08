@extends('layouts.association')

@section('title', 'Dons reçus - Main Tendue')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4">
            @include('association.partials.sidebar')
        </div>
        
        <!-- Main content -->
        <div class="col-lg-9 col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dons reçus</h2>
                <span class="badge bg-primary">{{ $donations->total() }} dons</span>
            </div>
            
            <!-- Statistiques -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h6 class="card-title">Total reçu</h6>
                            <h4>{{ $donations->total() }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h6 class="card-title">Ce mois</h6>
                            <h4>{{ $monthCount }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h6 class="card-title">En attente</h6>
                            <h4>{{ $pendingCount }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h6 class="card-title">Livrés</h6>
                            <h4>{{ $deliveredCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Liste des dons -->
            <div class="card">
                <div class="card-body">
                    @if($donations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Don</th>
                                        <th>Donateur</th>
                                        <th>Date d'acceptation</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($donations as $donation)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($donation->images->first())
                                                        <img src="{{ asset('storage/' . $donation->images->first()->path) }}" 
                                                             alt="{{ $donation->title }}" 
                                                             class="rounded me-3"
                                                             width="50" height="50" style="object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <strong>{{ $donation->title }}</strong>
                                                        <div class="text-muted small">{{ $donation->category->name ?? '' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($donation->donor->avatar)
                                                        <img src="{{ asset('storage/' . $donation->donor->avatar) }}" 
                                                             alt="{{ $donation->donor->name }}" 
                                                             class="rounded-circle me-2"
                                                             width="30" height="30">
                                                    @endif
                                                    <div>{{ $donation->donor->name }}</div>
                                                </div>
                                            </td>
                                            <td>{{ $donation->updated_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @switch($donation->status)
                                                    @case('accepted')
                                                        <span class="badge bg-warning">Accepté</span>
                                                        @break
                                                    @case('scheduled')
                                                        <span class="badge bg-info">Planifié</span>
                                                        @break
                                                    @case('delivered')
                                                        <span class="badge bg-success">Livré</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge bg-danger">Annulé</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $donation->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('donations.show', $donation) }}" 
                                                       class="btn btn-outline-primary"
                                                       title="Voir détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-outline-success"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#statusModal{{ $donation->id }}"
                                                            title="Changer statut">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </button>
                                                    <a href="#" 
                                                       class="btn btn-outline-info"
                                                       title="Contacter">
                                                        <i class="fas fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        <!-- Modal pour changer le statut -->
                                        <div class="modal fade" id="statusModal{{ $donation->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('association.donations.update-status', $donation) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Changer le statut du don</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="status{{ $donation->id }}" class="form-label">Nouveau statut</label>
                                                                <select class="form-select" id="status{{ $donation->id }}" name="status" required>
                                                                    <option value="accepted" {{ $donation->status == 'accepted' ? 'selected' : '' }}>Accepté</option>
                                                                    <option value="scheduled" {{ $donation->status == 'scheduled' ? 'selected' : '' }}>Planifié</option>
                                                                    <option value="delivered" {{ $donation->status == 'delivered' ? 'selected' : '' }}>Livré</option>
                                                                    <option value="cancelled" {{ $donation->status == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="notes{{ $donation->id }}" class="form-label">Notes (optionnel)</label>
                                                                <textarea class="form-control" id="notes{{ $donation->id }}" name="notes" rows="3">{{ $donation->association_notes }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $donations->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                            <h3>Aucun don reçu</h3>
                            <p class="text-muted mb-4">
                                Vous n'avez pas encore reçu de dons.<br>
                                Commencez par accepter des dons disponibles.
                            </p>
                            <a href="{{ route('association.donations.available') }}" class="btn btn-primary">
                                <i class="fas fa-gift me-2"></i>Voir les dons disponibles
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Received Donations */
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
    }
    
    .badge-accepted { background: #fff3cd; color: #856404; }
    .badge-scheduled { background: #d1ecf1; color: #0c5460; }
    .badge-delivered { background: #d4edda; color: #155724; }
    .badge-cancelled { background: #f8d7da; color: #721c24; }
    
    /* Stats cards */
    .stats-card {
        border: none;
        border-radius: 10px;
        color: white;
        transition: transform 0.3s;
    }
    
    .stats-card:hover {
        transform: translateY(-3px);
    }
    
    .stats-card .card-body {
        padding: 1.5rem;
    }
    
    .stats-card h4 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }
    
    .stats-card h6 {
        opacity: 0.9;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    /* Table styles */
    .donations-table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .donations-table thead th {
        background: #f8f9fc;
        border-top: 1px solid #e3e6f0;
        border-bottom: 2px solid #e3e6f0;
        padding: 1rem;
        font-weight: 600;
        color: #5a5c69;
        white-space: nowrap;
    }
    
    .donations-table tbody tr {
        transition: background 0.3s;
    }
    
    .donations-table tbody tr:hover {
        background: #f8f9fc;
    }
    
    .donations-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #e3e6f0;
    }
    
    .donations-table .donor-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .donations-table .item-image {
        width: 50px;
        height: 50px;
        border-radius: 5px;
        object-fit: cover;
    }
    
    /* Action buttons */
    .action-buttons .btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        margin-right: 5px;
    }
    
    /* Modal styles */
    .status-modal .modal-dialog {
        max-width: 500px;
    }
    
    .status-modal .form-select {
        border-radius: 8px;
        padding: 0.75rem;
    }
    
    /* Timeline (optionnel) */
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #4e73df;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -33px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: white;
        border: 2px solid #4e73df;
    }
    
    /* Empty state */
    .empty-state-received {
        padding: 4rem 1rem;
    }
    
    .empty-state-received .icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
    }
    
    /* Responsive table */
    @media (max-width: 768px) {
        .donations-table {
            display: block;
            overflow-x: auto;
        }
        
        .stats-card .card-body {
            padding: 1rem;
        }
        
        .stats-card h4 {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mettre à jour le statut d'un don
        const statusModals = document.querySelectorAll('.status-modal');
        statusModals.forEach(modal => {
            const form = modal.querySelector('form');
            const select = form.querySelector('select[name="status"]');
            const notes = form.querySelector('textarea[name="notes"]');
            
            select.addEventListener('change', function() {
                // Ajuster les notes suggérées selon le statut
                const suggestions = {
                    'scheduled': 'Merci de préciser la date et heure prévue de livraison.',
                    'delivered': 'Le don a été livré avec succès.',
                    'cancelled': 'Veuillez indiquer la raison de l\'annulation.'
                };
                
                if (suggestions[this.value] && !notes.value) {
                    notes.placeholder = suggestions[this.value];
                }
            });
            
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button[type="submit"]');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mise à jour...';
                button.disabled = true;
                
                setTimeout(() => {
                    // En production, cette partie serait gérée par Laravel
                    // Ici on simule juste un délai
                    button.innerHTML = originalText;
                    button.disabled = false;
                    
                    // Fermer le modal
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    modalInstance.hide();
                    
                    // Afficher une notification
                    showNotification('Statut mis à jour avec succès !', 'success');
                }, 1500);
            });
        });
        
        // Filtrer par statut
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                const status = this.value;
                const rows = document.querySelectorAll('.donations-table tbody tr');
                
                rows.forEach(row => {
                    const rowStatus = row.dataset.status;
                    if (!status || rowStatus === status) {
                        row.style.display = '';
                        setTimeout(() => {
                            row.style.opacity = '1';
                        }, 100);
                    } else {
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.style.display = 'none';
                        }, 300);
                    }
                });
                
                // Mettre à jour le compteur
                updateVisibleCount();
            });
        }
        
        function updateVisibleCount() {
            const visibleRows = document.querySelectorAll('.donations-table tbody tr[style=""]').length;
            const counter = document.querySelector('.visible-count');
            if (counter) {
                counter.textContent = `${visibleRows} dons`;
            }
        }
        
        // Fonction de notification
        function showNotification(message, type = 'info') {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            alert.style.cssText = `
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            `;
            
            const icons = {
                'success': 'check-circle',
                'error': 'exclamation-triangle',
                'info': 'info-circle',
                'warning': 'exclamation-circle'
            };
            
            alert.innerHTML = `
                <i class="fas fa-${icons[type] || 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(alert);
            
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 5000);
        }
        
        // Exporter les données (exemple)
        const exportBtn = document.getElementById('exportDonations');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                // En production, cela ferait une requête au serveur
                // Pour l'instant, on simule
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Génération...';
                this.disabled = true;
                
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-download me-2"></i> Exporter';
                    this.disabled = false;
                    showNotification('Export généré avec succès !', 'success');
                }, 2000);
            });
        }
        
        // Initialiser le compteur
        updateVisibleCount();
        
        // Animation des statistiques
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 200);
        });
    });
</script>
@endpush

@endsection