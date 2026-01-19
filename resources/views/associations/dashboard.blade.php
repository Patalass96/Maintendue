@extends('layouts.association')

@section('title', 'Tableau de bord Association - Main Tendue')
@section('styles')
    @vite(['resources/css/association.css'])
@endsection

@section('content')
<div class="assoc-container">
    <!-- Alert de vérification -->
    <div class="alert alert-success mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <strong>Votre association est vérifiée et active</strong> sur la plateforme MAIN TENDUE.
    </div>

    <!-- Baseline spécifiques -->
    <div class="mb-4">
        <h5 class="mb-3">Baseline spécifiques</h5>
        <div class="d-flex flex-wrap gap-2">
            <span class="badge bg-primary p-2">Vêtements</span>
            <span class="badge bg-success p-2">Aliments</span>
            <span class="badge bg-info p-2">Produits d'hygiène</span>
            <span class="badge bg-warning p-2">Scolaire</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-5">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="assoc-stat-card stat-primary">
                <div class="stat-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-content">
                    <h3>1100</h3>
                    <p>Dons collectés (6 mois)</p>
                    <small class="text-muted">Mis à jour quotidiennement</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="assoc-stat-card stat-success">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3>3</h3>
                    <p>Dons en attente</p>
                    <small class="text-muted">À traiter</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="assoc-stat-card stat-info">
                <div class="stat-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['messages'] ?? 5 }}</h3>
                    <p>Messages</p>
                    <small class="text-muted">Non lus</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="assoc-stat-card stat-warning">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['rating'] ?? 4.5, 1) }}/5</h3>
                    <p>Note moyenne</p>
                    <small class="text-muted">Avis donateurs</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques de collecte mensuelle -->
    <div class="assoc-card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Statistiques de collecte mensuelle</h5>
            <p class="text-muted mb-0 small">Vue d'ensemble des dons collectés par mois.</p>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <canvas id="monthlyStatsChart" height="100"></canvas>
            </div>
            <p class="mb-0"><strong>Total de 1100 dons collectés au cours des 6 derniers mois.</strong></p>
            <small class="text-muted">Les données sont mises à jour quotidiennement.</small>
        </div>
    </div>

    <!-- Catalogue des dons proposés -->
    <div class="assoc-card mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Catalogue des dons proposés</h5>
            <span class="badge bg-warning">Dons en attente (3)</span>
        </div>
        <div class="card-body">
            <!-- Don 1 -->
            <div class="donation-item mb-3 p-3 border rounded">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="mb-1">Lot de vêtements pour enfants (0-5 ans)</h6>
                        <div class="mb-2">
                            <span class="badge bg-primary">Vêtements</span>
                        </div>
                        <div class="mb-2">
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-user me-1"></i>Sophie Martin
                            </p>
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-home me-1"></i>Maison - 75010 Paris
                            </p>
                        </div>
                        <span class="badge bg-danger">
                            <i class="fas fa-clock me-1"></i>Expire dans 3 jours
                        </span>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="d-grid gap-2">
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-check me-1"></i>Accepter
                            </button>
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-times me-1"></i>Refuser
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Don 2 -->
            <div class="donation-item mb-3 p-3 border rounded">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="mb-1">Cartons de livres et fournitures scolaires</h6>
                        <div class="mb-2">
                            <span class="badge bg-warning">Scolaire</span>
                        </div>
                        <div class="mb-2">
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-user me-1"></i>Marc Dupont
                            </p>
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-building me-1"></i>Appartement - 75003 Paris
                            </p>
                        </div>
                        <span class="badge bg-danger">
                            <i class="fas fa-clock me-1"></i>Expire dans 24h
                        </span>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="d-grid gap-2">
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-check me-1"></i>Accepter
                            </button>
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-times me-1"></i>Refuser
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Don 3 -->
            <div class="donation-item p-3 border rounded">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="mb-1">Dons de conserves et pâtes longue durée</h6>
                        <div class="mb-2">
                            <span class="badge bg-success">Alimentaire</span>
                        </div>
                        <div class="mb-2">
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-user me-1"></i>Laure Fournier
                            </p>
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-briefcase me-1"></i>Bureau - 75011 Paris
                            </p>
                        </div>
                        <span class="badge bg-warning">
                            <i class="fas fa-clock me-1"></i>Expire dans 5 jours
                        </span>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="d-grid gap-2">
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-check me-1"></i>Accepter
                            </button>
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-times me-1"></i>Refuser
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Suivi des dons reçus -->
    <div class="assoc-card">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Suivi des dons reçus</h5>
            <a href="{{ route('associations.donation.received') }}" class="btn btn-link btn-sm">
                Voir tout l'historique
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Article</th>
                            <th>Donateur</th>
                            <th>Date de réception</th>
                            <th>Quantité</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>r1</td>
                            <td>Vêtements d'hiver (adultes)</td>
                            <td>Jean Delmas</td>
                            <td>12/03/2024</td>
                            <td>2 sacs</td>
                        </tr>
                        <tr>
                            <td>r2</td>
                            <td>Ordinateur portable reconditionné</td>
                            <td>Emma Lefevre</td>
                            <td>05/03/2024</td>
                            <td>1 unité</td>
                        </tr>
                        <tr>
                            <td>r3</td>
                            <td>Packs de couches et lait infantile</td>
                            <td>Famille Dubois</td>
                            <td>28/02/2024</td>
                            <td>5 packs</td>
                        </tr>
                        <tr>
                            <td>r4</td>
                            <td>Vaisselle et ustensiles de cuisine</td>
                            <td>Pauline Gauthier</td>
                            <td>19/02/2024</td>
                            <td>Lot complet</td>
                        </tr>
                        <tr>
                            <td>r5</td>
                            <td>Bottes et chaussures enfants</td>
                            <td>Théo Lambert</td>
                            <td>10/02/2024</td>
                            <td>15 paires</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-4 text-center text-muted">
        <hr>
        <p class="small">© 2025 MAIN TENDUE. Tous droits réservés.</p>
    </div>
