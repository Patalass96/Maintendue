
@extends('layouts.admin')

@section('title', 'Signalements')
@section('page-title', 'Gestion des Signalements')

@section('content')
<div class="reports-container">
    
    <!-- Statistiques des signalements -->
    <div class="stats-grid mb-30">
        <div class="stat-card">
            <div class="stat-icon bg-orange">
                <i class="fas fa-flag"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">24</h3>
                <p class="stat-label">Signalements en attente</p>
                <span class="stat-trend negative">+8 cette semaine</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-blue">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">12</h3>
                <p class="stat-label">En investigation</p>
                <span class="stat-trend">6 assignés à vous</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">156</h3>
                <p class="stat-label">Résolus ce mois</p>
                <span class="stat-trend positive">94% de résolution</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-red">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">3</h3>
                <p class="stat-label">Urgents</p>
                <span class="stat-trend negative">Attention requise</span>
            </div>
        </div>
    </div>

    <!-- Filtres rapides -->
    <div class="quick-filters mb-20">
        <div class="filters-row">
            <button class="filter-btn active" data-filter="all">
                <i class="fas fa-list"></i>
                Tous
                <span class="filter-badge">195</span>
            </button>
            
            <button class="filter-btn" data-filter="pending">
                <i class="fas fa-clock"></i>
                En attente
                <span class="filter-badge">24</span>
            </button>
            
            <button class="filter-btn" data-filter="assigned">
                <i class="fas fa-user-tie"></i>
                Assignés à moi
                <span class="filter-badge">6</span>
            </button>
            
            <button class="filter-btn" data-filter="urgent">
                <i class="fas fa-exclamation-circle"></i>
                Urgents
                <span class="filter-badge">3</span>
            </button>
            
            <button class="filter-btn" data-filter="resolved">
                <i class="fas fa-check"></i>
                Résolus
                <span class="filter-badge">156</span>
            </button>
        </div>
    </div>

    <!-- Barre d'outils -->
    <div class="tools-bar mb-20">
        <div class="tools-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="reportSearch" placeholder="Rechercher un signalement..." class="search-input">
            </div>
            
            <select class="filter-select" id="typeFilter">
                <option value="">Tous les types</option>
                <option value="content">Contenu inapproprié</option>
                <option value="user">Problème utilisateur</option>
                <option value="donation">Problème de don</option>
                <option value="fraud">Fraude suspectée</option>
                <option value="other">Autre</option>
            </select>
            
            <select class="filter-select" id="severityFilter">
                <option value="">Toutes sévérités</option>
                <option value="low">Faible</option>
                <option value="medium">Moyen</option>
                <option value="high">Élevé</option>
                <option value="critical">Critique</option>
            </select>
        </div>
        
        <div class="tools-right">
            <button class="btn btn-primary" id="assignToMe">
                <i class="fas fa-user-tie"></i>
                S'assigner la sélection
            </button>
            
            <button class="btn btn-success" id="markResolved">
                <i class="fas fa-check"></i>
                Marquer comme résolu
            </button>
            
            <div class="dropdown">
                <button class="btn btn-secondary">
                    <i class="fas fa-ellipsis-v"></i>
                    Plus
                </button>
                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item" id="exportReports">
                        <i class="fas fa-file-export"></i>
                        Exporter
                    </a>
                    <a href="#" class="dropdown-item" id="bulkDelete">
                        <i class="fas fa-trash"></i>
                        Supprimer la sélection
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" id="viewStats">
                        <i class="fas fa-chart-bar"></i>
                        Voir les statistiques
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des signalements -->
    <div class="reports-table-container">
        <table class="admin-table" id="reportsTable">
            <thead>
                <tr>
                    <th width="50">
                        <input type="checkbox" id="selectAllReports">
                    </th>
                    <th>ID & OBJET</th>
                    <th>TYPE</th>
                    <th>GRAVITÉ</th>
                    <th>SIGNALÉ PAR</th>
                    <th>DATE</th>
                    <th>STATUT</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= 12; $i++)
                @php
                    $types = ['content', 'user', 'donation', 'fraud', 'other'];
                    $type = $types[array_rand($types)];
                    
                    $severities = ['low', 'medium', 'high', 'critical'];
                    $severity = $severities[array_rand($severities)];
                    
                    $statuses = ['pending', 'assigned', 'investigating', 'resolved', 'rejected'];
                    $status = $statuses[array_rand($statuses)];
                    
                    $subjects = [
                        'Commentaire offensant',
                        'Profil suspect',
                        'Don non reçu',
                        'Demande frauduleuse',
                        'Spam répétitif',
                        'Contenu violent',
                        'Harcèlement',
                        'Fausse association'
                    ];
                    $subject = $subjects[array_rand($subjects)];
                    
                    $reporters = ['Utilisateur #452', 'Donateur #189', 'Association #67', 'Visiteur #23'];
                    $reporter = $reporters[array_rand($reporters)];
                    
                    $daysAgo = rand(1, 30);
                @endphp
                <tr class="report-row" 
                    data-id="{{ $i }}" 
                    data-type="{{ $type }}"
                    data-severity="{{ $severity }}"
                    data-status="{{ $status }}"
                    data-assigned="{{ $i % 3 == 0 ? 'true' : 'false' }}">
                    <td>
                        <input type="checkbox" class="report-checkbox" value="{{ $i }}">
                    </td>
                    <td>
                        <div class="report-subject">
                            <div class="report-id">#REP-{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}</div>
                            <strong>{{ $subject }}</strong>
                            <div class="report-preview">
                                {{ substr("Signalement concernant un problème nécessitant investigation. Détails supplémentaires disponibles...", 0, 60) }}...
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="type-badge type-{{ $type }}">
                            @if($type === 'content')
                            <i class="fas fa-comment"></i> Contenu
                            @elseif($type === 'user')
                            <i class="fas fa-user"></i> Utilisateur
                            @elseif($type === 'donation')
                            <i class="fas fa-donate"></i> Donation
                            @elseif($type === 'fraud')
                            <i class="fas fa-shield-alt"></i> Fraude
                            @else
                            <i class="fas fa-question"></i> Autre
                            @endif
                        </span>
                    </td>
                    <td>
                        <span class="severity-badge severity-{{ $severity }}">
                            @if($severity === 'critical')
                            <i class="fas fa-skull-crossbones"></i> Critique
                            @elseif($severity === 'high')
                            <i class="fas fa-exclamation-triangle"></i> Élevé
                            @elseif($severity === 'medium')
                            <i class="fas fa-exclamation"></i> Moyen
                            @else
                            <i class="fas fa-info-circle"></i> Faible
                            @endif
                        </span>
                    </td>
                    <td>
                        <div class="reporter-info">
                            <div class="reporter-avatar">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div>
                                <strong>{{ $reporter }}</strong>
                                <small>Signalé il y a {{ $daysAgo }} jour(s)</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="date-info">
                            <div>2024-12-{{ str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) }}</div>
                            <small>{{ rand(1, 23) }}:{{ str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT) }}</small>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge status-{{ $status }}">
                            @if($status === 'pending')
                            <i class="fas fa-clock"></i> En attente
                            @elseif($status === 'assigned')
                            <i class="fas fa-user-tie"></i> Assigné
                            @elseif($status === 'investigating')
                            <i class="fas fa-search"></i> En cours
                            @elseif($status === 'resolved')
                            <i class="fas fa-check"></i> Résolu
                            @else
                            <i class="fas fa-times"></i> Rejeté
                            @endif
                        </span>
                        
                        @if($i % 3 == 0)
                        <div class="assignee">
                            <small><i class="fas fa-user-tie"></i> Assigné à vous</small>
                        </div>
                        @endif
                    </td>
                    <td>
                        <div class="report-actions">
                            <button class="btn-icon btn-view" title="Voir détails" data-action="view" data-id="{{ $i }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            
                            @if($status === 'pending')
                            <button class="btn-icon btn-primary" title="S'assigner" data-action="assign" data-id="{{ $i }}">
                                <i class="fas fa-user-tie"></i>
                            </button>
                            @endif
                            
                            @if($status !== 'resolved' && $status !== 'rejected')
                            <button class="btn-icon btn-success" title="Marquer résolu" data-action="resolve" data-id="{{ $i }}">
                                <i class="fas fa-check"></i>
                            </button>
                            @endif
                            
                            <div class="dropdown">
                                <button class="btn-icon" title="Plus d'actions">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item" data-action="contact-reporter" data-id="{{ $i }}">
                                        <i class="fas fa-envelope"></i>
                                        Contacter le signaleur
                                    </a>
                                    <a href="#" class="dropdown-item" data-action="escalate" data-id="{{ $i }}">
                                        <i class="fas fa-level-up-alt"></i>
                                        Escalader
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item text-danger" data-action="reject" data-id="{{ $i }}">
                                        <i class="fas fa-times"></i>
                                        Rejeter le signalement
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="table-footer">
            <div class="table-info">
                Affichage de 1 à 12 sur 195 signalements
            </div>
            <div class="pagination">
                <button class="pagination-btn disabled">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <span class="pagination-dots">...</span>
                <button class="pagination-btn">16</button>
                <button class="pagination-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Section des signalements urgents -->
    <div class="urgent-section mt-40">
        <div class="section-header">
            <h3><i class="fas fa-exclamation-triangle text-red"></i> Signalements urgents nécessitant attention</h3>
        </div>
        
        <div class="urgent-reports">
            @for($j = 1; $j <= 3; $j++)
            <div class="urgent-card">
                <div class="urgent-header">
                    <div class="urgent-indicator">
                        <i class="fas fa-skull-crossbones"></i>
                    </div>
                    <div class="urgent-info">
                        <h4>Signalement critique #{{ $j }}</h4>
                        <div class="urgent-meta">
                            <span class="urgent-type">Fraude suspectée</span>
                            <span class="urgent-time">Il y a {{ $j }} heure(s)</span>
                        </div>
                    </div>
                    <button class="btn btn-danger btn-sm take-action-btn" data-id="urgent-{{ $j }}">
                        <i class="fas fa-play"></i>
                        Prendre en charge
                    </button>
                </div>
                
                <div class="urgent-body">
                    <p>Signalement de fraude financière présumée nécessitant une investigation immédiate. Des fonds importants pourraient être en jeu.</p>
                    
                    <div class="urgent-details">
                        <div class="detail">
                            <strong>Montant concerné :</strong>
                            <span>{{ $j * 5000 }} CFA</span>
                        </div>
                        <div class="detail">
                            <strong>Utilisateur concerné :</strong>
                            <span>Association #{{ $j * 10 }}</span>
                        </div>
                        <div class="detail">
                            <strong>Dernière action :</strong>
                            <span>Aucune</span>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Statistiques détaillées -->
    <div class="stats-detail mt-40">
        <div class="section-header">
            <h3><i class="fas fa-chart-bar"></i> Statistiques des signalements</h3>
        </div>
        
        <div class="stats-cards">
            <div class="stats-detail-card">
                <h4>Par type</h4>
                <div class="stats-chart">
                    <canvas id="typesChart"></canvas>
                </div>
            </div>
            
            <div class="stats-detail-card">
                <h4>Par gravité</h4>
                <div class="stats-bars">
                    <div class="bar-item">
                        <span>Critique</span>
                        <div class="bar-container">
                            <div class="bar-fill critical" style="width: 8%"></div>
                        </div>
                        <span>8%</span>
                    </div>
                    <div class="bar-item">
                        <span>Élevé</span>
                        <div class="bar-container">
                            <div class="bar-fill high" style="width: 22%"></div>
                        </div>
                        <span>22%</span>
                    </div>
                    <div class="bar-item">
                        <span>Moyen</span>
                        <div class="bar-container">
                            <div class="bar-fill medium" style="width: 45%"></div>
                        </div>
                        <span>45%</span>
                    </div>
                    <div class="bar-item">
                        <span>Faible</span>
                        <div class="bar-container">
                            <div class="bar-fill low" style="width: 25%"></div>
                        </div>
                        <span>25%</span>
                    </div>
                </div>
            </div>
            
            <div class="stats-detail-card">
                <h4>Temps de résolution moyen</h4>
                <div class="resolution-time">
                    <div class="time-metric">
                        <span class="time-value">24h</span>
                        <span class="time-label">Tous signalements</span>
                    </div>
                    <div class="time-metric">
                        <span class="time-value">48h</span>
                        <span class="time-label">Signalements urgents</span>
                    </div>
                    <div class="time-metric">
                        <span class="time-value">12h</span>
                        <span class="time-label">Vos assignations</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal de détails du signalement -->
