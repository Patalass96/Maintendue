
@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')
@section('page-title', 'Gestion des Utilisateurs')

@section('content')
<div class="users-container">
    
    <!-- Statistiques des utilisateurs -->
    <div class="stats-grid mb-30">
        <div class="stat-card">
            <div class="stat-icon bg-blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">2,450</h3>
                <p class="stat-label">Utilisateurs Totaux</p>
                <span class="stat-trend positive">+19% ce mois</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-green">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">2,150</h3>
                <p class="stat-label">Utilisateurs Actifs</p>
                <span class="stat-trend positive">89% d'activité</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-orange">
                <i class="fas fa-handshake"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">120</h3>
                <p class="stat-label">Associations</p>
                <span class="stat-trend positive">+5 nouvelles</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-purple">
                <i class="fas fa-donate"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">850</h3>
                <p class="stat-label">Donateurs Actifs</p>
                <span class="stat-trend positive">42 dons/jour</span>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="admin-filters mb-20">
        <div class="filter-row">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="userSearch" placeholder="Rechercher par nom, email, téléphone..." class="search-input">
            </div>
            
            <div class="filter-group">
                <select class="filter-select" id="roleFilter">
                    <option value="">Tous les rôles</option>
                    <option value="admin">Administrateur</option>
                    <option value="association">Association</option>
                    <option value="donor">Donateur</option>
                </select>
                
                <select class="filter-select" id="statusFilter">
                    <option value="">Tous les statuts</option>
                    <option value="active">Actif</option>
                    <option value="inactive">Inactif</option>
                    <option value="suspended">Suspendu</option>
                    <option value="pending">En attente</option>
                </select>
                
                <button class="btn btn-secondary" id="applyFilters">
                    <i class="fas fa-filter"></i>
                    Appliquer
                </button>
                
                <button class="btn btn-outline" id="resetFilters">
                    <i class="fas fa-redo"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="quick-actions mb-20">
        <button class="btn btn-success" id="addUserBtn">
            <i class="fas fa-user-plus"></i>
            Ajouter un utilisateur
        </button>
        
        <button class="btn btn-outline" id="exportUsers">
            <i class="fas fa-file-export"></i>
            Exporter en CSV
        </button>
        
        <button class="btn btn-outline" id="sendBulkEmail">
            <i class="fas fa-envelope"></i>
            Envoyer un email groupé
        </button>
    </div>

    <!-- Tableau des utilisateurs -->
    <div class="admin-table-container">
        <table class="admin-table" id="usersTable">
            <thead>
                <tr>
                    <th>UTILISATEUR</th>
                    <th>RÔLE</th>
                    <th>STATUT</th>
                    <th>INSCRIPTION</th>
                    <th>DERNIÈRE CONNEXION</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= 15; $i++)
                @php
                    // Seulement tes 3 rôles
                    $roles = ['admin', 'association', 'donor'];
                    $role = $roles[array_rand($roles)];
                    
                    $statuses = ['active', 'inactive', 'suspended', 'pending'];
                    $status = $statuses[array_rand($statuses)];
                    
                    // Noms selon le rôle
                    if ($role === 'association') {
                        $names = ['Des Mains Tendues', 'Solidarité Togo', 'Espoir pour Tous', 'Coeur de Lion', 'Main dans la Main'];
                        $email = 'contact@' . strtolower(str_replace(' ', '', $names[array_rand($names)])) . '.tg';
                    } else if ($role === 'admin') {
                        $names = ['Admin System', 'Modérateur Principal', 'Super Admin'];
                        $email = 'admin' . $i . '@maintendue.tg';
                    } else {
                        $names = ['Jean Dupont', 'Marie Martin', 'Paul Bernard', 'Sophie Petit', 'Luc Dubois'];
                        $email = 'user' . $i . '@example.com';
                    }
                    
                    $name = $names[array_rand($names)];
                    $cities = ['Lomé', 'Kara', 'Sokodé', 'Atakpamé', 'Dapaong'];
                    $city = $cities[array_rand($cities)];
                @endphp
                <tr data-user-id="{{ $i }}" data-status="{{ $status }}" data-role="{{ $role }}">
                    <td>
                        <div class="user-info">
                            <div class="user-avatar role-{{ $role }}">
                                @if($role === 'association')
                                <i class="fas fa-hands-helping"></i>
                                @elseif($role === 'admin')
                                <i class="fas fa-user-shield"></i>
                                @else
                                <i class="fas fa-user"></i>
                                @endif
                            </div>
                            <div class="user-details">
                                <strong>{{ $name }}</strong>
                                <small>{{ $email }}</small>
                                <div class="user-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> {{ $city }}</span>
                                    @if($role !== 'association')
                                    <span><i class="fas fa-phone"></i> +228 XX XX XX XX</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge role-{{ $role }}">
                            @if($role === 'admin')
                            <i class="fas fa-user-shield"></i> Administrateur
                            @elseif($role === 'association')
                            <i class="fas fa-hands-helping"></i> Association
                            @else
                            <i class="fas fa-user"></i> Donateur
                            @endif
                        </span>
                    </td>
                    <td>
                        <span class="status-badge status-{{ $status }}">
                            {{ ucfirst($status) }}
                        </span>
                        @if($status === 'active')
                        <div class="online-indicator" title="En ligne">
                            <i class="fas fa-circle"></i>
                        </div>
                        @endif
                    </td>
                    <td>
                        <div class="date-info">
                            <div>2024-12-{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</div>
                            <small>Il y a {{ $i * 2 }} jours</small>
                        </div>
                    </td>
                    <td>
                        <div class="date-info">
                            <div>À l'instant</div>
                            <small>Connecté</small>
                        </div>
                    </td>
                    <td>
                        <div class="table-actions">
                            <button class="btn-icon btn-view" title="Voir le profil" data-action="view" data-id="{{ $i }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            
                            <button class="btn-icon btn-warning" title="Modifier" data-action="edit" data-id="{{ $i }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            @if($status !== 'suspended' && $role !== 'admin')
                            <button class="btn-icon btn-danger" title="Suspendre" data-action="suspend" data-id="{{ $i }}">
                                <i class="fas fa-ban"></i>
                            </button>
                            @elseif($status === 'suspended')
                            <button class="btn-icon btn-success" title="Activer" data-action="activate" data-id="{{ $i }}">
                                <i class="fas fa-check"></i>
                            </button>
                            @endif
                            
                            @if($role !== 'admin')
                            <button class="btn-icon btn-primary" title="Promouvoir admin" data-action="promote" data-id="{{ $i }}">
                                <i class="fas fa-star"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="table-footer">
            <div class="table-info">
                Affichage de 1 à 15 sur 2,450 utilisateurs
            </div>
            <div class="pagination">
                <button class="pagination-btn disabled">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <span class="pagination-dots">...</span>
                <button class="pagination-btn">163</button>
                <button class="pagination-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Graphiques d'analyse -->
    <div class="analytics-section mt-40">
        <div class="section-header">
            <h3><i class="fas fa-chart-pie"></i> Répartition par rôle</h3>
        </div>
        
        <div class="analytics-grid">
            <div class="analytics-card">
                <div class="chart-container-sm">
                    <canvas id="rolesChart"></canvas>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <span class="legend-color" style="background: #3b82f6"></span>
                        <span>Donateurs (75%)</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background: #10b981"></span>
                        <span>Associations (20%)</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background: #f59e0b"></span>
                        <span>Administrateurs (5%)</span>
                    </div>
                </div>
            </div>
            
            <div class="analytics-card">
                <h4>Inscriptions récentes</h4>
                <div class="timeline">
                    @for($j = 1; $j <= 5; $j++)
                    <div class="timeline-item">
                        <div class="timeline-dot role-{{ ['donor', 'association', 'admin'][$j % 3] }}"></div>
                        <div class="timeline-content">
                            <strong>Nouvel utilisateur #{{ $j }}</strong>
                            <p>{{ ['Donateur', 'Association', 'Administrateur'][$j % 3] }} inscrit</p>
                            <small>Il y a {{ $j }} heures</small>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
            
            <div class="analytics-card">
                <h4>Activité par région</h4>
                <div class="regions-list">
                    <div class="region-item">
                        <span>Lomé</span>
                        <div class="region-bar">
                            <div class="bar-fill" style="width: 65%"></div>
                        </div>
                        <span class="region-percent">65%</span>
                    </div>
                    <div class="region-item">
                        <span>Kara</span>
                        <div class="region-bar">
                            <div class="bar-fill" style="width: 15%"></div>
                        </div>
                        <span class="region-percent">15%</span>
                    </div>
                    <div class="region-item">
                        <span>Sokodé</span>
                        <div class="region-bar">
                            <div class="bar-fill" style="width: 10%"></div>
                        </div>
                        <span class="region-percent">10%</span>
                    </div>
                    <div class="region-item">
                        <span>Autres</span>
                        <div class="region-bar">
                            <div class="bar-fill" style="width: 10%"></div>
                        </div>
                        <span class="region-percent">10%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal d'ajout d'utilisateur -->
<div class="modal" id="userModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Ajouter un utilisateur</h3>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="userForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="firstName">Prénom *</label>
                        <input type="text" id="firstName" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="lastName">Nom *</label>
                        <input type="text" id="lastName" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone" class="form-control" placeholder="+228">
                    </div>
                    
                    <div class="form-group">
                        <label for="role">Rôle *</label>
                        <select id="role" class="form-control" required>
                            <option value="donor">Donateur</option>
                            <option value="association">Association</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Statut *</label>
                        <select id="status" class="form-control" required>
                            <option value="active">Actif</option>
                            <option value="pending">En attente</option>
                            <option value="inactive">Inactif</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="notes">Notes (optionnel)</label>
                    <textarea id="notes" class="form-control" rows="3" placeholder="Informations supplémentaires..."></textarea>
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="sendWelcomeEmail" checked>
                        <label for="sendWelcomeEmail">Envoyer un email de bienvenue</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline close-modal">Annuler</button>
            <button class="btn btn-primary" id="saveUser">Créer l'utilisateur</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ===== USERS MANAGEMENT STYLES ===== */
    .users-container {
        padding: 20px;
    }

    /* Quick Actions */
    .quick-actions {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    /* Avatar par rôle */
    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
    }

    .user-avatar.role-admin {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .user-avatar.role-association {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .user-avatar.role-donor {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    /* Informations utilisateur */
    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-details {
        flex: 1;
    }

    .user-details strong {
        display: block;
        font-size: 16px;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .user-details small {
        display: block;
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 6px;
    }

    .user-meta {
        display: flex;
        gap: 15px;
        font-size: 12px;
        color: #9ca3af;
    }

    .user-meta span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Badges de rôle */
    .role-badge {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .role-admin {
        background: #ede9fe;
        color: #5b21b6;
        border: 1px solid #ddd6fe;
    }

    .role-association {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .role-donor {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #93c5fd;
    }

    /* Badges de statut */
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background: #f3f4f6;
        color: #6b7280;
    }

    .status-suspended {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .online-indicator {
        display: inline-block;
        margin-left: 8px;
    }

    .online-indicator i {
        color: #10b981;
        font-size: 10px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Date info */
    .date-info {
        display: flex;
        flex-direction: column;
    }

    .date-info div {
        color: #1f2937;
        font-weight: 500;
        font-size: 14px;
    }

    .date-info small {
        color: #9ca3af;
        font-size: 12px;
    }

    /* Actions dans le tableau */
    .table-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: #f1f5f9;
        color: var(--gray);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-icon:hover {
        background: #e2e8f0;
        transform: translateY(-1px);
    }

    .btn-icon.btn-view {
        color: #3b82f6;
    }

    .btn-icon.btn-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-icon.btn-danger {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-icon.btn-success {
        background: #d1fae5;
        color: #065f46;
    }

    .btn-icon.btn-primary {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Analytics Section */
    .analytics-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: var(--shadow);
        margin-top: 40px;
    }

    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 20px;
    }

    .analytics-card {
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
    }

    .analytics-card h4 {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 20px;
    }

    .chart-container-sm {
        height: 200px;
        position: relative;
        margin-bottom: 20px;
    }

    .chart-legend {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #4b5563;
    }

    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    /* Timeline */
    .timeline {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .timeline-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f3f4f6;
    }

    .timeline-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .timeline-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-top: 5px;
        flex-shrink: 0;
    }

    .timeline-dot.role-admin { background: #8b5cf6; }
    .timeline-dot.role-association { background: #f59e0b; }
    .timeline-dot.role-donor { background: #3b82f6; }

    .timeline-content {
        flex: 1;
    }

    .timeline-content strong {
        display: block;
        font-size: 14px;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .timeline-content p {
        margin: 0 0 4px 0;
        color: #6b7280;
        font-size: 13px;
    }

    .timeline-content small {
        color: #9ca3af;
        font-size: 12px;
    }

    /* Regions List */
    .regions-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .region-item {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .region-item span:first-child {
        width: 80px;
        font-size: 14px;
        color: #4b5563;
    }

    .region-bar {
        flex: 1;
        height: 8px;
        background: #e5e7eb;
        border-radius: 4px;
        overflow: hidden;
    }

    .bar-fill {
        height: 100%;
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border-radius: 4px;
    }

    .region-percent {
        width: 40px;
        text-align: right;
        font-weight: 600;
        color: #1f2937;
        font-size: 14px;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: var(--border-radius-lg);
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: var(--shadow-lg);
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 20px;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 24px;
        color: #6b7280;
        cursor: pointer;
        padding: 0;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.2s;
    }

    .close-modal:hover {
        background: #f3f4f6;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 20px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #4b5563;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius-sm);
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-check input {
        width: 18px;
        height: 18px;
    }

    .form-check label {
        margin: 0;
        font-weight: normal;
        cursor: pointer;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .quick-actions {
            flex-direction: column;
            align-items: stretch;
        }
        
        .quick-actions .btn {
            width: 100%;
        }
        
        .user-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .user-details {
            width: 100%;
        }
        
        .user-meta {
            flex-direction: column;
            gap: 5px;
        }
        
        .table-actions {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
        
        .table-actions .btn-icon {
            width: 100%;
            justify-content: flex-start;
            padding: 10px;
        }
        
        .analytics-grid {
            grid-template-columns: 1fr;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .modal-content {
            width: 95%;
            margin: 20px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser DataTable
    if ($.fn.DataTable) {
        const table = $('#usersTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
            },
            pageLength: 15,
            order: [[3, 'desc']], // Trier par date d'inscription
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [5] } // Désactiver le tri sur la colonne Actions
            ]
        });
        
        // Recherche personnalisée
        $('#userSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
        
        // Filtre par rôle
        $('#roleFilter').on('change', function() {
            const role = this.value;
            if (role) {
                table.column(1).search(role).draw();
            } else {
                table.column(1).search('').draw();
            }
        });
        
        // Filtre par statut
        $('#statusFilter').on('change', function() {
            const status = this.value;
            if (status) {
                table.column(2).search(status).draw();
            } else {
                table.column(2).search('').draw();
            }
        });
        
        // Réinitialiser les filtres
        $('#resetFilters').on('click', function() {
            $('#userSearch').val('');
            $('#roleFilter').val('');
            $('#statusFilter').val('');
            table.search('').columns().search('').draw();
        });
    }
    
    // Graphique de répartition des rôles
    if (typeof Chart !== 'undefined') {
        const rolesCtx = document.getElementById('rolesChart');
        if (rolesCtx) {
            new Chart(rolesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Donateurs', 'Associations', 'Administrateurs'],
                    datasets: [{
                        data: [75, 20, 5],
                        backgroundColor: [
                            '#3b82f6', // Bleu pour donateurs
                            '#f59e0b', // Orange pour associations
                            '#8b5cf6'  // Violet pour admins
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
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + '%';
                                }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        }
    }
    
    // Gestion du modal
    const modal = document.getElementById('userModal');
    const addUserBtn = document.getElementById('addUserBtn');
    const closeModalBtns = document.querySelectorAll('.close-modal');
    const saveUserBtn = document.getElementById('saveUser');
    
    // Ouvrir le modal
    addUserBtn.addEventListener('click', function() {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
    
    // Fermer le modal
    closeModalBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
            document.getElementById('userForm').reset();
        });
    });
    
    // Fermer en cliquant en dehors
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
            document.getElementById('userForm').reset();
        }
    });
    
    // Sauvegarder l'utilisateur
    saveUserBtn.addEventListener('click', function() {
        const form = document.getElementById('userForm');
        
        if (form.checkValidity()) {
            // Simulation d'AJAX
            showNotification('Utilisateur créé avec succès', 'success');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
            form.reset();
            
            // Rafraîchir la table (simulation)
            setTimeout(() => {
                if ($.fn.DataTable) {
                    $('#usersTable').DataTable().ajax.reload();
                }
            }, 1000);
        } else {
            form.reportValidity();
        }
    });
    
    // Actions sur les utilisateurs
    document.querySelectorAll('.table-actions button').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.dataset.action;
            const userId = this.dataset.id;
            const row = this.closest('tr');
            
            switch(action) {
                case 'view':
                    showNotification(`Voir le profil de l'utilisateur #${userId}`, 'info');
                    break;
                    
                case 'edit':
                    // Ouvrir modal d'édition avec les données de l'utilisateur
                    modal.classList.add('active');
                    document.getElementById('modalTitle').textContent = 'Modifier l\'utilisateur';
                    showNotification(`Modifier l'utilisateur #${userId}`, 'info');
                    break;
                    
                case 'suspend':
                    if (confirm(`Suspendre l'utilisateur #${userId} ?`)) {
                        const statusBadge = row.querySelector('.status-badge');
                        statusBadge.className = 'status-badge status-suspended';
                        statusBadge.textContent = 'Suspendu';
                        showNotification('Utilisateur suspendu', 'success');
                    }
                    break;
                    
                case 'activate':
                    if (confirm(`Activer l'utilisateur #${userId} ?`)) {
                        const statusBadge = row.querySelector('.status-badge');
                        statusBadge.className = 'status-badge status-active';
                        statusBadge.textContent = 'Actif';
                        showNotification('Utilisateur activé', 'success');
                    }
                    break;
                    
                case 'promote':
                    if (confirm(`Promouvoir l'utilisateur #${userId} en administrateur ?`)) {
                        const roleBadge = row.querySelector('.role-badge');
                        roleBadge.className = 'role-badge role-admin';
                        roleBadge.innerHTML = '<i class="fas fa-user-shield"></i> Administrateur';
                        showNotification('Utilisateur promu administrateur', 'success');
                    }
                    break;
            }
        });
    });
    
    // Exporter les utilisateurs
    document.getElementById('exportUsers')?.addEventListener('click', function() {
        showNotification('Export CSV en cours...', 'info');
        // Simulation d'export
        setTimeout(() => {
            showNotification('Export terminé ! Téléchargement démarré.', 'success');
        }, 1500);
    });
    
    // Envoyer email groupé
    document.getElementById('sendBulkEmail')?.addEventListener('click', function() {
        showNotification('Fonctionnalité d\'email groupé en développement', 'info');
    });
    
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
});
</script>
@endpush