</div>
@push('styles')
<!-- Styles spécifiques pour ce dashboard -->
<style>
    /* Override pour compatibilité avec association.css */
    .assoc-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Stat Cards */
    .assoc-stat-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
        border: 1px solid #e3e6f0;
    }

    .assoc-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
        flex-shrink: 0;
        color: white;
        font-size: 1.5rem;
    }

    .stat-primary .stat-icon { background-color: #4e73df; }
    .stat-success .stat-icon { background-color: #1cc88a; }
    .stat-info .stat-icon { background-color: #36b9cc; }
    .stat-warning .stat-icon { background-color: #f6c23e; }

    .stat-content h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #5a5c69;
        margin: 0;
        line-height: 1;
    }

    .stat-content p {
        font-weight: 600;
        color: #4e73df;
        margin: 0.25rem 0;
        font-size: 0.95rem;
    }

    .stat-content small {
        color: #858796;
        font-size: 0.85rem;
    }

    /* Cards compatibles avec association.css */
    .assoc-card {
        background: white;
        border-radius: var(--border-radius, 8px);
        box-shadow: var(--shadow, 0 4px 6px rgba(0,0,0,0.1));
        margin-bottom: 1.5rem;
        border: 1px solid #e3e6f0;
    }

    .assoc-card .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius, 8px) var(--border-radius, 8px) 0 0 !important;
    }

    .assoc-card .card-body {
        padding: 1.5rem;
    }

    /* Donation Items */
    .donation-item {
        transition: all 0.3s;
        border-left: 4px solid transparent !important;
        border-radius: 8px
    }

    .donation-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        background-color: #f8f9fc;
        border-left-color: #4e73df;
    }

    /* Badges d'expiration */
    .badge.bg-danger {
        background-color: #e74a3b !important;
    }

    .badge.bg-warning {
        background-color: #f6c23e !important;
        color: #5a5c69 !important;
    }

    /* Table */
    .table th {
        font-weight: 600;
        color: #5a5c69;
        background-color: #f8f9fc;
        border-top: none;
    }

    .table td {
        color: #6c757d;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #f8f9fc;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .assoc-stat-card {
            flex-direction: column;
            text-align: center;
            padding: 1rem;
        }

        .stat-icon {
            margin-right: 0;
            margin-bottom: 1rem;
        }

        .donation-item .row {
            flex-direction: column;
        }

        .donation-item .col-md-4 {
            text-align: left !important;
            margin-top: 1rem;
        }

        .donation-item .d-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>
