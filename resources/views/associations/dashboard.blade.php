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
            <a href="{{ route('association.dons') }}" class="btn btn-link btn-sm">
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

{{-- @extends('layouts.association')

@section('title', 'Tableau de bord Association - Main Tendue')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($association->logo)
                        <img src="{{ asset('storage/' . $association->logo) }}" 
                             alt="{{ $association->legal_name }}" 
                             class="rounded-circle mb-3" width="100" height="100">
                    @else
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-hands-helping fa-2x text-white"></i>
                        </div>
                    @endif
                    
                    <h5>{{ $association->legal_name }}</h5>
                    <p class="text-muted">{{ $association->contact_person }}</p>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('association.profile') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user me-2"></i>Éditer le profil
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">Navigation</h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('association.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Tableau de bord
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('association.donations.available') }}">
                                <i class="fas fa-gift me-2"></i>Dons disponibles
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('association.donations.received') }}">
                                <i class="fas fa-box-open me-2"></i>Dons reçus
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('association.messages') }}">
                                <i class="fas fa-envelope me-2"></i>Messages
                                <span class="badge bg-danger float-end">3</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('association.profile') }}">
                                <i class="fas fa-cog me-2"></i>Paramètres
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Baseline spécifiques -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">Baseline spécifiques</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-primary">Vêtements</span>
                        <span class="badge bg-success">Aliments</span>
                        <span class="badge bg-info">Produits d'hygiène</span>
                        <span class="badge bg-warning">Scolaire</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="col-lg-9 col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Tableau de bord</h2>
                    <p class="text-muted mb-0">Votre association est vérifiée et active sur la plateforme MAIN TENDUE.</p>
                </div>
                <span class="badge bg-success">
                    <i class="fas fa-check-circle me-1"></i>
                    Association vérifiée
                </span>
            </div>

            <!-- Description de l'association -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $association->legal_name }}</h5>
                    <p class="card-text text-muted">
                        {{ $association->city }}, {{ $association->country }}<br>
                        {{ $association->description ?? "Cette association est dédiée à la redistribution de biens essentiels aux familles défavorisées." }}
                    </p>
                </div>
            </div>
            
            <!-- Stats cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Dons collectés (6 mois)
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        1100
                                    </div>
                                    <div class="text-xs text-muted mt-1">
                                        Mis à jour quotidiennement
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Dons en attente
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        3
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Messages
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $stats['messages'] }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Note moyenne
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ number_format($stats['rating'], 1) }}/5
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-star fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques de collecte mensuelle -->
           <div class="card mb-4">
    <div class="card-header">
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
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Catalogue des dons proposés</h5>
                    <span class="badge bg-warning">Dons en attente (3)</span>
                </div>
                <div class="card-body">
                    <!-- Don 1 -->
                    <div class="row align-items-center mb-3 p-3 border rounded">
                        <div class="col-md-8">
                            <h6 class="mb-1">Lot de vêtements pour enfants (0-5 ans)</h6>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-primary">Vêtements</span>
                            </div>
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-user me-1"></i>Sophie Martin
                            </p>
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-home me-1"></i>Maison - 75010 Paris
                            </p>
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

                    <!-- Don 2 -->
                    <div class="row align-items-center mb-3 p-3 border rounded">
                        <div class="col-md-8">
                            <h6 class="mb-1">Cartons de livres et fournitures scolaires</h6>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-warning">Scolaire</span>
                            </div>
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-user me-1"></i>Marc Dupont
                            </p>
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-building me-1"></i>Appartement - 75003 Paris
                            </p>
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

                    <!-- Don 3 -->
                    <div class="row align-items-center p-3 border rounded">
                        <div class="col-md-8">
                            <h6 class="mb-1">Dons de conserves et pâtes longue durée</h6>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-success">Alimentaire</span>
                            </div>
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-user me-1"></i>Laure Fournier
                            </p>
                            <p class="mb-1 small text-muted">
                                <i class="fas fa-briefcase me-1"></i>Bureau - 75011 Paris
                            </p>
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

            <!-- Suivi des dons reçus -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Suivi des dons reçus</h5>
                    <a href="{{ route('association.donations.received') }}" class="btn btn-link btn-sm">
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
    </div>
</div>
@endsection


