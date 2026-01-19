@extends('layouts.validate')

@section('title', 'Validation des Associations')
@section('page-title', 'Validation des Associations')

@section('content')
<div class="validation-container">

    <!-- En-tête avec statistiques -->
    <div class="validation-header">
        <div class="header-stats">
            <div class="stat-item">
                <i class="fas fa-clock"></i>
                <div>
                    <h3>12</h3>
                    <p>En attente</p>
                </div>
            </div>
            <div class="stat-item">
                <i class="fas fa-check-circle"></i>
                <div>
                    <h3>45</h3>
                    <p>Validées ce mois</p>
                </div>
            </div>
            <div class="stat-item">
                <i class="fas fa-times-circle"></i>
                <div>
                    <h3>3</h3>
                    <p>Rejetées ce mois</p>
                </div>
            </div>
            <div class="stat-item">
                <i class="fas fa-hourglass-half"></i>
                <div>
                    <h3>2.5j</h3>
                    <p>Temps moyen</p>
                </div>
            </div>
        </div>

        <div class="header-actions">
            <button class="btn btn-secondary" id="bulkValidate">
                <i class="fas fa-check-double"></i>
                Valider la sélection
            </button>
            <button class="btn btn-outline" id="exportPending">
                <i class="fas fa-file-export"></i>
                Exporter
            </button>
        </div>
    </div>

    <!-- Filtres de validation -->
    <div class="validation-filters">
        <div class="filter-group">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher une association..." id="searchAssociation">
            </div>

            <select class="filter-select" id="filterCategory">
                <option value="">Toutes catégories</option>
                <option value="education">Éducation</option>
                <option value="health">Santé</option>
                <option value="environment">Environnement</option>
                <option value="social">Social</option>
                <option value="other">Autre</option>
            </select>

            <select class="filter-select" id="filterRegion">
                <option value="">Toutes régions</option>
                <option value="lome">Lomé</option>
                <option value="kara">Kara</option>
                <option value="savanes">Savanes</option>
                <option value="centrale">Centrale</option>
                <option value="plateaux">Plateaux</option>
                <option value="maritime">Maritime</option>
            </select>

            <input type="date" class="filter-select" id="filterDate" placeholder="Date d'inscription">
        </div>
    </div>

    <!-- Liste des associations à valider -->
    <div class="associations-list">
        @for($i = 1; $i <= 8; $i++)
        @php
            $categories = ['Éducation', 'Santé', 'Environnement', 'Social'];
            $category = $categories[array_rand($categories)];

            $regions = ['Lomé', 'Kara', 'Sokodé', 'Atakpamé', 'Dapaong'];
            $region = $regions[array_rand($regions)];

            $names = [
                'Les Jeunes Espoirs',
                'Solidarité pour Tous',
                'Main dans la Main',
                'Coeur de Lion',
                'Espoir Nouveau',
                'Les Vaillants',
                'Unis pour Demain',
                'La Main Tendue'
            ];
            $name = $names[$i-1];

            $daysAgo = rand(1, 7);
        @endphp
        <div class="association-card" data-id="{{ $i }}" data-category="{{ strtolower($category) }}" data-region="{{ strtolower($region) }}">
            <div class="card-header">
                <div class="association-info">
                    <div class="association-avatar pending">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <div>
                        <h4>{{ $name }}</h4>
                        <div class="association-meta">
                            <span><i class="fas fa-tag"></i> {{ $category }}</span>
                            <span><i class="fas fa-map-marker-alt"></i> {{ $region }}</span>
                            <span><i class="fas fa-clock"></i> Il y a {{ $daysAgo }} jour(s)</span>
                        </div>
                    </div>
                </div>

                <div class="card-actions">
                    <label class="checkbox-container">
                        <input type="checkbox" class="association-checkbox" value="{{ $i }}">
                        <span class="checkmark"></span>
                    </label>

                    <button class="btn-icon btn-success btn-validate" data-id="{{ $i }}">
                        <i class="fas fa-check"></i>
                    </button>

                    <button class="btn-icon btn-danger btn-reject" data-id="{{ $i }}">
                        <i class="fas fa-times"></i>
                    </button>

                    <button class="btn-icon btn-primary btn-view" data-id="{{ $i }}">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="association-details">
                    <div class="detail-row">
                        <div class="detail-item">
                            <strong>Représentant</strong>
                            <p>Nom du représentant {{ $i }}</p>
                        </div>
                        <div class="detail-item">
                            <strong>Téléphone</strong>
                            <p>+228 XX XX XX XX</p>
                        </div>
                        <div class="detail-item">
                            <strong>Email</strong>
                            <p>contact@{{ strtolower(str_replace(' ', '', $name)) }}.tg</p>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-item">
                            <strong>Date création</strong>
                            <p>2023-{{ str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) }}-{{ str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="detail-item">
                            <strong>Membres</strong>
                            <p>{{ rand(5, 50) }} membres</p>
                        </div>
                        <div class="detail-item">
                            <strong>Statut juridique</strong>
                            <p>Association déclarée</p>
                        </div>
                    </div>
                </div>

                <div class="document-preview">
                    <h5><i class="fas fa-file-alt"></i> Documents fournis</h5>
                    <div class="documents-list">
                        <div class="document-item">
                            <i class="fas fa-file-pdf"></i>
                            <span>Statuts_Association_{{ $i }}.pdf</span>
                            <button class="btn-text btn-view-doc" data-doc="statuts">
                                <i class="fas fa-eye"></i> Voir
                            </button>
                        </div>
                        <div class="document-item">
                            <i class="fas fa-file-image"></i>
                            <span>RIB_Association_{{ $i }}.jpg</span>
                            <button class="btn-text btn-view-doc" data-doc="rib">
                                <i class="fas fa-eye"></i> Voir
                            </button>
                        </div>
                        <div class="document-item">
                            <i class="fas fa-file-contract"></i>
                            <span>Récépissé_{{ $i }}.pdf</span>
                            <button class="btn-text btn-view-doc" data-doc="recepisse">
                                <i class="fas fa-eye"></i> Voir
                            </button>
                        </div>
                    </div>
                </div>

                <div class="description-preview">
                    <h5><i class="fas fa-align-left"></i> Description</h5>
                    <p>Cette association a pour but d'aider les personnes dans le besoin dans la région de {{ $region }}.
                    Elle intervient principalement dans le domaine de {{ strtolower($category) }} et compte {{ rand(5, 50) }} membres actifs.</p>
                </div>
            </div>

            <div class="card-footer">
                <div class="validation-notes">
                    <textarea placeholder="Ajouter une note pour la validation..." class="notes-input" data-id="{{ $i }}"></textarea>
                </div>

                <div class="footer-actions">
                    <button class="btn btn-outline btn-request-info" data-id="{{ $i }}">
                        <i class="fas fa-question-circle"></i>
                        Demander plus d'infos
                    </button>

                    <div class="action-buttons">
                        <button class="btn btn-danger btn-reject-full" data-id="{{ $i }}">
                            <i class="fas fa-times"></i>
                            Rejeter
                        </button>
                        <button class="btn btn-success btn-validate-full" data-id="{{ $i }}">
                            <i class="fas fa-check"></i>
                            Valider
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        <div class="pagination-info">
            Affichage de 1 à 8 sur 12 associations en attente
        </div>
        <div class="pagination">
            <button class="pagination-btn disabled">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <!-- Section associations récemment validées -->
    <div class="recently-validated mt-40">
        <div class="section-header">
            <h3><i class="fas fa-history"></i> Récemment validées</h3>
            <a href="/resources/views/admin/" class="btn-link">Voir tout</a>
        </div>

        <div class="validated-grid">
            @for($j = 1; $j <= 4; $j++)
            <div class="validated-card">
                <div class="validated-header">
                    <div class="association-avatar validated">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <div>
                        <h5>{{ $j }}</h5>
                        <small>Validée il y a {{ $j }} jour(s)</small>
                    </div>
                </div>
                <div class="validated-body">
                    <p>Catégorie: {{ ['Éducation', 'Santé', 'Environnement', 'Social'][$j-1] }}</p>
                    <div class="validator-info">
                        <i class="fas fa-user-check"></i>
                        <span>Validée par: Admin</span>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>

</div>

<!-- Modal de visualisation des documents -->
<div class="modal" id="documentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="docTitle">Document</h3>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="document-viewer" id="docViewer">
                <!-- PDF viewer ou image preview -->
                <div class="document-placeholder">
                    <i class="fas fa-file-pdf fa-5x"></i>
                    <p>Aperçu du document</p>
                    <small>En développement: intégration PDF viewer</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ===== VALIDATION ASSOCIATION STYLES ===== */
    .validation-container {
        min-height: 130vh;
             position: sticky; /* ✅ Ajouté */
            top: center; /* ✅ Ajouté */

        padding: 20px;
    }

    /* En-tête */
    .validation-header {
        /* background: white; */
        border-radius: var(--border-radius);
        padding: 25px;
        /* box-shadow: var(--shadow); */
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
    }

    .header-stats {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .stat-item {
        background: white;
        padding: 10px !important;
        display: flex;
        align-items: center;
        gap: 5px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .stat-item i {
        font-size: 32px;
        color: var(--primary-color);
        width: 60px;
        height: 60px;
        background: var(--primary-light);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-item h3 {
        margin: 0;
        font-size: 28px;
        color: #1f2937;
    }

    .stat-item p {
        margin: 5px 0 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    /* Filtres */
    .validation-filters {
        background: white;
        border-radius: var(--border-radius);
        padding: 20px;
        box-shadow: var(--shadow);
        margin-bottom: 25px;
    }

    .filter-group {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-group .search-box {
        flex: 1;
        min-width: 300px;
        position: relative;
    }

    .filter-group .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .filter-group .search-box input {
        width: 100%;
        padding: 12px 15px 12px 45px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius-sm);
        font-size: 14px;
    }

    .filter-select {
        padding: 12px 15px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius-sm);
        background: white;
        font-size: 14px;
        min-width: 180px;
    }

    /* Carte d'association */
    .associations-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .association-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid #e5e7eb;
        transition: all 0.3s;
        overflow: hidden;
        padding: 1em;
    }

    .association-card:hover {
        border-color: var(--primary-color);
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        background: #f8fafc;
    }

    .association-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .association-avatar {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
    }

    .association-avatar.pending {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .association-avatar.validated {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .association-info h4 {
        margin: 0 0 8px 0;
        color: #1f2937;
        font-size: 20px;
    }

    .association-meta {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .association-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: #6b7280;
    }

    .card-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .checkbox-container {
        display: block;
        position: relative;
        cursor: pointer;
    }

    .checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: relative;
        height: 24px;
        width: 24px;
        background-color: #fff;
        border: 2px solid #d1d5db;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .checkbox-container input:checked ~ .checkmark {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .checkbox-container input:checked ~ .checkmark:after {
        display: block;
        left: 7px;
        top: 3px;
        width: 6px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: none;
        background: #f3f4f6;
        color: #6b7280;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-icon:hover {
        transform: translateY(-2px);
    }

    .btn-icon.btn-success {
        background: #d1fae5;
        color: #065f46;
    }

    .btn-icon.btn-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-icon.btn-primary {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Corps de la carte */
    .card-body {
        padding: 25px;
    }

    .association-details {
        margin-bottom: 25px;
        padding: 20px;
        background: #f8fafc;
        border-radius: var(--border-radius);
    }

    .detail-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .detail-row:last-child {
        margin-bottom: 0;
    }

    .detail-item strong {
        display: block;
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .detail-item p {
        margin: 0;
        color: #1f2937;
        font-weight: 500;
    }

    /* Documents */
    .document-preview {
        margin-bottom: 25px;
        padding: 20px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
    }

    .document-preview h5 {
        margin: 0 0 15px 0;
        color: #4b5563;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .documents-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .document-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 15px;
        background: #f9fafb;
        border-radius: var(--border-radius-sm);
        border: 1px solid #e5e7eb;
    }

    .document-item i {
        font-size: 20px;
        color: #dc2626;
        width: 24px;
    }

    .document-item span {
        flex: 1;
        color: #1f2937;
        font-size: 14px;
    }

    .btn-text {
        background: none;
        border: none;
        color: var(--primary-color);
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 0;
    }

    .btn-text:hover {
        color: var(--primary-dark);
    }

    /* Description */
    .description-preview {
        padding: 20px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
    }

    .description-preview h5 {
        margin: 0 0 15px 0;
        color: #4b5563;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .description-preview p {
        margin: 0;
        color: #6b7280;
        line-height: 1.6;
    }

    /* Pied de carte */
    .card-footer {
        padding: 20px;
        border-top: 1px solid #e5e7eb;
        background: #f8fafc;
    }

    .validation-notes {
        margin-bottom: 20px;
    }

    .notes-input {
        width: 100%;
        padding: 15px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius-sm);
        font-size: 14px;
        min-height: 80px;
        resize: vertical;
    }

    .notes-input:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .footer-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
    }

    /* Récemment validées */
    .recently-validated {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--shadow);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e5e7eb;
    }

    .section-header h3 {
        margin: 0;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    .validated-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .validated-card {
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
        background: #f0fdf4;
        transition: transform 0.3s;
    }

    .validated-card:hover {
        transform: translateY(-5px);
    }

    .validated-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .validated-header h5 {
        margin: 0 0 5px 0;
        color: #1f2937;
    }

    .validated-header small {
        color: #6b7280;
        font-size: 12px;
    }

    .validated-body p {
        margin: 0 0 10px 0;
        color: #4b5563;
        font-size: 14px;
    }

    .validator-info {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #059669;
        font-size: 14px;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-top: 30px;
    }

    .pagination-info {
        color: #6b7280;
        font-size: 14px;
    }

    .pagination {
        display: flex;
        gap: 5px;
    }

    .pagination-btn {
        width: 40px;
        height: 40px;
        border: 1px solid #e5e7eb;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
    }

    .pagination-btn:hover:not(.disabled) {
        background: #f3f4f6;
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

    /* Modal */
    .document-placeholder {
        text-align: center;
        padding: 40px;
        color: #9ca3af;
    }

    .document-placeholder i {
        margin-bottom: 20px;
        color: #d1d5db;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .validation-header {
            flex-direction: column;
            align-items: stretch;
        }

        .header-stats {
            justify-content: center;
        }

        .filter-group {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group .search-box {
            min-width: auto;
        }

        .card-header {
            flex-direction: column;
            align-items: stretch;
        }

        .association-info {
            flex-direction: column;
            text-align: center;
        }

        .association-meta {
            justify-content: center;
        }

        .card-actions {
            justify-content: center;
        }

        .footer-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .action-buttons {
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .stat-item {
            flex: 1;
            min-width: 140px;
        }

        .detail-row {
            grid-template-columns: 1fr;
        }

        .validated-grid {
            grid-template-columns: 1fr;
        }

        .pagination-container {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin JS initialisé');

    // ===== TEST DE DÉBOGAGE =====
    console.log('Nombre de boutons .btn-validate-full:', document.querySelectorAll('.btn-validate-full').length);

    document.querySelectorAll('.btn-validate-full').forEach((btn, index) => {
        const id = btn.getAttribute('data-id');
        console.log(`Bouton ${index}: data-id =`, id);
    });
    // ===== VALIDATION D'ASSOCIATION =====
    document.querySelectorAll('.btn-validate, .btn-validate-full').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); // Empêcher la soumission de formulaire

            const associationId = this.getAttribute('data-id'); // Utiliser getAttribute
            console.log('Validation de l\'association:', associationId);

            if (!associationId) {
                console.error('Aucun ID trouvé pour ce bouton');
                alert('Erreur: ID d\'association manquant');
                return;
            }

            const card = document.querySelector(`.association-card[data-id="${associationId}"]`);

            if (!card) {
                console.error('Carte non trouvée pour l\'ID:', associationId);
                return;
            }

            const notes = card.querySelector('.notes-input')?.value || '';

            if (confirm(`Confirmer la validation de l'association #${associationId} ?`)) {
                // Animation de succès
                card.style.transition = 'all 0.5s ease';
                card.style.borderColor = '#10b981';
                card.style.boxShadow = '0 4px 20px rgba(16, 185, 129, 0.2)';

                // Ici : Appel AJAX pour sauvegarder en BDD
                // Exemple :
                /*
                fetch(`/admin/validate-association/${associationId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ notes: notes })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Association validée avec succès', 'success');
                        // Supprimer la carte
                        setTimeout(() => {
                            card.style.opacity = '0';
                            card.style.transform = 'translateX(-100px)';
                            setTimeout(() => card.remove(), 300);
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('Erreur lors de la validation', 'error');
                });
                */

                // Pour l'instant : simulation
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(-100px)';
                    setTimeout(() => card.remove(), 300);
                }, 1000);

                showNotification('Association validée avec succès', 'success');
            }
        });
    });

    // ===== REJET D'ASSOCIATION =====
    document.querySelectorAll('.btn-reject, .btn-reject-full').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const associationId = this.getAttribute('data-id');
            console.log('Rejet de l\'association:', associationId);

            if (!associationId) {
                console.error('Aucun ID trouvé pour ce bouton');
                alert('Erreur: ID d\'association manquant');
                return;
            }

            const card = document.querySelector(`.association-card[data-id="${associationId}"]`);
            const notes = card?.querySelector('.notes-input')?.value || '';

            if (confirm(`Confirmer le rejet de l'association #${associationId} ?`)) {
                card.style.transition = 'all 0.5s ease';
                card.style.borderColor = '#dc2626';
                card.style.boxShadow = '0 4px 20px rgba(220, 38, 38, 0.2)';

                // Appel AJAX ici si besoin

                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(100px)';
                    setTimeout(() => card.remove(), 300);
                }, 1000);

                showNotification('Association rejetée', 'warning');
            }
        });
    });

    // ===== FILTRES =====
    const searchInput = document.getElementById('searchAssociation');
    const categoryFilter = document.getElementById('filterCategory');
    const regionFilter = document.getElementById('filterRegion');
    const dateFilter = document.getElementById('filterDate');

    function filterAssociations() {
        const searchTerm = searchInput?.value.toLowerCase() || '';
        const category = categoryFilter?.value || '';
        const region = regionFilter?.value || '';

        document.querySelectorAll('.association-card').forEach(card => {
            const name = card.querySelector('h4')?.textContent.toLowerCase() || '';
            const cardCategory = card.getAttribute('data-category') || '';
            const cardRegion = card.getAttribute('data-region') || '';

            let visible = true;

            if (searchTerm && !name.includes(searchTerm)) visible = false;
            if (category && cardCategory !== category) visible = false;
            if (region && cardRegion !== region) visible = false;

            card.style.display = visible ? 'block' : 'none';
        });
    }

    if (searchInput) searchInput.addEventListener('input', filterAssociations);
    if (categoryFilter) categoryFilter.addEventListener('change', filterAssociations);
    if (regionFilter) regionFilter.addEventListener('change', filterAssociations);
    if (dateFilter) dateFilter.addEventListener('change', filterAssociations);

    // ===== VOIR DOCUMENTS =====
    document.querySelectorAll('.btn-view-doc').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const docType = this.getAttribute('data-doc');
            const modal = document.getElementById('documentModal');
            const title = document.getElementById('docTitle');

            if (modal && title) {
                title.textContent = `Document: ${docType}`;
                modal.style.display = 'block';
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Fermer modal
    const closeModal = document.querySelector('.close-modal');
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            const modal = document.getElementById('documentModal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    }

    // ===== FONCTION NOTIFICATION =====
    window.showNotification = function(message, type = 'info') {
        const flashContainer = document.querySelector('.flash-container');
        if (!flashContainer) {
            console.error('Flash container introuvable');
            return;
        }

        const alert = document.createElement('div');
        alert.className = `alert-flash ${type} fade-in`;

        const iconMap = {
            'success': 'check-circle',
            'error': 'exclamation-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle'
        };

        alert.innerHTML = `
            <i class="fas fa-${iconMap[type] || 'info-circle'}"></i>
            <span>${message}</span>
            <button class="close-btn">&times;</button>
        `;

        flashContainer.appendChild(alert);

        // Auto-remove
        setTimeout(() => {
            alert.classList.add('fade-out');
            setTimeout(() => alert.remove(), 500);
        }, 5000);

        // Bouton fermeture
        alert.querySelector('.close-btn').addEventListener('click', () => {
            alert.remove();
        });
    };
});
</script>
@endpush