@endpush
<!-- Scripts pour ce dashboard -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser le graphique des statistiques mensuelles
        const chartElement = document.getElementById('monthlyStatsChart');
        if (chartElement && typeof Chart !== 'undefined') {
            new Chart(chartElement, {
                type: 'bar',
                data: {
                    labels: ['Janv', 'Fév', 'Mars', 'Avr', 'Mai', 'Juin'],
                    datasets: [{
                        label: 'Dons collectés',
                        data: [180, 220, 190, 210, 170, 130],
                        backgroundColor: '#4e73df',
                        borderColor: '#2e59d9',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Nombre de dons'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Mois'
                            }
                        }
                    }
                }
            });
        }

        // Gestion des boutons Accepter/Refuser
        document.querySelectorAll('.btn-success').forEach(btn => {
            btn.addEventListener('click', function() {
                const donationItem = this.closest('.donation-item');
                const donationTitle = donationItem.querySelector('h6').textContent;

                if (confirm(`Accepter le don : "${donationTitle}" ?`)) {
                    // Simulation d'acceptation
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Traitement...';
                    this.disabled = true;
                    this.nextElementSibling.disabled = true;

                    setTimeout(() => {
                        donationItem.style.borderLeft = '4px solid #28a745 !important';
                        this.innerHTML = '<i class="fas fa-check me-1"></i>Accepté';

                        // Mettre à jour le compteur
                        updatePendingCount();
                        showSuccessAlert(`Don "${donationTitle}" accepté avec succès !`);
                    }, 1000);
                }
            });
        });

        document.querySelectorAll('.btn-outline-danger').forEach(btn => {
            btn.addEventListener('click', function() {
                const donationItem = this.closest('.donation-item');
                const donationTitle = donationItem.querySelector('h6').textContent;

                if (confirm(`Refuser le don : "${donationTitle}" ?`)) {
                    // Simulation de refus
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Traitement...';
                    this.disabled = true;
                    this.previousElementSibling.disabled = true;

                    setTimeout(() => {
                        donationItem.style.opacity = '0.6';
                        donationItem.style.borderLeft = '4px solid #dc3545 !important';
                        this.innerHTML = '<i class="fas fa-times me-1"></i>Refusé';

                        // Mettre à jour le compteur
                        updatePendingCount();
                    }, 1000);
                }
            });
        });

        // Mettre à jour le compteur de dons en attente
        function updatePendingCount() {
            const pendingItems = document.querySelectorAll('.donation-item').length;
            const pendingBadge = document.querySelector('.card-header .badge.bg-warning');
            if (pendingBadge) {
                pendingBadge.textContent = `Dons en attente (${pendingItems})`;
            }
        }

        // Fonction pour afficher des alertes de succès
        function showSuccessAlert(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            const container = document.querySelector('.assoc-container');
            container.insertBefore(alertDiv, container.firstChild);

            // Auto-remove after 5 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        console.log('Dashboard association initialisé avec succès !');
    });
</script>
     @endpush


     @section('script')
    @vite(['resources/css/association.js'])
@endsection
@endsection
