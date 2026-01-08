@extends('layouts.admin')

@section('title', 'Paramètres')
@section('page-title', 'Paramètres de la Plateforme')

@section('content')
<div class="settings-container">
    
    <!-- Navigation des paramètres -->
    <div class="settings-nav mb-30">
        <div class="nav-tabs">
            <button class="nav-tab active" data-tab="general">
                <i class="fas fa-cog"></i>
                Général
            </button>
            <button class="nav-tab" data-tab="security">
                <i class="fas fa-shield-alt"></i>
                Sécurité
            </button>
            <button class="nav-tab" data-tab="notifications">
                <i class="fas fa-bell"></i>
                Notifications
            </button>
            <button class="nav-tab" data-tab="payment">
                <i class="fas fa-credit-card"></i>
                Paiements
            </button>
            <button class="nav-tab" data-tab="email">
                <i class="fas fa-envelope"></i>
                Email
            </button>
            <button class="nav-tab" data-tab="maintenance">
                <i class="fas fa-tools"></i>
                Maintenance
            </button>
            <button class="nav-tab" data-tab="advanced">
                <i class="fas fa-sliders-h"></i>
                Avancé
            </button>
        </div>
    </div>

    <!-- Contenu des paramètres -->
    <div class="settings-content">
        
        <!-- Onglet Général -->
        <div class="tab-content active" id="general-tab">
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-info-circle"></i> Informations de la plateforme</h4>
                </div>
                <div class="section-body">
                    <form id="platformInfoForm">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="siteName">Nom du site *</label>
                                <input type="text" id="siteName" class="form-control" value="MainTendue" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="siteSlogan">Slogan</label>
                                <input type="text" id="siteSlogan" class="form-control" value="Donnez c'est changer une vie">
                            </div>
                            
                            <div class="form-group">
                                <label for="siteEmail">Email de contact *</label>
                                <input type="email" id="siteEmail" class="form-control" value="patiencealassani@gmail.com" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="sitePhone">Téléphone</label>
                                <input type="tel" id="sitePhone" class="form-control" value="+228 92719630/99444263">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="siteDescription">Description</label>
                            <textarea id="siteDescription" class="form-control" rows="4">Plateforme de dons et de solidarité connectant donateurs et associations au Togo.</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="siteKeywords">Mots-clés</label>
                            <input type="text" id="siteKeywords" class="form-control" value="dons, solidarité, partage,associations, Togo, aide">
                            <small class="form-text">Séparés par des virgules</small>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-globe"></i> Localisation</h4>
                </div>
                <div class="section-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="timezone">Fuseau horaire</label>
                            <select id="timezone" class="form-control">
                                <option value="Africa/Lome" selected>Afrique/Lomé (GMT+0)</option>
                                <option value="Africa/Abidjan">Afrique/Abidjan</option>
                                <option value="Africa/Accra">Afrique/Accra</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="locale">Langue par défaut</label>
                            <select id="locale" class="form-control">
                                <option value="fr" selected>Français</option>
                                <option value="en">Anglais</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="currency">Devise</label>
                            <select id="currency" class="form-control">
                                <option value="XOF" selected>Franc CFA (XOF)</option>
                                <option value="EUR">Euro (€)</option>
                                <option value="USD">Dollar ($)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-palette"></i> Apparence</h4>
                </div>
                <div class="section-body">
                    <div class="color-picker">
                        <div class="color-option">
                            <label>Couleur primaire</label>
                            <div class="color-preview" style="background: #0ea5e9;"></div>
                            <input type="color" id="primaryColor" value="#0ea5e9">
                        </div>
                        
                        <div class="color-option">
                            <label>Couleur secondaire</label>
                            <div class="color-preview" style="background: #22c55e;"></div>
                            <input type="color" id="secondaryColor" value="#22c55e">
                        </div>
                        
                        <div class="color-option">
                            <label>Couleur d'accent</label>
                            <div class="color-preview" style="background: #f59e0b;"></div>
                            <input type="color" id="accentColor" value="#f59e0b">
                        </div>
                    </div>
                    
                    <div class="logo-upload mt-20">
                        <label>Logo de la plateforme</label>
                        <div class="upload-area" id="logoUpload">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Glissez-déposez votre logo ici</p>
                            <small>PNG, JPG max. 2MB</small>
                            <input type="file" id="logoFile" accept="image/*" hidden>
                        </div>
                        <div class="logo-preview" id="logoPreview">
                            <img src="{{ asset('assets/images/logos/MainTendue.png') }}" alt="Logo actuel">
                            <button class="btn-remove-logo">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Onglet Sécurité -->
        <div class="tab-content" id="security-tab">
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-lock"></i> Authentification</h4>
                </div>
                <div class="section-body">
                    <div class="security-settings">
                        <div class="security-item">
                            <div class="security-info">
                                <h5>Authentification à deux facteurs (2FA)</h5>
                                <p>Exige une vérification supplémentaire pour les connexions administrateur</p>
                            </div>
                            <div class="security-switch">
                                <label class="switch">
                                    <input type="checkbox" id="enable2FA">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="security-item">
                            <div class="security-info">
                                <h5>Verrouillage après échecs</h5>
                                <p>Verrouille le compte après 5 tentatives de connexion échouées</p>
                            </div>
                            <div class="security-switch">
                                <label class="switch">
                                    <input type="checkbox" id="enableLockout" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="security-item">
                            <div class="security-info">
                                <h5>Sessions simultanées</h5>
                                <p>Limite à 3 sessions simultanées par utilisateur</p>
                            </div>
                            <div class="security-switch">
                                <label class="switch">
                                    <input type="checkbox" id="limitSessions" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="security-item">
                            <div class="security-info">
                                <h5>Durée de session</h5>
                                <div class="session-duration">
                                    <input type="range" id="sessionDuration" min="1" max="24" value="2">
                                    <span id="durationValue">2 heures</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="security-item">
                            <div class="security-info">
                                <h5>Exiger un mot de passe fort</h5>
                                <p>Minimum 8 caractères avec majuscules, minuscules et chiffres</p>
                            </div>
                            <div class="security-switch">
                                <label class="switch">
                                    <input type="checkbox" id="requireStrongPassword" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Appliquer les changements
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-user-shield"></i> Rôles et permissions</h4>
                </div>
                <div class="section-body">
                    <div class="permissions-grid">
                        <div class="permission-card">
                            <h5>Administrateur</h5>
                            <ul class="permission-list">
                                <li><i class="fas fa-check"></i> Accès complet</li>
                                <li><i class="fas fa-check"></i> Gestion utilisateurs</li>
                                <li><i class="fas fa-check"></i> Gestion associations</li>
                                <li><i class="fas fa-check"></i> Modération</li>
                                <li><i class="fas fa-check"></i> Configuration</li>
                            </ul>
                        </div>
                        
                        <div class="permission-card">
                            <h5>Association</h5>
                            <ul class="permission-list">
                                <li><i class="fas fa-check"></i> Gestion profil</li>
                                <li><i class="fas fa-check"></i> Recevoir des dons</li>
                                <li><i class="fas fa-check"></i> Publier besoins</li>
                                <li><i class="fas fa-times"></i> Modération</li>
                                <li><i class="fas fa-times"></i> Configuration</li>
                            </ul>
                        </div>
                        
                        <div class="permission-card">
                            <h5>Donateur</h5>
                            <ul class="permission-list">
                                <li><i class="fas fa-check"></i> Faire des dons</li>
                                <li><i class="fas fa-check"></i> Historique dons</li>
                                <li><i class="fas fa-times"></i> Recevoir dons</li>
                                <li><i class="fas fa-times"></i> Modération</li>
                                <li><i class="fas fa-times"></i> Configuration</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button class="btn btn-outline">
                            <i class="fas fa-edit"></i>
                            Modifier les permissions
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Onglet Notifications -->
        <div class="tab-content" id="notifications-tab">
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-bell"></i> Paramètres de notification</h4>
                </div>
                <div class="section-body">
                    <div class="notifications-grid">
                        <div class="notification-category">
                            <h5>Email</h5>
                            <div class="notification-item">
                                <label>Nouveaux utilisateurs</label>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="notification-item">
                                <label>Nouvelles associations</label>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="notification-item">
                                <label>Signalements</label>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="notification-category">
                            <h5>Dashboard</h5>
                            <div class="notification-item">
                                <label>Statistiques quotidiennes</label>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="notification-item">
                                <label>Alertes critiques</label>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="notification-item">
                                <label>Mises à jour système</label>
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="notification-category">
                            <h5>Mobile (Push)</h5>
                            <div class="notification-item">
                                <label>Notifications push</label>
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="notification-item">
                                <label>Alertes urgentes</label>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Sauvegarder les préférences
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Onglet Paiements -->
        <div class="tab-content" id="payment-tab">
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-credit-card"></i> Passerelles de paiement</h4>
                </div>
                <div class="section-body">
                    <div class="payment-methods">
                        <div class="payment-method">
                            <div class="method-header">
                                <div class="method-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div class="method-info">
                                    <h5>Mobile Money (Mixx by yas, Moov)</h5>
                                    <p>Paiements mobiles locaux</p>
                                </div>
                                <div class="method-switch">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="method-config">
                                <div class="form-group">
                                    <label>Clé API Wave</label>
                                    <input type="password" class="form-control" placeholder="••••••••••••">
                                </div>
                                <div class="form-group">
                                    <label>Clé API Moov</label>
                                    <input type="password" class="form-control" placeholder="••••••••••••">
                                </div>
                            </div>
                        </div>
                        
                        <div class="payment-method">
                            <div class="method-header">
                                <div class="method-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="method-info">
                                    <h5>Carte bancaire</h5>
                                    <p>Visa, Mastercard</p>
                                </div>
                                <div class="method-switch">
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="payment-method">
                            <div class="method-header">
                                <div class="method-icon">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="method-info">
                                    <h5>Virement bancaire</h5>
                                    <p>Transfert direct</p>
                                </div>
                                <div class="method-switch">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="method-config">
                                <div class="form-group">
                                    <label>IBAN</label>
                                    <input type="text" class="form-control" value="TG53 TG06 6010 1234 5678 9012 3456">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="payment-settings">
                        <div class="form-group">
                            <label>Frais de transaction (%)</label>
                            <input type="number" class="form-control" min="0" max="10" step="0.1" value="2.5">
                        </div>
                        
                        <div class="form-group">
                            <label>Montant minimum de don</label>
                            <input type="number" class="form-control" min="1" value="1">
                        </div>
                        
                        <div class="form-group">
                            <label>Devise par défaut</label>
                            <select class="form-control">
                                <option value="XOF" selected>Franc CFA (XOF)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Mettre à jour
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Onglet Email -->
        <div class="tab-content" id="email-tab">
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-envelope"></i> Configuration SMTP</h4>
                </div>
                <div class="section-body">
                    <form id="smtpForm">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="smtpHost">Serveur SMTP</label>
                                <input type="text" id="smtpHost" class="form-control" value="smtp.gmail.com">
                            </div>
                            
                            <div class="form-group">
                                <label for="smtpPort">Port</label>
                                <input type="number" id="smtpPort" class="form-control" value="587">
                            </div>
                            
                            <div class="form-group">
                                <label for="smtpUsername">Nom d'utilisateur</label>
                                <input type="text" id="smtpUsername" class="form-control" value="contact@maintendue.tg">
                            </div>
                            
                            <div class="form-group">
                                <label for="smtpPassword">Mot de passe</label>
                                <input type="password" id="smtpPassword" class="form-control" placeholder="••••••••">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="smtpEncryption">Chiffrement</label>
                            <select id="smtpEncryption" class="form-control">
                                <option value="tls" selected>TLS</option>
                                <option value="ssl">SSL</option>
                                <option value="">Aucun</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="fromEmail">Email expéditeur</label>
                            <input type="email" id="fromEmail" class="form-control" value="noreply@maintendue.tg">
                        </div>
                        
                        <div class="form-group">
                            <label for="fromName">Nom expéditeur</label>
                            <input type="text" id="fromName" class="form-control" value="MAIN TENDUE">
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-outline" id="testSmtp">
                                <i class="fas fa-vial"></i>
                                Tester la connexion
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Sauvegarder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-mail-bulk"></i> Templates d'email</h4>
                </div>
                <div class="section-body">
                    <div class="email-templates">
                        <div class="template-item">
                            <div class="template-info">
                                <h5>Bienvenue</h5>
                                <p>Email envoyé aux nouveaux utilisateurs</p>
                            </div>
                            <button class="btn btn-outline btn-sm">
                                <i class="fas fa-edit"></i>
                                Modifier
                            </button>
                        </div>
                        
                        <div class="template-item">
                            <div class="template-info">
                                <h5>Confirmation de don</h5>
                                <p>Reçu envoyé après un don</p>
                            </div>
                            <button class="btn btn-outline btn-sm">
                                <i class="fas fa-edit"></i>
                                Modifier
                            </button>
                        </div>
                        
                        <div class="template-item">
                            <div class="template-info">
                                <h5>Récupération mot de passe</h5>
                                <p>Email de réinitialisation</p>
                            </div>
                            <button class="btn btn-outline btn-sm">
                                <i class="fas fa-edit"></i>
                                Modifier
                            </button>
                        </div>
                        
                        <div class="template-item">
                            <div class="template-info">
                                <h5>Validation association</h5>
                                <p>Notification de validation</p>
                            </div>
                            <button class="btn btn-outline btn-sm">
                                <i class="fas fa-edit"></i>
                                Modifier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Onglet Maintenance -->
        <div class="tab-content" id="maintenance-tab">
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-tools"></i> Mode maintenance</h4>
                </div>
                <div class="section-body">
                    <div class="maintenance-status">
                        <div class="status-info">
                            <div class="status-indicator active"></div>
                            <div>
                                <h5>Plateforme en ligne</h5>
                                <p>Tous les services sont opérationnels</p>
                            </div>
                        </div>
                        
                        <div class="maintenance-switch">
                            <label class="switch large">
                                <input type="checkbox" id="maintenanceMode">
                                <span class="slider"></span>
                            </label>
                            <span class="switch-label">Activer le mode maintenance</span>
                        </div>
                    </div>
                    
                    <div class="maintenance-settings" id="maintenanceSettings" style="display: none;">
                        <div class="form-group">
                            <label for="maintenanceMessage">Message de maintenance</label>
                            <textarea id="maintenanceMessage" class="form-control" rows="4" placeholder="La plateforme est actuellement en maintenance. Merci de votre patience."></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="maintenanceEnd">Date de fin estimée</label>
                            <input type="datetime-local" id="maintenanceEnd" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Accès autorisés</label>
                            <div class="access-list">
                                <label class="checkbox">
                                    <input type="checkbox" checked>
                                    <span>Administrateurs</span>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox">
                                    <span>Associations</span>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox">
                                    <span>Donateurs</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button class="btn btn-primary" id="saveMaintenance">
                            <i class="fas fa-save"></i>
                            Appliquer
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-database"></i> Sauvegarde</h4>
                </div>
                <div class="section-body">
                    <div class="backup-info">
                        <div class="backup-item">
                            <i class="fas fa-database"></i>
                            <div>
                                <h5>Dernière sauvegarde</h5>
                                <p>Il y a 12 heures</p>
                            </div>
                        </div>
                        
                        <div class="backup-item">
                            <i class="fas fa-hdd"></i>
                            <div>
                                <h5>Taille de la base</h5>
                                <p>245 MB</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="backup-actions">
                        <button class="btn btn-outline" id="backupNow">
                            <i class="fas fa-save"></i>
                            Sauvegarder maintenant
                        </button>
                        
                        <button class="btn btn-outline" id="restoreBackup">
                            <i class="fas fa-history"></i>
                            Restaurer
                        </button>
                        
                        <button class="btn btn-outline" id="downloadBackup">
                            <i class="fas fa-download"></i>
                            Télécharger
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Onglet Avancé -->
        <div class="tab-content" id="advanced-tab">
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-code"></i> API & Intégrations</h4>
                </div>
                <div class="section-body">
                    <div class="api-settings">
                        <div class="form-group">
                            <label>Clé API principale</label>
                            <div class="api-key-display">
                                <code id="apiKey">sk_live_123456789abcdef</code>
                                <button class="btn-icon" id="copyApiKey">
                                    <i class="fas fa-copy"></i>
                                </button>
                                <button class="btn-icon" id="regenerateApiKey">
                                    <i class="fas fa-redo"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>URL de webhook</label>
                            <input type="url" class="form-control" value="https://api.maintendue.tg/webhook">
                        </div>
                        
                        <div class="form-group">
                            <label>Logs API</label>
                            <select class="form-control">
                                <option value="none">Aucun</option>
                                <option value="errors" selected>Erreurs seulement</option>
                                <option value="all">Toutes les requêtes</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Mettre à jour
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="settings-section">
                <div class="section-header">
                    <h4><i class="fas fa-bug"></i> Débogage</h4>
                </div>
                <div class="section-body">
                    <div class="debug-settings">
                        <div class="debug-item">
                            <div class="debug-info">
                                <h5>Mode développement</h5>
                                <p>Affiche les erreurs détaillées (désactiver en production)</p>
                            </div>
                            <div class="debug-switch">
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="debug-item">
                            <div class="debug-info">
                                <h5>Logs d'erreur</h5>
                                <p>Enregistre toutes les erreurs dans un fichier</p>
                            </div>
                            <div class="debug-switch">
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="debug-item">
                            <div class="debug-info">
                                <h5>Cache</h5>
                                <p>Vider le cache de l'application</p>
                            </div>
                            <button class="btn btn-outline btn-sm" id="clearCache">
                                <i class="fas fa-broom"></i>
                                Vider le cache
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    /* ===== SETTINGS STYLES ===== */
    .settings-container {
        padding: 20px;
    }

    /* Navigation */
    .settings-nav {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 20px;
        margin-bottom: 30px;
        overflow-x: auto;
    }

    .nav-tabs {
        display: flex;
        gap: 5px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 20px;
    }

    .nav-tab {
        padding: 15px 25px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        color: #6b7280;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
        transition: all 0.3s;
    }

    .nav-tab:hover {
        color: var(--primary-color);
    }

    .nav-tab.active {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
        background: linear-gradient(to bottom, rgba(59, 130, 246, 0.05), transparent);
    }

    /* Contenu */
    .settings-content {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 30px;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Sections */
    .settings-section {
        margin-bottom: 40px;
        padding-bottom: 40px;
        border-bottom: 1px solid #e5e7eb;
    }

    .settings-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .section-header {
        margin-bottom: 25px;
    }

    .section-header h4 {
        color: #1f2937;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Formulaires */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
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
        padding: 12px 15px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius-sm);
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-text {
        display: block;
        margin-top: 6px;
        color: #9ca3af;
        font-size: 12px;
    }

    .form-actions {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
    }

    /* Sélecteur de couleurs */
    .color-picker {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .color-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .color-option label {
        font-weight: 600;
        color: #4b5563;
        font-size: 14px;
    }

    .color-preview {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        border: 3px solid white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .color-option input[type="color"] {
        width: 60px;
        height: 40px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    /* Upload de logo */
    .logo-upload {
        margin-bottom: 30px;
    }

    .upload-area {
        border: 2px dashed #d1d5db;
        border-radius: var(--border-radius);
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        margin-bottom: 20px;
    }

    .upload-area:hover {
        border-color: var(--primary-color);
        background: #f8fafc;
    }

    .upload-area i {
        font-size: 48px;
        color: #9ca3af;
        margin-bottom: 15px;
    }

    .upload-area p {
        margin: 0 0 10px 0;
        color: #4b5563;
        font-weight: 600;
    }

    .upload-area small {
        color: #9ca3af;
    }

    .logo-preview {
        position: relative;
        display: inline-block;
        margin-top: 20px;
    }

    .logo-preview img {
        max-width: 200px;
        max-height: 100px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        padding: 10px;
        background: white;
    }

    .btn-remove-logo {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 30px;
        height: 30px;
        background: #ef4444;
        border: none;
        border-radius: 50%;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    /* Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch.large {
        width: 80px;
        height: 44px;
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

    .switch.large .slider:before {
        height: 36px;
        width: 36px;
        left: 4px;
        bottom: 4px;
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

    .switch.large input:checked + .slider:before {
        transform: translateX(36px);
    }

    /* Sécurité */
    .security-settings, .debug-settings {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .security-item, .debug-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: #f9fafb;
        border-radius: var(--border-radius);
        border: 1px solid #e5e7eb;
    }

    .security-info, .debug-info {
        flex: 1;
    }

    .security-info h5, .debug-info h5 {
        margin: 0 0 8px 0;
        color: #1f2937;
        font-size: 16px;
    }

    .security-info p, .debug-info p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .session-duration {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .session-duration input {
        flex: 1;
    }

    #durationValue {
        min-width: 60px;
        font-weight: 600;
        color: var(--primary-color);
    }

    /* Permissions */
    .permissions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .permission-card {
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
        background: #f8fafc;
    }

    .permission-card h5 {
        margin: 0 0 15px 0;
        color: #1f2937;
        font-size: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e7eb;
    }

    .permission-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .permission-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        color: #4b5563;
        font-size: 14px;
    }

    .permission-list li i.fa-check {
        color: #10b981;
    }

    .permission-list li i.fa-times {
        color: #ef4444;
    }

    /* Notifications */
    .notifications-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .notification-category {
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
        background: #f8fafc;
    }

    .notification-category h5 {
        margin: 0 0 20px 0;
        color: #1f2937;
        font-size: 16px;
    }

    .notification-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item label:first-child {
        font-weight: 500;
        color: #4b5563;
    }

    .notification-item .switch {
        width: 50px;
        height: 26px;
    }

    .notification-item .slider:before {
        height: 18px;
        width: 18px;
    }

    /* Paiements */
    .payment-methods {
        margin-bottom: 30px;
    }

    .payment-method {
        margin-bottom: 20px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .method-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }

    .method-icon {
        width: 50px;
        height: 50px;
        background: var(--primary-light);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 24px;
    }

    .method-info {
        flex: 1;
    }

    .method-info h5 {
        margin: 0 0 5px 0;
        color: #1f2937;
        font-size: 16px;
    }

    .method-info p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .method-config {
        padding: 20px;
        background: white;
        display: none;
    }

    .method-switch {
        min-width: 60px;
    }

    .payment-settings {
        background: #f9fafb;
        padding: 20px;
        border-radius: var(--border-radius);
        margin-bottom: 30px;
    }

    /* Email templates */
    .email-templates {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .template-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
    }

    .template-info h5 {
        margin: 0 0 5px 0;
        color: #1f2937;
        font-size: 16px;
    }

    .template-info p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    /* Maintenance */
    .maintenance-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: var(--border-radius);
        margin-bottom: 20px;
    }

    .status-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #22c55e;
    }

    .status-indicator.active {
        background: #22c55e;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .status-info h5 {
        margin: 0 0 5px 0;
        color: #166534;
    }

    .status-info p {
        margin: 0;
        color: #15803d;
        font-size: 14px;
    }

    .maintenance-switch {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .switch-label {
        font-weight: 600;
        color: #4b5563;
    }

    .maintenance-settings {
        padding: 20px;
        background: #f8fafc;
        border-radius: var(--border-radius);
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
    }

    .access-list {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .checkbox input {
        width: 18px;
        height: 18px;
    }

    .checkbox span {
        color: #4b5563;
        font-size: 14px;
    }

    /* Sauvegarde */
    .backup-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .backup-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
    }

    .backup-item i {
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

    .backup-item h5 {
        margin: 0 0 5px 0;
        color: #1f2937;
        font-size: 16px;
    }

    .backup-item p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .backup-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* API */
    .api-key-display {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px;
        background: #1f2937;
        border-radius: var(--border-radius);
        margin-top: 10px;
    }

    .api-key-display code {
        flex: 1;
        color: #10b981;
        font-family: monospace;
        font-size: 14px;
        word-break: break-all;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: #374151;
        color: #9ca3af;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-icon:hover {
        background: #4b5563;
        color: white;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .nav-tabs {
            flex-wrap: wrap;
        }
        
        .nav-tab {
            flex: 1;
            min-width: 150px;
            justify-content: center;
        }
        
        .security-item, .debug-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .security-switch, .debug-switch {
            align-self: flex-end;
        }
        
        .maintenance-status {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .color-picker {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .permissions-grid, .notifications-grid {
            grid-template-columns: 1fr;
        }
        
        .payment-method .method-header {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
        
        .method-switch {
            align-self: center;
        }
        
        .backup-actions {
            flex-direction: column;
        }
        
        .backup-actions .btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Navigation des onglets
    const navTabs = document.querySelectorAll('.nav-tab');
    const tabContents = document.querySelectorAll('.tab-content');
    
    navTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Retirer la classe active
            navTabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Ajouter la classe active
            this.classList.add('active');
            const tabId = this.dataset.tab;
            document.getElementById(`${tabId}-tab`).classList.add('active');
        });
    });
    
    // Gestion de l'upload de logo
    const logoUpload = document.getElementById('logoUpload');
    const logoFile = document.getElementById('logoFile');
    const logoPreview = document.getElementById('logoPreview');
    
    logoUpload.addEventListener('click', function() {
        logoFile.click();
    });
    
    logoUpload.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = var('--primary-color');
        this.style.backgroundColor = '#f0f9ff';
    });
    
    logoUpload.addEventListener('dragleave', function() {
        this.style.borderColor = '#d1d5db';
        this.style.backgroundColor = '';
    });
    
    logoUpload.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = '#d1d5db';
        this.style.backgroundColor = '';
        
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            handleLogoUpload(file);
        } else {
            showNotification('Veuillez sélectionner une image valide', 'warning');
        }
    });
    
    logoFile.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleLogoUpload(file);
        }
    });
    
    function handleLogoUpload(file) {
        if (file.size > 2 * 1024 * 1024) {
            showNotification('L\'image est trop volumineuse (max 2MB)', 'warning');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = logoPreview.querySelector('img');
            img.src = e.target.result;
            showNotification('Logo téléchargé avec succès', 'success');
        };
        reader.readAsDataURL(file);
    }
    
    // Supprimer le logo
    logoPreview.querySelector('.btn-remove-logo').addEventListener('click', function(e) {
        e.stopPropagation();
        const img = logoPreview.querySelector('img');
        img.src = '{{ asset("assets/images/logos/MainTendue.png") }}';
        logoFile.value = '';
        showNotification('Logo réinitialisé', 'info');
    });
    
    // Durée de session
    const sessionSlider = document.getElementById('sessionDuration');
    const durationValue = document.getElementById('durationValue');
    
    if (sessionSlider && durationValue) {
        sessionSlider.addEventListener('input', function() {
            durationValue.textContent = `${this.value} heure${this.value > 1 ? 's' : ''}`;
        });
    }
    
    // Mode maintenance
    const maintenanceMode = document.getElementById('maintenanceMode');
    const maintenanceSettings = document.getElementById('maintenanceSettings');
    
    if (maintenanceMode) {
        maintenanceMode.addEventListener('change', function() {
            if (this.checked) {
                maintenanceSettings.style.display = 'block';
                showNotification('Mode maintenance activé. Les paramètres sont maintenant modifiables.', 'warning');
            } else {
                maintenanceSettings.style.display = 'none';
                showNotification('Mode maintenance désactivé', 'success');
            }
        });
    }
    
    // Sauvegarde
    document.getElementById('backupNow')?.addEventListener('click', function() {
        showNotification('Sauvegarde en cours...', 'info');
        // Simulation de sauvegarde
        setTimeout(() => {
            showNotification('Sauvegarde terminée avec succès', 'success');
        }, 2000);
    });
    
    document.getElementById('restoreBackup')?.addEventListener('click', function() {
        if (confirm('Êtes-vous sûr de vouloir restaurer la dernière sauvegarde ?')) {
            showNotification('Restauration en cours...', 'info');
            setTimeout(() => {
                showNotification('Restauration terminée', 'success');
            }, 2000);
        }
    });
    
    document.getElementById('downloadBackup')?.addEventListener('click', function() {
        showNotification('Téléchargement de la sauvegarde...', 'info');
        setTimeout(() => {
            showNotification('Sauvegarde téléchargée', 'success');
        }, 1500);
    });
    
    // API Key
    document.getElementById('copyApiKey')?.addEventListener('click', function() {
        const apiKey = document.getElementById('apiKey').textContent;
        navigator.clipboard.writeText(apiKey).then(() => {
            showNotification('Clé API copiée dans le presse-papier', 'success');
        });
    });
    
    document.getElementById('regenerateApiKey')?.addEventListener('click', function() {
        if (confirm('Générer une nouvelle clé API ? Les anciennes clés seront invalidées.')) {
            const newKey = 'sk_live_' + Math.random().toString(36).substring(2) + Math.random().toString(36).substring(2);
            document.getElementById('apiKey').textContent = newKey;
            showNotification('Nouvelle clé API générée', 'success');
        }
    });
    
    // Vider le cache
    document.getElementById('clearCache')?.addEventListener('click', function() {
        if (confirm('Vider le cache de l\'application ?')) {
            showNotification('Cache vidé avec succès', 'success');
        }
    });
    
    // Tester SMTP
    document.getElementById('testSmtp')?.addEventListener('click', function() {
        showNotification('Test de connexion SMTP en cours...', 'info');
        setTimeout(() => {
            showNotification('Connexion SMTP réussie !', 'success');
        }, 2000);
    });
    
    // Gestion des formulaires
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            showNotification('Paramètres sauvegardés avec succès', 'success');
        });
    });
    
    // Gestion des méthodes de paiement
    document.querySelectorAll('.method-switch input').forEach(switchEl => {
        switchEl.addEventListener('change', function() {
            const methodConfig = this.closest('.payment-method').querySelector('.method-config');
            if (methodConfig) {
                methodConfig.style.display = this.checked ? 'block' : 'none';
            }
        });
    });
    
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