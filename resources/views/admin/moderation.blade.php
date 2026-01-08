@extends('layouts.admin')

@section('title', 'Modération')
@section('page-title', 'Modération des annonces ')

@section('content')
<div class="moderation-container">
    
    <!-- Statistiques de modération -->
    <div class="moderation-stats mb-30">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon bg-orange">
                    <i class="fas fa-flag"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">18</h3>
                    <p class="stat-label">Signalements en attente</p>
                    <span class="stat-trend negative">+3 aujourd'hui</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon bg-blue">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">245</h3>
                    <p class="stat-label">Signalements traités</p>
                    <span class="stat-trend positive">97% résolus</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon bg-red">
                    <i class="fas fa-ban"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">12</h3>
                    <p class="stat-label">Comptes suspendus</p>
                    <span class="stat-trend">Ce mois</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon bg-green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">48h</h3>
                    <p class="stat-label">Temps moyen de réponse</p>
                    <span class="stat-trend positive">-12h vs dernier mois</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Onglets de modération -->
    <div class="moderation-tabs mb-30">
        <div class="tabs-header">
            <button class="tab-btn active" data-tab="pending">
                <i class="fas fa-clock"></i>
                En Attente
                <span class="tab-badge">18</span>
            </button>
            <button class="tab-btn" data-tab="in-progress">
                <i class="fas fa-spinner"></i>
                En Cours
                <span class="tab-badge">7</span>
            </button>
            <button class="tab-btn" data-tab="resolved">
                <i class="fas fa-check"></i>
                Résolus
                <span class="tab-badge">245</span>
            </button>
            <button class="tab-btn" data-tab="suspended">
                <i class="fas fa-ban"></i>
                Suspendus
                <span class="tab-badge">12</span>
            </button>
        </div>
    </div>

    <!-- Filtres de modération -->
    <div class="admin-filters mb-20">
        <div class="filter-row">
            <div class="filter-group">
                <select class="filter-select">
                    <option value="">Tous les types</option>
                    <option value="content">Contenu inapproprié</option>
                    <option value="spam">Spam</option>
                    <option value="fraud">Tentative de fraude</option>
                    <option value="harassment">Harcèlement</option>
                    <option value="other">Autre</option>
                </select>
                
                <select class="filter-select">
                    <option value="">Tous les niveaux</option>
                    <option value="low">Faible</option>
                    <option value="medium">Moyen</option>
                    <option value="high">Élevé</option>
                    <option value="critical">Critique</option>
                </select>
                
                <input type="date" class="filter-select" placeholder="Date de signalement">
            </div>
            
            <div class="filter-actions">
                <button class="btn btn-secondary">
                    <i class="fas fa-filter"></i>
                    Appliquer les filtres
                </button>
                <button class="btn btn-outline">
                    <i class="fas fa-redo"></i>
                    Réinitialiser
                </button>
            </div>
        </div>
    </div>

    <!-- Signalements en attente (Onglet actif par défaut) -->
    <div class="tab-content active" id="pending-tab">
        <div class="reports-grid">
            @for($i = 1; $i <= 6; $i++)
            <div class="report-card" data-severity="{{ ['medium', 'high', 'low', 'critical', 'medium', 'high'][$i-1] }}">
                <div class="report-header">
                    <div class="report-meta">
                        <span class="report-id">#REP-00{{ $i }}</span>
                        <span class="report-date">Il y a {{ $i * 2 }} heures</span>
                    </div>
                    <span class="severity-badge severity-{{ ['medium', 'high', 'low', 'critical', 'medium', 'high'][$i-1] }}">
                        {{ ['Moyen', 'Élevé', 'Faible', 'Critique', 'Moyen', 'Élevé'][$i-1] }}
                    </span>
                </div>
                
                <div class="report-content">
                    <h4 class="report-title">
                        <i class="fas fa-{{ ['comment', 'user', 'image', 'money-bill', 'comment', 'user'][$i-1] }}"></i>
                        {{ 
                            [
                                'Commentaire inapproprié',
                                'Profil suspect',
                                'Photo non conforme',
                                'Tentative de fraude',
                                'Spam répétitif',
                                'Harcèlement'
                            ][$i-1] 
                        }}
                    </h4>
                    
                    <div class="report-details">
                        <div class="detail-item">
                            <strong>Signalé par :</strong>
                            <span>Utilisateur #{{ $i * 100 }}</span>
                        </div>
                        <div class="detail-item">
                            <strong>Cible :</strong>
                            <span>
                                @if($i % 2 == 0)
                                Association #{{ $i * 50 }}
                                @else
                                Utilisateur #{{ $i * 75 }}
                                @endif
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Type :</strong>
                            <span class="report-type">{{ ['Contenu', 'Utilisateur', 'Contenu', 'Sécurité', 'Contenu', 'Utilisateur'][$i-1] }}</span>
                        </div>
                    </div>
                    
                    <div class="report-description">
                        <p>{{ 
                            [
                                'Le commentaire contient des propos insultants et non conformes à notre charte.',
                                'Le profil semble utiliser des photos volées et des informations falsifiées.',
                                'La photo de profil est inappropriée et ne respecte pas nos règles.',
                                'Tentative de collecte frauduleuse de fonds pour une cause inexistante.',
                                'Publication répétitive de publicités non sollicitées.',
                                'Messages insistants et non désirés envers plusieurs membres.'
                            ][$i-1] 
                        }}</p>
                    </div>
                </div>
                
                <div class="report-actions">
                    <button class="btn btn-sm btn-success btn-validate-report" data-id="{{ $i }}">
                        <i class="fas fa-check"></i>
                        Marquer comme traité
                    </button>
                    <button class="btn btn-sm btn-warning btn-assign" data-id="{{ $i }}">
                        <i class="fas fa-user-tie"></i>
                        M'assigner
                    </button>
                    <button class="btn btn-sm btn-outline btn-view-details" data-id="{{ $i }}">
                        <i class="fas fa-eye"></i>
                        Voir détails
                    </button>
                    <button class="btn btn-sm btn-danger btn-reject" data-id="{{ $i }}">
                        <i class="fas fa-times"></i>
                        Rejeter
                    </button>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Signalements en cours -->
    <div class="tab-content" id="in-progress-tab">
        <div class="empty-state">
            <i class="fas fa-spinner fa-spin fa-3x"></i>
            <h3>Aucun signalement en cours</h3>
            <p>Les signalements assignés apparaîtront ici.</p>
        </div>
    </div>

    <!-- Signalements résolus -->
    <div class="tab-content" id="resolved-tab">
        <div class="admin-table-container">
            <table class="admin-table" id="resolvedTable">
                <thead>
                    <tr>
                        <th>ID Signalement</th>
                        <th>Type</th>
                        <th>Signalé par</th>
                        <th>Cible</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 1; $i <= 10; $i++)
                    <tr>
                        <td>#REP-{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <span class="report-type-badge type-{{ ['content', 'user', 'security'][$i % 3] }}">
                                {{ ['Contenu', 'Utilisateur', 'Sécurité'][$i % 3] }}
                            </span>
                        </td>
                        <td>User-{{ $i * 25 }}</td>
                        <td>
                            @if($i % 2 == 0)
                            <span class="target-association">Association {{ $i * 10 }}</span>
                            @else
                            <span class="target-user">User-{{ $i * 15 }}</span>
                            @endif
                        </td>
                        <td>2024-12-{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <span class="status-badge resolved">Résolu</span>
                        </td>
                        <td>
                            <button class="btn-icon btn-view" title="Voir">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" title="Réouvrir">
                                <i class="fas fa-redo"></i>
                            </button>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- Comptes suspendus -->
    <div class="tab-content" id="suspended-tab">
        <div class="suspended-accounts">
            @for($i = 1; $i <= 5; $i++)
            <div class="suspended-card">
                <div class="suspended-header">
                    <div class="user-avatar">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <div class="user-info">
                        <h4>Compte #{{ $i * 100 }}</h4>
                        <p>Suspendu le {{ $i }}/12/2024</p>
                    </div>
                    <div class="suspension-duration">
                        <span class="duration-badge">{{ ['7 jours', '30 jours', 'Permanent', '14 jours', '30 jours'][$i-1] }}</span>
                    </div>
                </div>
                
                <div class="suspended-reason">
                    <strong>Raison :</strong>
                    <p>{{ 
                        [
                            'Multiples violations de la charte',
                            'Tentative de fraude avérée',
                            'Harcèlement répété',
                            'Spam massif',
                            'Contenu illégal'
                        ][$i-1] 
                    }}</p>
                </div>
                
                <div class="suspended-actions">
                    <button class="btn btn-sm btn-success" data-action="restore">
                        <i class="fas fa-user-check"></i>
                        Restaurer
                    </button>
                    <button class="btn btn-sm btn-outline" data-action="details">
                        <i class="fas fa-file-alt"></i>
                        Détails
                    </button>
                    <button class="btn btn-sm btn-danger" data-action="permanent">
                        <i class="fas fa-trash"></i>
                        Supprimer
                    </button>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Panneau latéral pour les détails -->
    <div class="moderation-sidebar" id="detailsSidebar">
        <div class="sidebar-header">
            <h4>Détails du signalement</h4>
            <button class="close-sidebar">&times;</button>
        </div>
        <div class="sidebar-content" id="detailsContent">
            <!-- Contenu chargé dynamiquement -->
        </div>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

</div>
@endsection

@push('styles')
<style>
    /* ===== MODERATION SPECIFIC STYLES ===== */
    .moderation-container {
        width: 100% !important;
        padding: 20px;
    }

    /* Tabs de modération */
    .moderation-tabs {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .tabs-header {
        display: flex;
        border-bottom: 1px solid #e5e7eb;
    }

    .tab-btn {
        flex: 1;
        padding: 20px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        font-size: 16px;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s;
        position: relative;
    }

    .tab-btn:hover {
        background: #f9fafb;
        color: #4b5563;
    }

    .tab-btn.active {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
        background: linear-gradient(to bottom, rgba(59, 130, 246, 0.05), transparent);
    }

    .tab-badge {
        background: #ef4444;
        color: white;
        font-size: 12px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 10px;
        min-width: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .tab-btn.active .tab-badge {
        background: var(--primary-color);
    }

    /* Contenu des onglets */
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Grid des signalements */
    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 1200px) {
        .reports-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Carte de signalement */
    .report-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--shadow);
        border-left: 4px solid #e5e7eb;
        transition: all 0.3s;
    }

    .report-card[data-severity="critical"] {
        border-left-color: #dc2626;
        background: linear-gradient(to right, rgba(220, 38, 38, 0.02), white);
    }

    .report-card[data-severity="high"] {
        border-left-color: #f59e0b;
        background: linear-gradient(to right, rgba(245, 158, 11, 0.02), white);
    }

    .report-card[data-severity="medium"] {
        border-left-color: #3b82f6;
        background: linear-gradient(to right, rgba(59, 130, 246, 0.02), white);
    }

    .report-card[data-severity="low"] {
        border-left-color: #10b981;
        background: linear-gradient(to right, rgba(16, 185, 129, 0.02), white);
    }

    .report-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f3f4f6;
    }

    .report-meta {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .report-id {
        font-weight: 700;
        color: #1f2937;
        font-size: 14px;
    }

    .report-date {
        color: #9ca3af;
        font-size: 12px;
    }

    .severity-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .severity-critical {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .severity-high {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fcd34d;
    }

    .severity-medium {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #93c5fd;
    }

    .severity-low {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .report-title {
        margin: 0 0 15px 0;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1f2937;
    }

    .report-title i {
        color: #6b7280;
    }

    .report-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
        padding: 15px;
        background: #f9fafb;
        border-radius: 8px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .detail-item strong {
        font-size: 12px;
        color: #6b7280;
        font-weight: 600;
    }

    .detail-item span {
        color: #1f2937;
        font-weight: 500;
    }

    .report-type {
        padding: 3px 8px;
        background: #e0f2fe;
        color: #0369a1;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .report-description {
        margin: 15px 0;
        padding: 15px;
        background: #f8fafc;
        border-radius: 8px;
        border-left: 3px solid #e2e8f0;
    }

    .report-description p {
        margin: 0;
        color: #4b5563;
        line-height: 1.6;
    }

    .report-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .report-actions .btn {
        flex: 1;
        min-width: 120px;
    }

    /* Badges de type */
    .report-type-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .type-content {
        background: #e0f2fe;
        color: #0369a1;
    }

    .type-user {
        background: #fce7f3;
        color: #be185d;
    }

    .type-security {
        background: #fef3c7;
        color: #92400e;
    }

    /* Comptes suspendus */
    .suspended-accounts {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
    }

    .suspended-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 20px;
        box-shadow: var(--shadow);
        border: 1px solid #fee2e2;
    }

    .suspended-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f3f4f6;
    }

    .suspended-header .user-avatar {
        width: 50px;
        height: 50px;
        background: #fee2e2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dc2626;
        font-size: 20px;
    }

    .user-info {
        flex: 1;
    }

    .user-info h4 {
        margin: 0 0 5px 0;
        font-size: 16px;
        color: #1f2937;
    }

    .user-info p {
        margin: 0;
        color: #9ca3af;
        font-size: 12px;
    }

    .duration-badge {
        padding: 4px 10px;
        background: #dc2626;
        color: white;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .suspended-reason {
        margin-bottom: 15px;
        padding: 10px;
        background: #fef2f2;
        border-radius: 8px;
    }

    .suspended-reason strong {
        color: #991b1b;
        font-size: 14px;
    }

    .suspended-reason p {
        margin: 5px 0 0 0;
        color: #4b5563;
        font-size: 14px;
    }

    .suspended-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .suspended-actions .btn {
        flex: 1;
        min-width: 100px;
    }

    /* État vide */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }

    .empty-state i {
        margin-bottom: 20px;
        color: #d1d5db;
    }

    .empty-state h3 {
        color: #6b7280;
        margin-bottom: 10px;
    }

    /* Sidebar des détails */
    .moderation-sidebar {
        position: fixed;
        top: 0;
        right: -450px;
        width: 450px;
        height: 100vh;
        background: white;
        box-shadow: -5px 0 25px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        transition: right 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .moderation-sidebar.open {
        right: 0;
    }

    .sidebar-header {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sidebar-header h4 {
        margin: 0;
        color: #1f2937;
    }

    .close-sidebar {
        background: none;
        border: none;
        font-size: 24px;
        color: #6b7280;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.2s;
    }

    .close-sidebar:hover {
        background: #f3f4f6;
    }

    .sidebar-content {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
    }

    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }

    .sidebar-overlay.active {
        display: block;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .tabs-header {
            flex-direction: column;
        }
        
        .tab-btn {
            padding: 15px;
            justify-content: flex-start;
        }
        
        .reports-grid {
            grid-template-columns: 1fr;
        }
        
        .report-details {
            grid-template-columns: 1fr;
        }
        
        .report-actions {
            flex-direction: column;
        }
        
        .report-actions .btn {
            width: 100%;
        }
        
        .moderation-sidebar {
            width: 100%;
            right: -100%;
        }
        
        .suspended-accounts {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des onglets
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Désactiver tous les onglets
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Activer l'onglet cliqué
            this.classList.add('active');
            const tabId = this.dataset.tab;
            document.getElementById(`${tabId}-tab`).classList.add('active');
        });
    });
    
    // Actions sur les signalements
    document.querySelectorAll('.btn-validate-report').forEach(btn => {
        btn.addEventListener('click', function() {
            const reportId = this.dataset.id;
            if (confirm('Marquer ce signalement comme traité ?')) {
                const card = this.closest('.report-card');
                card.style.opacity = '0.5';
                card.style.pointerEvents = 'none';
                
                // Simulation AJAX
                setTimeout(() => {
                    card.remove();
                    updateStats();
                    showNotification('Signalement marqué comme traité', 'success');
                }, 500);
            }
        });
    });
    
    // Assigner un signalement
    document.querySelectorAll('.btn-assign').forEach(btn => {
        btn.addEventListener('click', function() {
            const reportId = this.dataset.id;
            const card = this.closest('.report-card');
            
            card.style.borderLeftColor = '#f59e0b';
            this.innerHTML = '<i class="fas fa-user-tie"></i> Assigné à moi';
            this.classList.remove('btn-warning');
            this.classList.add('btn-secondary');
            this.disabled = true;
            
            showNotification('Signalement assigné avec succès', 'info');
        });
    });
    
    // Voir les détails
    document.querySelectorAll('.btn-view-details').forEach(btn => {
        btn.addEventListener('click', function() {
            const reportId = this.dataset.id;
            openDetailsSidebar(reportId);
        });
    });
    
    // Rejeter un signalement
    document.querySelectorAll('.btn-reject').forEach(btn => {
        btn.addEventListener('click', function() {
            const reportId = this.dataset.id;
            if (confirm('Rejeter ce signalement ? Cette action est définitive.')) {
                const card = this.closest('.report-card');
                card.style.opacity = '0.5';
                card.style.pointerEvents = 'none';
                
                setTimeout(() => {
                    card.remove();
                    updateStats();
                    showNotification('Signalement rejeté', 'info');
                }, 500);
            }
        });
    });
    
    // Gestion de la sidebar
    const sidebar = document.getElementById('detailsSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const closeSidebarBtn = document.querySelector('.close-sidebar');
    
    function openDetailsSidebar(reportId) {
        // Simulation de données
        const details = `
            <div class="sidebar-section">
                <h5>Informations générales</h5>
                <div class="sidebar-info">
                    <div class="info-item">
                        <strong>ID :</strong>
                        <span>#REP-00${reportId}</span>
                    </div>
                    <div class="info-item">
                        <strong>Date :</strong>
                        <span>${new Date().toLocaleDateString()}</span>
                    </div>
                    <div class="info-item">
                        <strong>Statut :</strong>
                        <span class="status-badge pending">En attente</span>
                    </div>
                </div>
            </div>
            
            <div class="sidebar-section">
                <h5>Contenu du signalement</h5>
                <div class="sidebar-content-text">
                    <p>Ceci est un exemple de contenu détaillé pour le signalement #${reportId}. 
                    Vous pouvez voir ici toutes les informations concernant ce cas spécifique.</p>
                    <p>Prenez le temps d'examiner toutes les preuves avant de prendre une décision.</p>
                </div>
            </div>
            
            <div class="sidebar-section">
                <h5>Preuves attachées</h5>
                <div class="sidebar-attachments">
                    <div class="attachment-item">
                        <i class="fas fa-image"></i>
                        <span>screenshot_${reportId}.png</span>
                    </div>
                    <div class="attachment-item">
                        <i class="fas fa-file-alt"></i>
                        <span>details_${reportId}.txt</span>
                    </div>
                </div>
            </div>
            
            <div class="sidebar-section">
                <h5>Actions recommandées</h5>
                <div class="sidebar-actions">
                    <button class="btn btn-block btn-success">
                        <i class="fas fa-check"></i> Valider le signalement
                    </button>
                    <button class="btn btn-block btn-outline">
                        <i class="fas fa-comment"></i> Demander plus d'infos
                    </button>
                    <button class="btn btn-block btn-danger">
                        <i class="fas fa-times"></i> Rejeter
                    </button>
                </div>
            </div>
        `;
        
        document.getElementById('detailsContent').innerHTML = details;
        sidebar.classList.add('open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
    
    closeSidebarBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);
    
    // Mettre à jour les statistiques
    function updateStats() {
        const pendingBadge = document.querySelector('[data-tab="pending"] .tab-badge');
        const currentCount = parseInt(pendingBadge.textContent);
        if (currentCount > 0) {
            pendingBadge.textContent = currentCount - 1;
        }
    }
    
    // Fonction de notification
    function showNotification(message, type = 'info') {
        const flashContainer = document.querySelector('.flash-container') || document.body;
        const alert = document.createElement('div');
        alert.className = `alert-flash ${type} fade-in`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check' : 'info'}-circle"></i>
            <span>${message}</span>
            <button class="close-btn">&times;</button>
        `;
        
        if (!flashContainer.classList.contains('flash-container')) {
            flashContainer.style.position = 'fixed';
            flashContainer.style.top = '20px';
            flashContainer.style.right = '20px';
            flashContainer.style.zIndex = '9999';
        }
        
        flashContainer.appendChild(alert);
        
        // Auto-remove après 5s
        setTimeout(() => {
            alert.classList.add('fade-out');
            setTimeout(() => alert.remove(), 500);
        }, 5000);
        
        // Bouton de fermeture
        alert.querySelector('.close-btn').addEventListener('click', () => {
            alert.remove();
        });
    }
    
    // Initialiser DataTables pour les signalements résolus
    if ($.fn.DataTable && document.getElementById('resolvedTable')) {
        $('#resolvedTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
            },
            pageLength: 10,
            order: [[4, 'desc']]
        });
    }
});
</script>
@endpush