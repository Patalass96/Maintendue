
@extends('layouts.admin')

@section('title', 'Gestion des Associations')
@section('page-title', 'Gestion des Associations')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/admin.css',])
@endsection

@section('content')
<div class="associations-container">

    <!-- Statistiques des associations -->
    <div class="stats-grid mb-30">
        <div class="stat-card">
            <div class="stat-icon bg-blue">
                <i class="fas fa-handshake"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number"></h3>
                <p class="stat-label">Associations Actives</p>
                <span class="stat-trend positive">+5 ce trimestre</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-green">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number"></h3>
                <p class="stat-label">Associations Vérifiées</p>
                <span class="stat-trend positive">98% vérifiées</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number"></h3>
                <p class="stat-label">En Attente</p>
                <span class="stat-trend negative">À traiter</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-red">
                <i class="fas fa-flag"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number"></h3>
                <p class="stat-label">Signalées</p>
                <span class="stat-trend negative">À examiner</span>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="admin-filters mb-20">
        <div class="filter-row">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher une association..." class="search-input">
            </div>

            <div class="filter-group">
                <select class="filter-select">
                    <option value="">Tous les statuts</option>
                    <option value="active">Actives</option>
                    <option value="pending">En attente</option>
                    <option value="suspended">Suspendues</option>
                </select>

                <select class="filter-select">
                    <option value="">Toutes les catégories</option>
                    <option value="education">Éducation</option>
                    <option value="health">Santé</option>
                    <option value="environment">Environnement</option>
                </select>

                <button class="btn btn-secondary">
                    <i class="fas fa-filter"></i>
                    Filtrer
                </button>
            </div>
        </div>
    </div>

    <!-- Tableau des associations -->
    <div class="admin-table-container">
        <table class="admin-table" id="associationsTable">
            <thead>
                <tr>
                    <th>ASSOCIATION</th>
                    <th>Date d'inscription</th>
                    <th>Statut</th>
                    <th>Dons reçus</th>
                    <th>Membres</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= 15; $i++)
                <tr>
                    <td>
                        <div class="association-info">
                            <div class="association-avatar">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <div>
                                <strong>Association {{ $i }}</strong>
                                <small>Catégorie {{ $i % 3 == 0 ? 'Éducation' : ($i % 3 == 1 ? 'Santé' : 'Environnement') }}</small>
                            </div>
                        </div>
                    </td>
                    <td>2024-0{{ $i % 9 + 1 }}-{{ 10 + $i % 20 }}</td>
                    <td>
                        @if($i % 5 == 0)
                        <span class="status-badge pending">En attente</span>
                        @elseif($i % 7 == 0)
                        <span class="status-badge suspended">Suspendue</span>
                        @else
                        <span class="status-badge active">Active</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $i * 250 }} CFA </strong>
                        <br>
                        <small>{{ $i * 10 }} dons</small>
                    </td>
                    <td>{{ $i * 3 }}</td>
                    <td>
                        <div class="table-actions">
                            <button class="btn-icon btn-view" title="Voir">
                                <i class="fas fa-eye"></i>
                            </button>

                            @if($i % 5 == 0)
                            <button class="btn-icon btn-success btn-validate" title="Valider">
                                <i class="fas fa-check"></i>
                            </button>
                            @endif

                            <button class="btn-icon btn-warning" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>

                            @if($i % 7 != 0)
                            <button class="btn-icon btn-danger" title="Suspendre">
                                <i class="fas fa-pause"></i>
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
                Affichage de 1 à 15 sur 120 associations
            </div>
            <div class="pagination">
                <button class="pagination-btn disabled">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <span class="pagination-dots">...</span>
                <button class="pagination-btn">8</button>
                <button class="pagination-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Section des associations en attente de validation -->
    <div class="section-card mt-40">
        <div class="section-header">
            <h3><i class="fas fa-clock text-orange"></i> Associations en attente de validation</h3>
            <span class="badge bg-orange">8 nouvelles</span>
        </div>

        <div class="pending-associations-grid">
            @for($i = 1; $i <= 4; $i++)
            <div class="pending-card">
                <div class="pending-header">
                    <div class="pending-avatar">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h4>Nouvelle Association {{ $i }}</h4>
                        <p>Inscrite le 15/12/2024</p>
                    </div>
                </div>

                <div class="pending-content">
                    <p><i class="fas fa-tag"></i> Catégorie : {{ ['Éducation', 'Santé', 'Environnement', 'Social'][$i-1] }}</p>
                    <p><i class="fas fa-map-marker-alt"></i> Lomé, Togo</p>
                </div>

                <div class="pending-actions">
                    <button class="btn btn-sm btn-success">
                        <i class="fas fa-check"></i> Valider
                    </button>
                    <button class="btn btn-sm btn-outline">
                        <i class="fas fa-eye"></i> Voir détails
                    </button>
                    <button class="btn btn-sm btn-danger">
                        <i class="fas fa-times"></i> Rejeter
                    </button>
                </div>
            </div>
            @endfor
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    /* Styles spécifiques à la page associations */
    .associations-container {
        padding: 20px;
    }

    /* Grid des statistiques */
    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: var(--shadow);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .stat-icon.bg-blue { background: #3b82f6; }
    .stat-icon.bg-green { background: #10b981; }
    .stat-icon.bg-orange { background: #f59e0b; }
    .stat-icon.bg-red { background: #ef4444; }

    .stat-content {
        flex: 1;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 5px 0;
        color: var(--black);
    }

    .stat-label {
        color: var(--gray);
        margin: 0 0 5px 0;
        font-size: 14px;
    }

    .stat-trend {
        font-size: 12px;
        font-weight: 600;
    }

    .stat-trend.positive { color: #10b981; }
    .stat-trend.negative { color: #ef4444; }

    /* Filtres */
    .admin-filters {
        background: white;
        padding: 20px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .filter-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
    }

    .search-input {
        width: 100%;
        padding: 12px 15px 12px 45px;
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius-sm);
        font-size: 14px;
    }

    .filter-group {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-select {
        padding: 10px 15px;
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius-sm);
        background: white;
        font-size: 14px;
        min-width: 150px;
    }

    /* Table */
    .admin-table-container {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        margin-bottom: 30px;
    }

    .admin-table {
        width: 100%;
        margin-top: 2em;
        border-collapse: collapse;
    }

    .admin-table thead {
        background: #f1f5f9;
    }

    .admin-table th {
        padding: 15px 20px;
        text-align: left;
        font-weight: 600;
        color: var(--dark-gray);
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
    }

    .admin-table td {
        padding: 15px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .admin-table tbody tr:hover {
        background: #f8fafc;
    }

    .association-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .association-avatar {
        width: 40px;
        height: 40px;
        background: var(--primary-light);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 18px;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .status-badge.active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-badge.suspended {
        background: #fee2e2;
        color: #991b1b;
    }

    .table-actions {
        display: flex;
        gap: 5px;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
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
    }

    .btn-icon.btn-success {
        background: #d1fae5;
        color: #065f46;
    }

    .btn-icon.btn-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-icon.btn-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Pagination */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .table-info {
        color: var(--gray);
        font-size: 14px;
    }

    .pagination {
        display: flex;
        gap: 5px;
    }

    .pagination-btn {
        width: 36px;
        height: 36px;
        border: 1px solid #e2e8f0;
        background: white;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pagination-btn:hover:not(.disabled) {
        background: #f1f5f9;
    }

    .pagination-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-dots {
        padding: 0 10px;
        display: flex;
        align-items: center;
        color: var(--gray);
    }

    /* Associations en attente */
    .section-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--shadow);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }
    #associationsTable{
        margin-top: 2em !important;
    }

    .section-header h3 {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
    }

    .pending-associations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .pending-card {
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius);
        padding: 20px;
        transition: all 0.3s ease;
    }

    .pending-card:hover {
        border-color: var(--primary-color);
        box-shadow: var(--shadow);
    }

    .pending-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .pending-avatar {
        width: 50px;
        height: 50px;
        background: #e0f2fe;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 20px;
    }

    .pending-header h4 {
        margin: 0 0 5px 0;
        font-size: 16px;
    }

    .pending-header p {
        margin: 0;
        color: var(--gray);
        font-size: 12px;
    }

    .pending-content p {
        margin: 8px 0;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pending-content i {
        width: 16px;
        color: var(--primary-color);
    }

    .pending-actions {
        display: flex;
        gap: 8px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .pending-actions .btn {
        flex: 1;
        min-width: 80px;
        font-size: 12px;
        padding: 8px 12px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .filter-row {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            max-width: 100%;
        }

        .filter-group {
            width: 100%;
        }

        .filter-select {
            flex: 1;
        }

        .table-footer {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .table-actions {
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser DataTable si présent
    if ($.fn.DataTable) {
        $('#associationsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
            },
            pageLength: 10,
            responsive: true,
            order: [[1, 'desc']]
        });
    }

    // Gestion des actions
    document.querySelectorAll('.btn-validate').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Valider cette association ?')) {
                const row = this.closest('tr');
                // Simulation AJAX
                row.querySelector('.status-badge').className = 'status-badge active';
                row.querySelector('.status-badge').textContent = 'Active';
                this.remove();
                showNotification('Association validée avec succès', 'success');
            }
        });
    });

    //Modification d'une association

    document.querySelectorAll('.btn-warning').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('tr');
            const associationName = row.querySelector('.association-info strong').textContent;

            console.log('✏️ Modification de:', associationName);

            showNotification(`Ouverture de l'édition de "${associationName}"`, 'info');

            // TODO: Rediriger vers page d'édition ou ouvrir modal d'édition
            // window.location.href = `/admin/associations/${associationId}/edit`;

            // Ou ouvrir un modal d'édition
            // openEditModal(associationId);
        });
    });


    //suppension d'une association

    document.querySelectorAll('.btn-danger').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('tr');
            const associationName = row.querySelector('.association-info strong').textContent;
            const statusBadge = row.querySelector('.status-badge');
            const currentStatus = statusBadge.textContent.trim();

            // Déterminer l'action selon le statut actuel
            const isSuspended = currentStatus === 'Suspendue';
            const action = isSuspended ? 'réactiver' : 'suspendre';
            const actionVerb = isSuspended ? 'Réactivation' : 'Suspension';

            if (confirm(`Confirmer la ${action} de "${associationName}" ?`)) {
                console.log(`🚫 ${actionVerb} de:`, associationName);

                if (isSuspended) {
                    // Réactiver
                    statusBadge.className = 'status-badge active';
                    statusBadge.textContent = 'Active';

                    row.style.backgroundColor = '#f0fdf4';
                    this.innerHTML = '<i class="fas fa-pause"></i>';
                    this.title = 'Suspendre';

                    showNotification(`"${associationName}" réactivée`, 'success');
                } else {
                    // Suspendre
                    statusBadge.className = 'status-badge suspended';
                    statusBadge.textContent = 'Suspendue';

                    row.style.backgroundColor = '#fef2f2';
                    this.innerHTML = '<i class="fas fa-play"></i>';
                    this.title = 'Réactiver';

                    showNotification(`"${associationName}" suspendue`, 'warning');
                }

                // Réinitialiser la couleur après animation
                setTimeout(() => {
                    row.style.backgroundColor = '';
                }, 2000);

                // TODO: Appel AJAX pour sauvegarder
                /*
                fetch(`/admin/associations/${associationId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ action: action })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Statut mis à jour:', data);
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('Erreur lors du changement de statut', 'error');
                });
                */
            }
        });
    });

    // Voir les détails d'une association

  document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('tr');
            const associationName = row.querySelector('.association-info strong').textContent;
            const category = row.querySelector('.association-info small').textContent;

            console.log('👁️ Affichage détails:', associationName);

            // Vous pouvez soit :
            // 1. Ouvrir un modal avec les détails
            // 2. Rediriger vers une page de détails

            // Exemple avec modal (à adapter selon vos besoins)
            showNotification(`Affichage des détails de "${associationName}"`, 'info');

            // TODO: Ouvrir un modal ou rediriger
            // window.location.href = `/admin/associations/${associationId}`;
        });
    });


    // Recherche en temps réel
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#associationsTable tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Fonction de notification
    function showNotification(message, type = 'info') {
        const flashContainer = document.querySelector('.flash-container');
        const alert = document.createElement('div');
        alert.className = `alert-flash ${type} fade-in`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check' : 'info'}-circle"></i>
            <span>${message}</span>
            <button class="close-btn">&times;</button>
        `;

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

<!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('styles')
