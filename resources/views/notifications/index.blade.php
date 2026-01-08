@extends('layouts.app')

@section('title', 'Notifications - MAIN TENDUE')

@section('content')
<div class="notifications-container">
    <div class="container">
        <!-- En-tête -->
        <div class="notifications-header mb-30">
            <div class="header-content">
                <h1 class="page-title">Notifications</h1>
                <p class="page-subtitle">Restez informé de toutes vos activités</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-outline" id="markAllRead">
                    <i class="fas fa-check-double"></i>
                    Tout marquer comme lu
                </button>
                <button class="btn btn-outline btn-danger" id="deleteAll">
                    <i class="fas fa-trash"></i>
                    Tout supprimer
                </button>
            </div>
        </div>

        <!-- Filtres -->
        <div class="notifications-filters mb-30">
            <div class="filters-row">
                <button class="filter-btn active" data-filter="all">
                    <i class="fas fa-list"></i>
                    Toutes
                    <span class="filter-badge">24</span>
                </button>
                
                <button class="filter-btn" data-filter="unread">
                    <i class="fas fa-envelope"></i>
                    Non lues
                    <span class="filter-badge">8</span>
                </button>
                
                <button class="filter-btn" data-filter="system">
                    <i class="fas fa-cog"></i>
                    Système
                    <span class="filter-badge">5</span>
                </button>
                
                <button class="filter-btn" data-filter="donations">
                    <i class="fas fa-donate"></i>
                    Dons
                    <span class="filter-badge">7</span>
                </button>
                
                <button class="filter-btn" data-filter="associations">
                    <i class="fas fa-hands-helping"></i>
                    Associations
                    <span class="filter-badge">4</span>
                </button>
                
                <button class="filter-btn" data-filter="messages">
                    <i class="fas fa-comment"></i>
                    Messages
                    <span class="filter-badge">3</span>
                </button>
            </div>
        </div>

        <!-- Liste des notifications -->
        <div class="notifications-list">
            <!-- Aujourd'hui -->
            <div class="notifications-day">
                <div class="day-header">
                    <h3><i class="fas fa-calendar-day"></i> Aujourd'hui</h3>
                    <span class="day-count">8 notifications</span>
                </div>
                
                <div class="notifications-items">
                    <!-- Notification 1 -->
                    <div class="notification-item unread" data-type="donations" data-id="1">
                        <div class="notification-icon success">
                            <i class="fas fa-donate"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-header">
                                <h4>Don confirmé !</h4>
                                <span class="notification-time">Il y a 2 heures</span>
                            </div>
                            <p class="notification-text">
                                Votre don de <strong>50€</strong> à l'association <strong>Les Jeunes Espoirs</strong> a été confirmé avec succès.
                            </p>
                            <div class="notification-actions">
                                <button class="btn-text mark-read" data-id="1">
                                    <i class="fas fa-check"></i>
                                    Marquer comme lu
                                </button>
                                <button class="btn-text view-details" data-id="1">
                                    <i class="fas fa-eye"></i>
                                    Voir le reçu
                                </button>
                            </div>
                        </div>
                        <div class="notification-actions-right">
                            <button class="btn-icon delete-notification" title="Supprimer" data-id="1">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Notification 2 -->
                    <div class="notification-item unread" data-type="associations" data-id="2">
                        <div class="notification-icon primary">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-header">
                                <h4>Nouvelle association suivie</h4>
                                <span class="notification-time">Il y a 4 heures</span>
                            </div>
                            <p class="notification-text">
                                L'association <strong>Solidarité pour Tous</strong> a publié un nouveau besoin : <em>"Fournitures scolaires pour 50 enfants"</em>.
                            </p>
                            <div class="notification-actions">
                                <button class="btn-text mark-read" data-id="2">
                                    <i class="fas fa-check"></i>
                                    Marquer comme lu
                                </button>
                                <button class="btn-text view-details" data-id="2">
                                    <i class="fas fa-eye"></i>
                                    Voir le besoin
                                </button>
                            </div>
                        </div>
                        <div class="notification-actions-right">
                            <button class="btn-icon delete-notification" title="Supprimer" data-id="2">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Notification 3 -->
                    <div class="notification-item" data-type="system" data-id="3">
                        <div class="notification-icon warning">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-header">
                                <h4>Mise à jour des conditions d'utilisation</h4>
                                <span class="notification-time">Il y a 6 heures</span>
                            </div>
                            <p class="notification-text">
                                Nous avons mis à jour nos conditions d'utilisation. Veuillez prendre connaissance des changements.
                            </p>
                            <div class="notification-actions">
                                <button class="btn-text view-details" data-id="3">
                                    <i class="fas fa-file-alt"></i>
                                    Lire les modifications
                                </button>
                            </div>
                        </div>
                        <div class="notification-actions-right">
                            <button class="btn-icon delete-notification" title="Supprimer" data-id="3">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hier -->
            <div class="notifications-day">
                <div class="day-header">
                    <h3><i class="fas fa-calendar"></i> Hier</h3>
                    <span class="day-count">12 notifications</span>
                </div>
                
                <div class="notifications-items">
                    <!-- Notification 4 -->
                    <div class="notification-item" data-type="messages" data-id="4">
                        <div class="notification-icon info">
                            <i class="fas fa-comment"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-header">
                                <h4>Nouveau message</h4>
                                <span class="notification-time">Hier à 14:30</span>
                            </div>
                            <p class="notification-text">
                                <strong>Association Cœur de Lion</strong> vous a envoyé un message concernant votre don récent.
                            </p>
                            <div class="notification-actions">
                                <button class="btn-text view-details" data-id="4">
                                    <i class="fas fa-eye"></i>
                                    Lire le message
                                </button>
                            </div>
                        </div>
                        <div class="notification-actions-right">
                            <button class="btn-icon delete-notification" title="Supprimer" data-id="4">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Notification 5 -->
                    <div class="notification-item" data-type="donations" data-id="5">
                        <div class="notification-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-header">
                                <h4>Recevez nos remerciements !</h4>
                                <span class="notification-time">Hier à 11:15</span>
                            </div>
                            <p class="notification-text">
                                L'association <strong>Espoir Nouveau</strong> vous remercie chaleureusement pour votre soutien continu.
                            </p>
                        </div>
                        <div class="notification-actions-right">
                            <button class="btn-icon delete-notification" title="Supprimer" data-id="5">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cette semaine -->
            <div class="notifications-day">
                <div class="day-header">
                    <h3><i class="fas fa-calendar-week"></i> Cette semaine</h3>
                    <span class="day-count">4 notifications</span>
                </div>
                
                <div class="notifications-items">
                    <!-- Notification 6 -->
                    <div class="notification-item" data-type="system" data-id="6">
                        <div class="notification-icon warning">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-header">
                                <h4>Maintenance prévue</h4>
                                <span class="notification-time">Lundi à 09:00</span>
                            </div>
                            <p class="notification-text">
                                Une maintenance est prévue dimanche prochain de 02h00 à 04h00. La plateforme sera temporairement indisponible.
                            </p>
                        </div>
                        <div class="notification-actions-right">
                            <button class="btn-icon delete-notification" title="Supprimer" data-id="6">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- État vide -->
        <div class="empty-state" id="emptyState" style="display: none;">
            <div class="empty-icon">
                <i class="fas fa-bell-slash"></i>
            </div>
            <h3>Aucune notification</h3>
            <p>Vous n'avez aucune notification pour le moment.</p>
            <button class="btn btn-primary" id="refreshNotifications">
                <i class="fas fa-redo"></i>
                Rafraîchir
            </button>
        </div>

        <!-- Paramètres de notification -->
        <div class="notifications-settings mt-40">
            <div class="section-header">
                <h3><i class="fas fa-cog"></i> Paramètres de notification</h3>
            </div>
            <div class="section-body">
                <div class="settings-grid">
                    <div class="setting-item">
                        <div class="setting-info">
                            <h5>Notifications par email</h5>
                            <p>Recevez les notifications importantes par email</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" id="emailNotifications" checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h5>Notifications push</h5>
                            <p>Recevez des notifications sur votre appareil</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" id="pushNotifications" checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h5>Notifications de dons</h5>
                            <p>Alertes pour les dons et remerciements</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" id="donationNotifications" checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h5>Notifications d'associations</h5>
                            <p>Nouveaux besoins et mises à jour</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" id="associationNotifications" checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h5>Notifications système</h5>
                            <p>Mises à jour et maintenance</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" id="systemNotifications">
                            <span class="slider"></span>
                        </label>
                    </div>
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h5>Notifications de messages</h5>
                            <p>Nouveaux messages des associations</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" id="messageNotifications" checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
                
                <div class="settings-actions">
                    <button class="btn btn-primary" id="saveSettings">
                        <i class="fas fa-save"></i>
                        Sauvegarder les paramètres
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ===== NOTIFICATIONS STYLES ===== */
    .notifications-container {
        padding: 40px 0;
        background: #f8fafc;
        min-height: calc(100vh - 200px);
    }

    /* En-tête */
    .notifications-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-content {
        flex: 1;
    }

    .page-title {
        font-size: 2.5rem;
        color: var(--black);
        margin-bottom: 8px;
        font-weight: 800;
    }

    .page-subtitle {
        color: var(--gray);
        font-size: 1.1rem;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Filtres */
    .notifications-filters {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 20px;
    }

    .filters-row {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 10px;
    }

    .filter-btn {
        padding: 12px 20px;
        background: #f3f4f6;
        border: 2px solid transparent;
        border-radius: var(--border-radius);
        color: #6b7280;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        transition: all 0.3s;
    }

    .filter-btn:hover {
        background: #e5e7eb;
        color: #4b5563;
    }

    .filter-btn.active {
        background: var(--primary-light);
        border-color: var(--primary-color);
        color: var(--primary-dark);
    }

    .filter-btn.active .filter-badge {
        background: var(--primary-color);
        color: white;
    }

    .filter-badge {
        background: #e5e7eb;
        color: #6b7280;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        min-width: 24px;
        text-align: center;
    }

    /* Groupes par jour */
    .notifications-day {
        margin-bottom: 40px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .day-header {
        padding: 20px 25px;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .day-header h3 {
        margin: 0;
        color: #1f2937;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .day-count {
        background: var(--primary-color);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    /* Notifications */
    .notifications-items {
        padding: 0;
    }

    .notification-item {
        display: flex;
        padding: 25px;
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.3s;
        position: relative;
    }

    .notification-item:hover {
        background: #f9fafb;
    }

    .notification-item.unread {
        background: #f0f9ff;
        border-left: 4px solid var(--primary-color);
    }

    .notification-item.unread:hover {
        background: #e0f2fe;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    /* Icônes */
    .notification-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .notification-icon.success {
        background: #d1fae5;
        color: #065f46;
    }

    .notification-icon.primary {
        background: #dbeafe;
        color: #1e40af;
    }

    .notification-icon.warning {
        background: #fef3c7;
        color: #92400e;
    }

    .notification-icon.info {
        background: #e0f2fe;
        color: #0369a1;
    }

    /* Contenu */
    .notification-content {
        flex: 1;
        min-width: 0;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .notification-header h4 {
        margin: 0;
        color: #1f2937;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .notification-time {
        color: #9ca3af;
        font-size: 13px;
        font-weight: 500;
    }

    .notification-text {
        margin: 0 0 15px 0;
        color: #4b5563;
        line-height: 1.5;
    }

    .notification-text strong {
        color: #1f2937;
        font-weight: 600;
    }

    .notification-text em {
        color: #6b7280;
        font-style: italic;
    }

    /* Actions */
    .notification-actions {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .btn-text {
        background: none;
        border: none;
        color: var(--primary-color);
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0;
        transition: color 0.2s;
    }

    .btn-text:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .notification-actions-right {
        margin-left: 15px;
        display: flex;
        align-items: flex-start;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: #f3f4f6;
        color: #9ca3af;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-icon:hover {
        background: #ef4444;
        color: white;
        transform: scale(1.1);
    }

    /* État vide */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .empty-icon {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        margin: 0 0 10px 0;
        color: #6b7280;
    }

    .empty-state p {
        margin: 0 0 25px 0;
        color: #9ca3af;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Paramètres */
    .notifications-settings {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 30px;
    }

    .section-header {
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .section-header h3 {
        margin: 0;
        color: #1f2937;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
    }

    .setting-info {
        flex: 1;
    }

    .setting-info h5 {
        margin: 0 0 8px 0;
        color: #1f2937;
        font-size: 16px;
    }

    .setting-info p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    /* Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: var(--primary-color);
    }

    input:focus + .slider {
        box-shadow: 0 0 1px var(--primary-color);
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .settings-actions {
        text-align: right;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .filters-row {
            flex-wrap: wrap;
        }
        
        .filter-btn {
            flex: 1;
            min-width: 150px;
            justify-content: center;
        }
        
        .notification-item {
            flex-direction: column;
            gap: 15px;
        }
        
        .notification-actions-right {
            position: absolute;
            top: 15px;
            right: 15px;
            margin-left: 0;
        }
        
        .settings-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .notifications-container {
            padding: 20px 0;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .notifications-header {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }
        
        .header-actions {
            justify-content: center;
        }
        
        .notification-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .notification-actions {
            flex-direction: column;
            gap: 10px;
        }
        
        .settings-actions {
            text-align: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtres
    const filterBtns = document.querySelectorAll('.filter-btn');
    const notificationItems = document.querySelectorAll('.notification-item');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Retirer la classe active
            filterBtns.forEach(b => b.classList.remove('active'));
            
            // Ajouter la classe active
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            filterNotifications(filter);
        });
    });
    
    function filterNotifications(filter) {
        let visibleCount = 0;
        
        notificationItems.forEach(item => {
            const type = item.dataset.type;
            const isUnread = item.classList.contains('unread');
            
            switch(filter) {
                case 'all':
                    item.style.display = 'flex';
                    visibleCount++;
                    break;
                    
                case 'unread':
                    item.style.display = isUnread ? 'flex' : 'none';
                    if (isUnread) visibleCount++;
                    break;
                    
                default:
                    item.style.display = type === filter ? 'flex' : 'none';
                    if (type === filter) visibleCount++;
                    break;
            }
        });
        
        // Afficher/masquer l'état vide
        const emptyState = document.getElementById('emptyState');
        if (visibleCount === 0 && filter !== 'all') {
            emptyState.style.display = 'block';
            document.querySelector('.notifications-list').style.display = 'none';
        } else {
            emptyState.style.display = 'none';
            document.querySelector('.notifications-list').style.display = 'block';
        }
    }
    
    // Marquer comme lu
    document.querySelectorAll('.mark-read').forEach(btn => {
        btn.addEventListener('click', function() {
            const notificationId = this.dataset.id;
            const notification = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
            
            if (notification) {
                notification.classList.remove('unread');
                
                // Mettre à jour le compteur
                const unreadBadge = document.querySelector('[data-filter="unread"] .filter-badge');
                let count = parseInt(unreadBadge.textContent);
                if (count > 0) {
                    count--;
                    unreadBadge.textContent = count;
                }
                
                // Cacher le bouton
                this.style.display = 'none';
                
                showNotification('Notification marquée comme lue', 'success');
            }
        });
    });
    
    // Voir les détails
    document.querySelectorAll('.view-details').forEach(btn => {
        btn.addEventListener('click', function() {
            const notificationId = this.dataset.id;
            const notification = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
            const title = notification?.querySelector('h4')?.textContent || 'Détails';
            
            showNotification(`Ouverture des détails: ${title}`, 'info');
            // Ici, tu redirigerais vers la page appropriée
        });
    });
    
    // Supprimer une notification
    document.querySelectorAll('.delete-notification').forEach(btn => {
        btn.addEventListener('click', function() {
            const notificationId = this.dataset.id;
            const notification = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
            
            if (notification && confirm('Supprimer cette notification ?')) {
                // Animation de suppression
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(-100px)';
                
                setTimeout(() => {
                    notification.remove();
                    
                    // Mettre à jour les compteurs
                    updateNotificationCounts();
                    
                    // Vérifier si vide
                    const remaining = document.querySelectorAll('.notification-item').length;
                    if (remaining === 0) {
                        document.getElementById('emptyState').style.display = 'block';
                        document.querySelector('.notifications-list').style.display = 'none';
                    }
                }, 300);
                
                showNotification('Notification supprimée', 'success');
            }
        });
    });
    
    // Tout marquer comme lu
    document.getElementById('markAllRead')?.addEventListener('click', function() {
        if (confirm('Marquer toutes les notifications comme lues ?')) {
            document.querySelectorAll('.notification-item.unread').forEach(item => {
                item.classList.remove('unread');
                item.querySelector('.mark-read')?.style.display = 'none';
            });
            
            // Réinitialiser le compteur
            const unreadBadge = document.querySelector('[data-filter="unread"] .filter-badge');
            unreadBadge.textContent = '0';
            
            showNotification('Toutes les notifications ont été marquées comme lues', 'success');
        }
    });
    
    // Tout supprimer
    document.getElementById('deleteAll')?.addEventListener('click', function() {
        if (confirm('Supprimer toutes les notifications ? Cette action est irréversible.')) {
            document.querySelectorAll('.notification-item').forEach(item => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-100px)';
            });
            
            setTimeout(() => {
                document.querySelector('.notifications-list').innerHTML = '';
                document.getElementById('emptyState').style.display = 'block';
                document.querySelector('.notifications-list').style.display = 'none';
                
                // Réinitialiser tous les compteurs
                document.querySelectorAll('.filter-badge').forEach(badge => {
                    if (badge.textContent !== '0') {
                        badge.textContent = '0';
                    }
                });
                
                // Réinitialiser les compteurs de jours
                document.querySelectorAll('.day-count').forEach(count => {
                    count.textContent = '0 notifications';
                });
            }, 300);
            
            showNotification('Toutes les notifications ont été supprimées', 'success');
        }
    });
    
    // Rafraîchir
    document.getElementById('refreshNotifications')?.addEventListener('click', function() {
        showNotification('Rafraîchissement des notifications...', 'info');
        
        // Simulation de rafraîchissement
        setTimeout(() => {
            location.reload();
        }, 1500);
    });
    
    // Sauvegarder les paramètres
    document.getElementById('saveSettings')?.addEventListener('click', function() {
        const settings = {
            email: document.getElementById('emailNotifications').checked,
            push: document.getElementById('pushNotifications').checked,
            donations: document.getElementById('donationNotifications').checked,
            associations: document.getElementById('associationNotifications').checked,
            system: document.getElementById('systemNotifications').checked,
            messages: document.getElementById('messageNotifications').checked
        };
        
        // Simulation de sauvegarde
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sauvegarde...';
        
        setTimeout(() => {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-save"></i> Sauvegarder les paramètres';
            showNotification('Paramètres de notification sauvegardés', 'success');
        }, 1500);
    });
    
    // Mettre à jour les compteurs
    function updateNotificationCounts() {
        // Compteur total
        const totalCount = document.querySelectorAll('.notification-item').length;
        const totalBadge = document.querySelector('[data-filter="all"] .filter-badge');
        totalBadge.textContent = totalCount;
        
        // Compteur non lues
        const unreadCount = document.querySelectorAll('.notification-item.unread').length;
        const unreadBadge = document.querySelector('[data-filter="unread"] .filter-badge');
        unreadBadge.textContent = unreadCount;
        
        // Compteurs par type
        const types = ['system', 'donations', 'associations', 'messages'];
        types.forEach(type => {
            const count = document.querySelectorAll(`.notification-item[data-type="${type}"]`).length;
            const badge = document.querySelector(`[data-filter="${type}"] .filter-badge`);
            if (badge) {
                badge.textContent = count;
            }
        });
        
        // Mettre à jour les compteurs de jours
        document.querySelectorAll('.notifications-day').forEach(day => {
            const count = day.querySelectorAll('.notification-item').length;
            const dayCount = day.querySelector('.day-count');
            dayCount.textContent = `${count} notification${count > 1 ? 's' : ''}`;
        });
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
});
</script>
@endpush 