<div class="modal" id="reportModal">
    <div class="modal-content large">
        <div class="modal-header">
            <h3 id="modalReportTitle">Détails du signalement</h3>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body" id="reportDetails">
            <!-- Contenu chargé dynamiquement -->
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ===== REPORTS MANAGEMENT STYLES ===== */
    .reports-container {
        padding: 20px;
    }

    /* Filtres rapides */
    .quick-filters {
        background: white;
        border-radius: var(--border-radius);
        padding: 15px;
        box-shadow: var(--shadow);
    }

    .filters-row {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    .filter-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius-sm);
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s;
    }

    .filter-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .filter-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .filter-btn.active .filter-badge {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .filter-badge {
        background: #e2e8f0;
        color: #475569;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        min-width: 24px;
        text-align: center;
    }

    /* Barre d'outils */
    .tools-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        padding: 20px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .tools-left {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
        min-width: 300px;
    }

    .tools-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Table des signalements */
    .reports-table-container {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .report-subject {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .report-id {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 600;
    }

    .report-subject strong {
        font-size: 15px;
        color: #1e293b;
    }

    .report-preview {
        font-size: 13px;
        color: #64748b;
        line-height: 1.4;
    }

    /* Badges de type */
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .type-content {
        background: #e0f2fe;
        color: #0369a1;
    }

    .type-user {
        background: #fce7f3;
        color: #9d174d;
    }

    .type-donation {
        background: #dcfce7;
        color: #166534;
    }

    .type-fraud {
        background: #fee2e2;
        color: #991b1b;
    }

    .type-other {
        background: #f3f4f6;
        color: #4b5563;
    }

    /* Badges de gravité */
    .severity-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .severity-critical {
        background: #450a0a;
        color: #fca5a5;
        border: 1px solid #7f1d1d;
    }

    .severity-high {
        background: #7c2d12;
        color: #fdba74;
        border: 1px solid #9a3412;
    }

    .severity-medium {
        background: #78350f;
        color: #fcd34d;
        border: 1px solid #92400e;
    }

    .severity-low {
        background: #064e3b;
        color: #6ee7b7;
        border: 1px solid #047857;
    }

    /* Informations du signaleur */
    .reporter-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .reporter-avatar {
        width: 36px;
        height: 36px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
    }

    .reporter-info strong {
        font-size: 14px;
        color: #1e293b;
        display: block;
    }

    .reporter-info small {
        font-size: 12px;
        color: #94a3b8;
    }

    /* Badges de statut */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-assigned {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-investigating {
        background: #ede9fe;
        color: #5b21b6;
    }

    .status-resolved {
        background: #d1fae5;
        color: #065f46;
    }

    .status-rejected {
        background: #f3f4f6;
        color: #6b7280;
    }

    .assignee {
        font-size: 11px;
        color: #3b82f6;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Actions des signalements */
    .report-actions {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .report-actions .dropdown {
        position: relative;
    }

    .report-actions .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        min-width: 200px;
        padding: 8px 0;
        display: none;
        z-index: 100;
    }

    .report-actions .dropdown:hover .dropdown-menu {
        display: block;
    }

    /* Section urgente */
    .urgent-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--shadow);
        border-left: 5px solid #dc2626;
    }

    .urgent-reports {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
    }

    .urgent-card {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: var(--border-radius);
        padding: 20px;
        transition: all 0.3s;
    }

    .urgent-card:hover {
        background: #fee2e2;
        transform: translateX(5px);
    }

    .urgent-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .urgent-indicator {
        width: 40px;
        height: 40px;
        background: #dc2626;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }

    .urgent-info {
        flex: 1;
    }

    .urgent-info h4 {
        margin: 0 0 5px 0;
        color: #991b1b;
        font-size: 18px;
    }

    .urgent-meta {
        display: flex;
        gap: 15px;
        font-size: 14px;
    }

    .urgent-type {
        background: #dc2626;
        color: white;
        padding: 3px 10px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 12px;
    }

    .urgent-time {
        color: #ef4444;
        font-weight: 600;
    }

    .urgent-body p {
        margin: 0 0 15px 0;
        color: #4b5563;
        line-height: 1.5;
    }

    .urgent-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        background: white;
        padding: 15px;
        border-radius: var(--border-radius-sm);
    }

    .urgent-details .detail {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .urgent-details strong {
        font-size: 12px;
        color: #6b7280;
    }

    .urgent-details span {
        font-weight: 600;
        color: #1f2937;
    }

    /* Statistiques détaillées */
    .stats-detail {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--shadow);
    }

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }

    .stats-detail-card {
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
    }

    .stats-detail-card h4 {
        margin: 0 0 20px 0;
        color: #4b5563;
        font-size: 16px;
    }

    .stats-chart {
        height: 200px;
        position: relative;
    }

    .stats-bars {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .bar-item {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .bar-item span:first-child {
        width: 70px;
        font-size: 14px;
        color: #6b7280;
    }

    .bar-container {
        flex: 1;
        height: 10px;
        background: #e5e7eb;
        border-radius: 5px;
        overflow: hidden;
    }

    .bar-fill.critical { background: #dc2626; }
    .bar-fill.high { background: #f59e0b; }
    .bar-fill.medium { background: #3b82f6; }
    .bar-fill.low { background: #10b981; }

    .bar-item span:last-child {
        width: 40px;
        text-align: right;
        font-weight: 600;
        color: #1f2937;
        font-size: 14px;
    }

    .resolution-time {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding: 10px;
    }

    .time-metric {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px;
        background: #f8fafc;
        border-radius: var(--border-radius);
    }

    .time-value {
        font-size: 32px;
        font-weight: 800;
        color: var(--primary-color);
        line-height: 1;
    }

    .time-label {
        font-size: 14px;
        color: #6b7280;
        text-align: center;
        margin-top: 8px;
    }

    /* Modal large */
    .modal-content.large {
        max-width: 800px;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .tools-bar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .tools-left, .tools-right {
            width: 100%;
        }
        
        .tools-right {
            justify-content: center;
        }
        
        .stats-cards {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .filters-row {
            flex-wrap: wrap;
        }
        
        .filter-btn {
            flex: 1;
            min-width: 120px;
            justify-content: center;
        }
        
        .tools-left {
            flex-direction: column;
            min-width: auto;
        }
        
        .urgent-header {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }
        
        .urgent-details {
            grid-template-columns: 1fr;
        }
        
        .report-actions {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .report-actions .btn-icon {
            width: 100%;
            justify-content: flex-start;
            padding: 10px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser DataTable
    if ($.fn.DataTable) {
        const table = $('#reportsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
            },
            pageLength: 12,
            order: [[5, 'desc']], // Trier par date
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [0, 7] }
            ]
        });
        
        // Recherche personnalisée
        $('#reportSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
        
        // Filtres
        $('#typeFilter, #severityFilter').on('change', function() {
            const columnIndex = $(this).attr('id') === 'typeFilter' ? 2 : 3;
            const value = this.value;
            
            if (value) {
                table.column(columnIndex).search(value).draw();
            } else {
                table.column(columnIndex).search('').draw();
            }
        });
    }
    
    // Filtres rapides
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            filterReports(filter);
        });
    });
    
    function filterReports(filter) {
        const rows = document.querySelectorAll('.report-row');
        
        rows.forEach(row => {
            switch(filter) {
                case 'all':
                    row.style.display = '';
                    break;
                    
                case 'pending':
                    row.style.display = row.dataset.status === 'pending' ? '' : 'none';
                    break;
                    
                case 'assigned':
                    row.style.display = row.dataset.assigned === 'true' ? '' : 'none';
                    break;
                    
                case 'urgent':
                    row.style.display = row.dataset.severity === 'critical' ? '' : 'none';
                    break;
                    
                case 'resolved':
                    row.style.display = row.dataset.status === 'resolved' ? '' : 'none';
                    break;
            }
        });
    }
    
    // Sélection multiple
    const selectAll = document.getElementById('selectAllReports');
    const reportCheckboxes = document.querySelectorAll('.report-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const isChecked = this.checked;
            reportCheckboxes.forEach(cb => {
                cb.checked = isChecked;
            });
        });
    }
    
    // Actions sur les signalements
    document.querySelectorAll('[data-action]').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.dataset.action;
            const reportId = this.dataset.id;
            const row = this.closest('.report-row');
            
            switch(action) {
                case 'view':
                    showReportDetails(reportId);
                    break;
                    
                case 'assign':
                    if (confirm("S'assigner ce signalement ?")) {
                        const statusBadge = row.querySelector('.status-badge');
                        statusBadge.className = 'status-badge status-assigned';
                        statusBadge.innerHTML = '<i class="fas fa-user-tie"></i> Assigné';
                        
                        // Ajouter la mention "Assigné à vous"
                        const assigneeDiv = document.createElement('div');
                        assigneeDiv.className = 'assignee';
                        assigneeDiv.innerHTML = '<small><i class="fas fa-user-tie"></i> Assigné à vous</small>';
                        statusBadge.parentNode.appendChild(assigneeDiv);
                        
                        row.dataset.assigned = 'true';
                        row.dataset.status = 'assigned';
                        
                        showNotification('Signalement assigné avec succès', 'success');
                    }
                    break;
                    
                case 'resolve':
                    if (confirm("Marquer ce signalement comme résolu ?")) {
                        const statusBadge = row.querySelector('.status-badge');
                        statusBadge.className = 'status-badge status-resolved';
                        statusBadge.innerHTML = '<i class="fas fa-check"></i> Résolu';
                        
                        // Supprimer la mention d'assignation
                        const assignee = row.querySelector('.assignee');
                        if (assignee) assignee.remove();
                        
                        row.dataset.status = 'resolved';
                        
                        showNotification('Signalement marqué comme résolu', 'success');
                    }
                    break;
                    
                case 'contact-reporter':
                    showNotification('Fonctionnalité de contact en développement', 'info');
                    break;
                    
                case 'escalate':
                    if (confirm("Escalader ce signalement vers un supérieur ?")) {
                        showNotification('Signalement escaladé', 'warning');
                    }
                    break;
                    
                case 'reject':
                    if (confirm("Rejeter ce signalement ? Cette action est définitive.")) {
                        const statusBadge = row.querySelector('.status-badge');
                        statusBadge.className = 'status-badge status-rejected';
                        statusBadge.innerHTML = '<i class="fas fa-times"></i> Rejeté';
                        showNotification('Signalement rejeté', 'info');
                    }
                    break;
            }
        });
    });
    
    // Prendre en charge les urgents
    document.querySelectorAll('.take-action-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const urgentId = this.dataset.id;
            if (confirm("Prendre en charge ce signalement urgent ?")) {
                this.innerHTML = '<i class="fas fa-check"></i> Pris en charge';
                this.classList.remove('btn-danger');
                this.classList.add('btn-success');
                this.disabled = true;
                showNotification('Signalement urgent pris en charge', 'success');
            }
        });
    });
    
    // Actions groupées
    document.getElementById('assignToMe')?.addEventListener('click', function() {
        const selected = document.querySelectorAll('.report-checkbox:checked');
        if (selected.length === 0) {
            showNotification('Veuillez sélectionner au moins un signalement', 'warning');
            return;
        }
        
        if (confirm(`S'assigner ${selected.length} signalement(s) ?`)) {
            selected.forEach(cb => {
                const row = cb.closest('.report-row');
                const statusBadge = row.querySelector('.status-badge');
                if (statusBadge && row.dataset.status === 'pending') {
                    statusBadge.className = 'status-badge status-assigned';
                    statusBadge.innerHTML = '<i class="fas fa-user-tie"></i> Assigné';
                    row.dataset.status = 'assigned';
                    row.dataset.assigned = 'true';
                }
            });
            showNotification(`${selected.length} signalement(s) assigné(s)`, 'success');
        }
    });
    
    document.getElementById('markResolved')?.addEventListener('click', function() {
        const selected = document.querySelectorAll('.report-checkbox:checked');
        if (selected.length === 0) {
            showNotification('Veuillez sélectionner au moins un signalement', 'warning');
            return;
        }
        
        if (confirm(`Marquer ${selected.length} signalement(s) comme résolu(s) ?`)) {
            selected.forEach(cb => {
                const row = cb.closest('.report-row');
                const statusBadge = row.querySelector('.status-badge');
                if (statusBadge && row.dataset.status !== 'resolved') {
                    statusBadge.className = 'status-badge status-resolved';
                    statusBadge.innerHTML = '<i class="fas fa-check"></i> Résolu';
                    row.dataset.status = 'resolved';
                }
            });
            showNotification(`${selected.length} signalement(s) marqué(s) comme résolu(s)`, 'success');
        }
    });
    
    // Graphique des types
    if (typeof Chart !== 'undefined') {
        const typesCtx = document.getElementById('typesChart');
        if (typesCtx) {
            new Chart(typesCtx, {
                type: 'pie',
                data: {
                    labels: ['Contenu', 'Utilisateur', 'Donation', 'Fraude', 'Autre'],
                    datasets: [{
                        data: [35, 25, 20, 15, 5],
                        backgroundColor: [
                            '#0369a1', // Contenu - bleu
                            '#9d174d', // Utilisateur - rose
                            '#166534', // Donation - vert
                            '#991b1b', // Fraude - rouge
                            '#4b5563'  // Autre - gris
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 15,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }
    }
    
    // Fonction pour afficher les détails
    function showReportDetails(reportId) {
        const modal = document.getElementById('reportModal');
        const title = document.getElementById('modalReportTitle');
        const content = document.getElementById('reportDetails');
        
        title.textContent = `Signalement #REP-${reportId.padStart(3, '0')}`;
        
        // Simulation de contenu détaillé
        content.innerHTML = `
            <div class="report-detail-view">
                <div class="detail-header">
                    <div class="detail-info">
                        <h4>Contenu inapproprié dans les commentaires</h4>
                        <div class="detail-meta">
                            <span class="badge badge-danger">Urgent</span>
                            <span class="badge badge-warning">En attente</span>
                            <span>Signalé il y a 2 heures</span>
                        </div>
                    </div>
                </div>
                
                <div class="detail-sections">
                    <div class="section">
                        <h5><i class="fas fa-info-circle"></i> Description</h5>
                        <p>Un utilisateur a posté des commentaires offensants et inappropriés sur la page d'une association. Les propos sont contraires à notre charte de bonne conduite.</p>
                    </div>
                    
                    <div class="section">
                        <h5><i class="fas fa-user"></i> Signaleur</h5>
                        <div class="user-card">
                            <div class="user-avatar">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="user-info">
                                <strong>Utilisateur #452</strong>
                                <small>Membre depuis 6 mois</small>
                                <small>15 signalements précédents (tous résolus)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section">
                        <h5><i class="fas fa-target"></i> Cible</h5>
                        <div class="target-card">
                            <div class="target-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="target-info">
                                <strong>Utilisateur #789</strong>
                                <small>Compte créé il y a 2 semaines</small>
                                <small>Aucun signalement précédent</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section">
                        <h5><i class="fas fa-comment"></i> Contenu signalé</h5>
                        <div class="content-box">
                            <p>"Ce commentaire contient des propos inacceptables qui ne respectent pas les règles de notre communauté."</p>
                            <small class="text-muted">Commentaire original masqué pour des raisons de modération</small>
                        </div>
                    </div>
                    
                    <div class="section">
                        <h5><i class="fas fa-history"></i> Historique des actions</h5>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <strong>Signalement créé</strong>
                                    <small>Il y a 2 heures par Utilisateur #452</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="detail-actions">
                    <button class="btn btn-success">
                        <i class="fas fa-check"></i> Marquer comme résolu
                    </button>
                    <button class="btn btn-warning">
                        <i class="fas fa-user-tie"></i> S'assigner
                    </button>
                    <button class="btn btn-danger">
                        <i class="fas fa-times"></i> Rejeter
                    </button>
                    <button class="btn btn-outline">
                        <i class="fas fa-envelope"></i> Contacter le signaleur
                    </button>
                </div>
            </div>
        `;
        
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Fermer le modal
        modal.querySelector('.close-modal').addEventListener('click', function() {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
        
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    }
    
    // Fonction de notification
    function showNotification(message, type = 'info') {
        const flashContainer = document.querySelector('.flash-container') || document.body;
        const alert = document.createElement('div');
        alert.className = `alert-flash ${type} fade-in`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check' : type === 'warning' ? 'exclamation-triangle' : 'info'}-circle"></i>
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
});
</script>
@endpush