@push('styles')
<style>
    /* Dashboard Association */
    .dashboard-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .dashboard-card .card-body {
        padding: 1.5rem;
    }
    
    .dashboard-card .border-left-primary {
        border-left: 4px solid #4e73df !important;
    }
    
    .dashboard-card .border-left-success {
        border-left: 4px solid #1cc88a !important;
    }
    
    .dashboard-card .border-left-info {
        border-left: 4px solid #36b9cc !important;
    }
    
    .dashboard-card .border-left-warning {
        border-left: 4px solid #f6c23e !important;
    }
    
    .dashboard-card .text-gray-800 {
        color: #5a5c69 !important;
        font-size: 1.8rem;
        font-weight: 700;
    }
    
    .dashboard-card .text-gray-300 {
        color: #dddfeb !important;
    }
    
    /* Sidebar */
    .sidebar-nav .nav-link {
        color: #6c757d;
        padding: 0.75rem 1rem;
        border-radius: 5px;
        margin-bottom: 0.25rem;
        transition: all 0.3s;
    }
    
    .sidebar-nav .nav-link:hover {
        color: #4e73df;
        background-color: #f8f9fc;
    }
    
    .sidebar-nav .nav-link.active {
        color: #4e73df;
        background-color: #f8f9fc;
        font-weight: 600;
    }
    
    .sidebar-nav .nav-link i {
        width: 20px;
        text-align: center;
    }
    
    /* Recent donations table */
    .donations-table th {
        background-color: #f8f9fc;
        border-top: none;
        font-weight: 600;
        color: #5a5c69;
    }
    
    .donations-table td {
        vertical-align: middle;
    }
    
    .donations-table tr:hover {
        background-color: #f8f9fc;
    }

    /* Section Catalogue des dons */
    .donation-item {
        border-left: 4px solid transparent;
        transition: all 0.3s;
        border-radius: 8px;
    }
    
    .donation-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border-left-color: #4e73df;
    }
    
    .donation-item.badge-vetement {
        border-left-color: #4e73df;
    }
    
    .donation-item.badge-alimentaire {
        border-left-color: #1cc88a;
    }
    
    .donation-item.badge-scolaire {
        border-left-color: #f6c23e;
    }
    
    /* Badges spécifiques */
    .badge-vetement {
        background-color: #4e73df;
        color: white;
    }
    
    .badge-alimentaire {
        background-color: #1cc88a;
        color: white;
    }
    
    .badge-hygiene {
        background-color: #36b9cc;
        color: white;
    }
    
    .badge-scolaire {
        background-color: #f6c23e;
        color: white;
    }
    
    /* Boutons Accepter/Refuser */
    .donation-actions .btn {
        min-width: 100px;
    }
    
    /* Tableau Suivi des dons */
    .donations-tracking-table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
    }
    
    .donations-tracking-table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    /* Timeline d'expiration */
    .expiry-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    .expiry-badge.danger {
        background-color: #dc3545;
        color: white;
    }
    
    .expiry-badge.warning {
        background-color: #ffc107;
        color: #212529;
    }
    
    /* Graphique statistiques */
    .stats-chart-container {
        height: 200px;
        position: relative;
    }
    
    /* Baseline spécifiques */
    .baseline-badges .badge {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
        margin: 0.25rem;
    }
    
    /* Responsive pour les sections ajoutées */
    /* @media (max-width: 768px) {
        .donation-item {
            margin-bottom: 1rem;
        }
        
        .donation-actions {
            margin-top: 1rem;
        }
        
        .donation-actions .btn {
            width: 100%;
        }
        
        .baseline-badges .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
        }
    } */
    
   
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-card .card-body {
            padding: 1rem;
        }
        
        .dashboard-card .text-gray-800 {
            font-size: 1.5rem;
        }
    }


       .donation-item {
            margin-bottom: 1rem;
        }
        
        .donation-actions {
            margin-top: 1rem;
        }
        
        .donation-actions .btn {
            width: 100%;
        }
        
        .baseline-badges .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
        }

         /* Animation pour les éléments chargés dynamiquement */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Styles pour les messages d'alerte d'expiration */
    .expiry-alert {
        background: linear-gradient(45deg, #f8f9fa, #e9ecef);
        border-left: 4px solid #ffc107;
    }

    
    /* Quick actions */
    .quick-actions .btn {
        border-radius: 8px;
        padding: 0.75rem;
        text-align: left;
        transition: all 0.3s;
    }
    
    .quick-actions .btn:hover {
        transform: translateX(5px);
    }
    
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des cartes de statistiques
        const statCards = document.querySelectorAll('.dashboard-card');
        statCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.5s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            }, index * 100);
        });

    
        
        // GESTION DES DONS EN ATTENTE
        
        
        // Boutons Accepter/Refuser
        document.querySelectorAll('.btn-accept-donation').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const donationId = this.dataset.donationId;
                const donationTitle = this.dataset.donationTitle;
                
                if (confirm(`Êtes-vous sûr de vouloir accepter le don : "${donationTitle}" ?`)) {
                    // Simulation d'acceptation
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Traitement...';
                    this.disabled = true;
                    
                    setTimeout(() => {
                        alert(`Le don "${donationTitle}" a été accepté avec succès !`);
                        // Ici, normalement, vous feriez un appel AJAX
                        this.closest('.donation-item').remove();
                        updatePendingCount();
                    }, 1000);
                }
            });
        });
        
        document.querySelectorAll('.btn-reject-donation').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const donationId = this.dataset.donationId;
                const donationTitle = this.dataset.donationTitle;
                
                if (confirm(`Êtes-vous sûr de vouloir refuser le don : "${donationTitle}" ?`)) {
                    // Simulation de refus
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Traitement...';
                    this.disabled = true;
                    
                    setTimeout(() => {
                        alert(`Le don "${donationTitle}" a été refusé.`);
                        // Ici, normalement, vous feriez un appel AJAX
                        this.closest('.donation-item').remove();
                        updatePendingCount();
                    }, 1000);
                }
            });
        });
        
        // Mise à jour du compteur de dons en attente
        function updatePendingCount() {
            const pendingItems = document.querySelectorAll('.donation-item').length;
            const pendingBadge = document.querySelector('.pending-count');
            if (pendingBadge) {
                pendingBadge.textContent = `Dons en attente (${pendingItems})`;
            }
        }
        
        
        // GESTION DES EXPIRATIONS
        
        
        // Mise à jour dynamique des compteurs d'expiration
        function updateExpiryCounters() {
            document.querySelectorAll('.expiry-counter').forEach(counter => {
                const expiryDate = new Date(counter.dataset.expiryDate);
                const now = new Date();
                const diffTime = expiryDate - now;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (diffDays <= 0) {
                    counter.textContent = 'Expiré';
                    counter.className = 'badge expiry-badge danger';
                } else if (diffDays === 1) {
                    counter.textContent = 'Expire dans 24h';
                    counter.className = 'badge expiry-badge danger';
                } else if (diffDays <= 3) {
                    counter.textContent = `Expire dans ${diffDays} jours`;
                    counter.className = 'badge expiry-badge warning';
                } else {
                    counter.textContent = `Expire dans ${diffDays} jours`;
                    counter.className = 'badge bg-secondary';
                }
            });
        }
        
        // Mettre à jour les compteurs toutes les heures
        updateExpiryCounters();
        setInterval(updateExpiryCounters, 3600000); // Toutes les heures
        
        
        // GRAPHIQUE STATISTIQUES
        
        
        // Initialisation du graphique des statistiques mensuelles
        const chartElement = document.getElementById('monthlyStatsChart');
        if (chartElement) {
            // Simulation de données
            const monthlyData = {
                labels: ['Janv', 'Fév', 'Mars', 'Avr', 'Mai', 'Juin'],
                datasets: [{
                    label: 'Dons collectés',
                    data: [180, 220, 190, 210, 170, 130],
                    backgroundColor: [
                        'rgba(78, 115, 223, 0.8)',
                        'rgba(78, 115, 223, 0.8)',
                        'rgba(78, 115, 223, 0.8)',
                        'rgba(78, 115, 223, 0.8)',
                        'rgba(78, 115, 223, 0.8)',
                        'rgba(78, 115, 223, 0.8)'
                    ],
                    borderColor: [
                        'rgba(78, 115, 223, 1)',
                        'rgba(78, 115, 223, 1)',
                        'rgba(78, 115, 223, 1)',
                        'rgba(78, 115, 223, 1)',
                        'rgba(78, 115, 223, 1)',
                        'rgba(78, 115, 223, 1)'
                    ],
                    borderWidth: 1
                }]
            };
            
            // Vérifier si Chart.js est disponible
            if (typeof Chart !== 'undefined') {
                new Chart(chartElement, {
                    type: 'bar',
                    data: monthlyData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.dataset.label}: ${context.raw} dons`;
                                    }
                                }
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
            } else {
                // Fallback si Chart.js n'est pas chargé
                chartElement.parentElement.innerHTML = `
                    <div class="text-center py-4">
                        <p class="text-muted">Graphique de statistiques (1100 dons sur 6 mois)</p>
                        <div class="d-flex justify-content-center align-items-end mb-3" style="height: 150px;">
                            <div class="mx-2 d-flex flex-column align-items-center">
                                <div style="height: 120px; width: 30px; background-color: #4e73df;"></div>
                                <small>Janv<br>180</small>
                            </div>
                            <div class="mx-2 d-flex flex-column align-items-center">
                                <div style="height: 150px; width: 30px; background-color: #4e73df;"></div>
                                <small>Fév<br>220</small>
                            </div>
                            <div class="mx-2 d-flex flex-column align-items-center">
                                <div style="height: 130px; width: 30px; background-color: #4e73df;"></div>
                                <small>Mars<br>190</small>
                            </div>
                            <div class="mx-2 d-flex flex-column align-items-center">
                                <div style="height: 145px; width: 30px; background-color: #4e73df;"></div>
                                <small>Avr<br>210</small>
                            </div>
                            <div class="mx-2 d-flex flex-column align-items-center">
                                <div style="height: 125px; width: 30px; background-color: #4e73df;"></div>
                                <small>Mai<br>170</small>
                            </div>
                            <div class="mx-2 d-flex flex-column align-items-center">
                                <div style="height: 100px; width: 30px; background-color: #4e73df;"></div>
                                <small>Juin<br>130</small>
                            </div>
                        </div>
                    </div>
                `;
            }
        }
        
        
        // ANIMATIONS SUPPLEMENTAIRES
        
        
        // Animation d'apparition des éléments
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        // Observer les sections principales
        document.querySelectorAll('.card').forEach(card => {
            observer.observe(card);
        });
        
        
        // SIMULATION DE DONNEES TEMPS REEL
        
        
        // Simuler une mise à jour du total de dons
        let totalDonations = 1100;
        setInterval(() => {
            // Simuler l'ajout aléatoire de dons
            if (Math.random() > 0.7) {
                totalDonations += Math.floor(Math.random() * 3) + 1;
                const totalElement = document.querySelector('.total-donations-count');
                if (totalElement) {
                    totalElement.textContent = totalDonations;
                    totalElement.classList.add('text-success');
                    setTimeout(() => {
                        totalElement.classList.remove('text-success');
                    }, 1000);
                }
            }
        }, 30000); // Toutes les 30 secondes
        
        
        // GESTION DES FILTRES 
    
        
        // Exemple de filtrage par catégorie
        document.querySelectorAll('.filter-category').forEach(filter => {
            filter.addEventListener('click', function(e) {
                e.preventDefault();
                const category = this.dataset.category;
                
                // Retirer la classe active de tous les filtres
                document.querySelectorAll('.filter-category').forEach(f => {
                    f.classList.remove('active');
                });
                
                // Activer le filtre cliqué
                this.classList.add('active');
                
                // Filtrer les dons en attente
                document.querySelectorAll('.donation-item').forEach(item => {
                    if (category === 'all') {
                        item.style.display = 'flex';
                    } else {
                        const itemCategory = item.dataset.category;
                        if (itemCategory === category) {
                            item.style.display = 'flex';
                        } else {
                            item.style.display = 'none';
                        }
                    }
                });
            });
        });
        
        
        // NOTIFICATIONS
        
        
        // Vérifier les dons sur le point d'expirer
        function checkExpiringDonations() {
            const expiringItems = document.querySelectorAll('.expiry-badge.danger');
            if (expiringItems.length > 0 && !localStorage.getItem('expiryAlertShown')) {
                const alertMessage = `${expiringItems.length} don(s) expire(nt) dans moins de 24h !`;
                if (Notification.permission === "granted") {
                    new Notification("Main Tendue - Alerte Expiration", {
                        body: alertMessage,
                        icon: '/favicon.ico'
                    });
                } else if (Notification.permission !== "denied") {
                    Notification.requestPermission().then(permission => {
                        if (permission === "granted") {
                            new Notification("Main Tendue - Alerte Expiration", {
                                body: alertMessage,
                                icon: '/favicon.ico'
                            });
                        }
                    });
                }
                
                localStorage.setItem('expiryAlertShown', 'true');
                setTimeout(() => {
                    localStorage.removeItem('expiryAlertShown');
                }, 3600000); // Réafficher après 1 heure
            }
        }
        
        // Vérifier toutes les 5 minutes
        setInterval(checkExpiringDonations, 300000);
        
        console.log('Dashboard association initialisé avec succès!');
    });





        
        // Mettre à jour l'heure actuelle
        function updateTime() {
            const now = new Date();
            const timeElement = document.getElementById('currentTime');
            if (timeElement) {
                timeElement.textContent = now.toLocaleTimeString('fr-FR', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
        }
        
        updateTime();
        setInterval(updateTime, 60000);
        
        // Notification badge animation
        const messageBadge = document.querySelector('.nav-link[href*="messages"] .badge');
        if (messageBadge && parseInt(messageBadge.textContent) > 0) {
            setInterval(() => {
                messageBadge.classList.toggle('bg-danger');
                messageBadge.classList.toggle('bg-warning');
            }, 2000);
        }
        
        // Chart example (si vous utilisez des graphiques)
        if (typeof Chart !== 'undefined') {
            const ctx = document.getElementById('donationsChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                        datasets: [{
                            label: 'Dons reçus',
                            data: [12, 19, 3, 5, 2, 3],
                            borderColor: '#4e73df',
                            backgroundColor: 'rgba(78, 115, 223, 0.05)',
                            tension: 0.4
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
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }
    
</script>
@endpush



{{-- @extends('layouts.association')

@section()

@section('content')
@if($association->verification_status === 'verified')
    <div class="alert-success-custom">
        <i class="fas fa-check-circle"></i> Votre association est vérifiée et active sur la plateforme MAIN TENDUE.
    </div>
@endif

<div class="association-header-grid">
    <div class="card profile-card">
        <div class="profile-main">
            <img src="{{ $association->logo }}" alt="Logo" class="asso-logo-large">
            <div>
                <h2>{{ $association->legal_name }}</h2>
                <p class="location"><i class="fas fa-map-marker-alt"></i> {{ $association->legal_address }}</p>
            </div>
        </div>
        <p class="description">{{ Str::limit($association->description, 150) }}</p>
        <div class="needs-tags">
            <strong>Besoins :</strong>
            <span class="tag">Vêtements</span> <span class="tag">Aliments</span>
        </div>
        <button class="btn-edit"><i class="fas fa-pen"></i> Éditer le profil</button>
    </div>

    <div class="card stats-card">
        <h4>Statistiques de collecte mensuelle</h4>
        <canvas id="assoStatsChart"></canvas>
        <p class="stats-footer">Total de <strong>{{ $association->stats_total_donations }}</strong> dons collectés.</p>
    </div>
</div>

<h3 class="mt-4">Catalogue des dons proposés</h3>
<div class="donations-grid">
    @foreach($pendingDonations as $donation)
    <div class="donation-item-card">
        <div class="card-image">
            <img src="{{ $donation->photo_url }}" alt="Don">
            <span class="badge-status">En attente</span>
        </div>
        <div class="card-body">
            <h5>{{ $donation->title }}</h5>
            <p><i class="fas fa-tag"></i> {{ $donation->category }}</p>
            <p><i class="fas fa-user"></i> {{ $donation->donor->name }}</p>
            <div class="card-actions">
                <button class="btn-accept">Accepter</button>
                <button class="btn-refuse">Refuser</button>
            </div>
        </div>
    </div>
    @endforeach
</div>

<h3 class="mt-4">Suivi des dons reçus</h3>
<div class="card table-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>ARTICLE</th>
                <th>DONATEUR</th>
                <th>DATE</th>
                <th>QUANTITÉ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receivedDonations as $don)
            <tr>
                <td>{{ $don->id }}</td>
                <td>{{ $don->title }}</td>
                <td>{{ $don->donor->name }}</td>
                <td>{{ $don->updated_at->format('d/m/Y') }}</td>
                <td>{{ $don->quantity ?? '1 unité' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}} 