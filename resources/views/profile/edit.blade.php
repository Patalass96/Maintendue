@extends('layouts.app')

@section('title', 'Modifier mon profil - MAIN TENDUE')

@section('content')
<div class="profile-edit-container">
    <div class="container">
        <!-- En-tête du profil -->
        <div class="profile-header mb-30">
            <div class="back-button">
                <a href="{{ route('profile.show') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    Retour au profil
                </a>
            </div>
            <h1 class="profile-title">Modifier mon profil</h1>
            <p class="profile-subtitle">Mettez à jour vos informations personnelles</p>
        </div>

        <!-- Navigation des sections -->
        <div class="profile-nav mb-30">
            <div class="nav-tabs">
                <button class="nav-tab active" data-tab="personal">
                    <i class="fas fa-user"></i>
                    Informations personnelles
                </button>
                <button class="nav-tab" data-tab="security">
                    <i class="fas fa-lock"></i>
                    Sécurité
                </button>
                <button class="nav-tab" data-tab="preferences">
                    <i class="fas fa-sliders-h"></i>
                    Préférences
                </button>
                @if(Auth::user()->role === 'association')
                <button class="nav-tab" data-tab="association">
                    <i class="fas fa-hands-helping"></i>
                    Informations association
                </button>
                @endif
            </div>
        </div>

        <!-- Formulaire d'édition -->
        <div class="profile-edit-form">
            <!-- Informations personnelles -->
            <div class="tab-content active" id="personal-tab">
                <form id="personalForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-user-circle"></i> Photo de profil</h3>
                        </div>
                        <div class="section-body">
                            <div class="avatar-upload">
                                <div class="avatar-preview">
                                    <div class="avatar-image" id="avatarPreview">
                                        @if(Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
                                        @else
                                            <div class="avatar-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="avatar-actions">
                                        <button type="button" class="btn btn-outline btn-sm" id="changeAvatar">
                                            <i class="fas fa-camera"></i>
                                            Changer
                                        </button>
                                        @if(Auth::user()->avatar)
                                        <button type="button" class="btn btn-outline btn-sm btn-danger" id="removeAvatar">
                                            <i class="fas fa-trash"></i>
                                            Supprimer
                                        </button>
                                        @endif
                                    </div>
                                    <input type="file" id="avatarInput" name="avatar" accept="image/*" hidden>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-address-card"></i> Informations de base</h3>
                        </div>
                        <div class="section-body">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="first_name">Prénom *</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" 
                                           value="{{ old('first_name', Auth::user()->first_name) }}" required>
                                    @error('first_name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="last_name">Nom *</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control" 
                                           value="{{ old('last_name', Auth::user()->last_name) }}" required>
                                    @error('last_name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Adresse email *</label>
                                    <input type="email" id="email" name="email" class="form-control" 
                                           value="{{ old('email', Auth::user()->email) }}" required>
                                    @error('email')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="phone">Téléphone</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" 
                                           value="{{ old('phone', Auth::user()->phone) }}" 
                                           placeholder="+228 XX XX XX XX">
                                    @error('phone')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-map-marker-alt"></i> Localisation</h3>
                        </div>
                        <div class="section-body">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="city">Ville</label>
                                    <select id="city" name="city" class="form-control">
                                        <option value="">Sélectionnez une ville</option>
                                        <option value="Lomé" {{ old('city', Auth::user()->city) == 'Lomé' ? 'selected' : '' }}>Lomé</option>
                                        <option value="Kara" {{ old('city', Auth::user()->city) == 'Kara' ? 'selected' : '' }}>Kara</option>
                                        <option value="Sokodé" {{ old('city', Auth::user()->city) == 'Sokodé' ? 'selected' : '' }}>Sokodé</option>
                                        <option value="Atakpamé" {{ old('city', Auth::user()->city) == 'Atakpamé' ? 'selected' : '' }}>Atakpamé</option>
                                        <option value="Dapaong" {{ old('city', Auth::user()->city) == 'Dapaong' ? 'selected' : '' }}>Dapaong</option>
                                        <option value="Tsévié" {{ old('city', Auth::user()->city) == 'Tsévié' ? 'selected' : '' }}>Tsévié</option>
                                        <option value="Aného" {{ old('city', Auth::user()->city) == 'Aného' ? 'selected' : '' }}>Aného</option>
                                        <option value="Bassar" {{ old('city', Auth::user()->city) == 'Bassar' ? 'selected' : '' }}>Bassar</option>
                                        <option value="Mango" {{ old('city', Auth::user()->city) == 'Mango' ? 'selected' : '' }}>Mango</option>
                                    </select>
                                    @error('city')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="address">Adresse</label>
                                    <input type="text" id="address" name="address" class="form-control" 
                                           value="{{ old('address', Auth::user()->address) }}" 
                                           placeholder="Rue, quartier...">
                                    @error('address')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->role === 'donor')
                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-heart"></i> Centres d'intérêt</h3>
                        </div>
                        <div class="section-body">
                            <div class="interests-grid">
                                @php
                                    $categories = ['Éducation', 'Santé', 'Environnement', 'Social', 'Urgence', 'Culture'];
                                    $userInterests = json_decode(Auth::user()->interests ?? '[]', true);
                                @endphp
                                
                                @foreach($categories as $category)
                                <label class="interest-checkbox">
                                    <input type="checkbox" name="interests[]" value="{{ $category }}" 
                                           {{ in_array($category, $userInterests) ? 'checked' : '' }}>
                                    <span class="interest-label">{{ $category }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-align-left"></i> À propos</h3>
                        </div>
                        <div class="section-body">
                            <div class="form-group">
                                <label for="bio">Biographie</label>
                                <textarea id="bio" name="bio" class="form-control" rows="4" 
                                          placeholder="Parlez-nous de vous...">{{ old('bio', Auth::user()->bio) }}</textarea>
                                <small class="form-text">Maximum 500 caractères</small>
                                @error('bio')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" id="cancelEdit">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sécurité -->
            <div class="tab-content" id="security-tab">
                <form id="securityForm" method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-key"></i> Changer le mot de passe</h3>
                        </div>
                        <div class="section-body">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="current_password">Mot de passe actuel *</label>
                                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                                    @error('current_password')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="new_password">Nouveau mot de passe *</label>
                                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                                    <div class="password-strength">
                                        <div class="strength-bar"></div>
                                        <span class="strength-text">Faible</span>
                                    </div>
                                    <small class="form-text">Minimum 8 caractères avec chiffres et lettres</small>
                                    @error('new_password')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="new_password_confirmation">Confirmer le mot de passe *</label>
                                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                                    @error('new_password_confirmation')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-shield-alt"></i> Sécurité du compte</h3>
                        </div>
                        <div class="section-body">
                            <div class="security-settings">
                                <div class="security-item">
                                    <div class="security-info">
                                        <h5>Authentification à deux facteurs</h5>
                                        <p>Ajoute une couche de sécurité supplémentaire à votre compte</p>
                                    </div>
                                    <div class="security-switch">
                                        <label class="switch">
                                            <input type="checkbox" id="enable2FA" name="two_factor_auth">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="security-item">
                                    <div class="security-info">
                                        <h5>Sessions actives</h5>
                                        <p>Gérez vos sessions de connexion sur d'autres appareils</p>
                                    </div>
                                    <button type="button" class="btn btn-outline btn-sm" id="viewSessions">
                                        Voir les sessions
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Mettre à jour la sécurité
                        </button>
                    </div>
                </form>
            </div>

            <!-- Préférences -->
            <div class="tab-content" id="preferences-tab">
                <form id="preferencesForm" method="POST" action="{{ route('profile.preferences') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-bell"></i> Notifications</h3>
                        </div>
                        <div class="section-body">
                            <div class="notifications-settings">
                                <div class="notification-category">
                                    <h5>Email</h5>
                                    <div class="notification-item">
                                        <label>Nouvelles opportunités de dons</label>
                                        <label class="switch">
                                            <input type="checkbox" name="notifications[email][opportunities]" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="notification-item">
                                        <label>Messages des associations</label>
                                        <label class="switch">
                                            <input type="checkbox" name="notifications[email][messages]" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="notification-item">
                                        <label>Newsletter mensuelle</label>
                                        <label class="switch">
                                            <input type="checkbox" name="notifications[email][newsletter]">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="notification-category">
                                    <h5>Notifications push</h5>
                                    <div class="notification-item">
                                        <label>Alertes importantes</label>
                                        <label class="switch">
                                            <input type="checkbox" name="notifications[push][alerts]" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="notification-item">
                                        <label>Rappels de dons</label>
                                        <label class="switch">
                                            <input type="checkbox" name="notifications[push][reminders]">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-eye"></i> Confidentialité</h3>
                        </div>
                        <div class="section-body">
                            <div class="privacy-settings">
                                <div class="privacy-item">
                                    <div class="privacy-info">
                                        <h5>Profil public</h5>
                                        <p>Rendre mon profil visible par les autres utilisateurs</p>
                                    </div>
                                    <div class="privacy-switch">
                                        <label class="switch">
                                            <input type="checkbox" name="privacy[public_profile]" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="privacy-item">
                                    <div class="privacy-info">
                                        <h5>Historique de dons privé</h5>
                                        <p>Masquer mes dons passés</p>
                                    </div>
                                    <div class="privacy-switch">
                                        <label class="switch">
                                            <input type="checkbox" name="privacy[private_donations]">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="privacy-item">
                                    <div class="privacy-info">
                                        <h5>Recherche par email</h5>
                                        <p>Permettre aux autres de me trouver par email</p>
                                    </div>
                                    <div class="privacy-switch">
                                        <label class="switch">
                                            <input type="checkbox" name="privacy[search_by_email]" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-language"></i> Langue et région</h3>
                        </div>
                        <div class="section-body">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="language">Langue préférée</label>
                                    <select id="language" name="language" class="form-control">
                                        <option value="fr" selected>Français</option>
                                        <option value="en">English</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="timezone">Fuseau horaire</label>
                                    <select id="timezone" name="timezone" class="form-control">
                                        <option value="Africa/Lome" selected>Afrique/Lomé (GMT+0)</option>
                                        <option value="Africa/Abidjan">Afrique/Abidjan</option>
                                        <option value="Africa/Accra">Afrique/Accra</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Sauvegarder les préférences
                        </button>
                    </div>
                </form>
            </div>

            <!-- Informations association (seulement pour les associations) -->
            @if(Auth::user()->role === 'association')
            <div class="tab-content" id="association-tab">
                <form id="associationForm" method="POST" action="{{ route('profile.association') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-info-circle"></i> Informations de l'association</h3>
                        </div>
                        <div class="section-body">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="association_name">Nom officiel *</label>
                                    <input type="text" id="association_name" name="association_name" class="form-control" 
                                           value="{{ old('association_name', Auth::user()->association_name) }}" required>
                                    @error('association_name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="association_acronym">Sigle</label>
                                    <input type="text" id="association_acronym" name="association_acronym" class="form-control" 
                                           value="{{ old('association_acronym', Auth::user()->association_acronym) }}">
                                    @error('association_acronym')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="association_description">Description de l'association *</label>
                                <textarea id="association_description" name="association_description" class="form-control" rows="4" required>{{ old('association_description', Auth::user()->association_description) }}</textarea>
                                @error('association_description')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-tag"></i> Catégories d'intervention</h3>
                        </div>
                        <div class="section-body">
                            <div class="categories-grid">
                                @php
                                    $associationCategories = ['Éducation', 'Santé', 'Environnement', 'Social', 'Urgence', 'Culture', 'Développement', 'Droits humains'];
                                    $userCategories = json_decode(Auth::user()->association_categories ?? '[]', true);
                                @endphp
                                
                                @foreach($associationCategories as $category)
                                <label class="category-checkbox">
                                    <input type="checkbox" name="association_categories[]" value="{{ $category }}" 
                                           {{ in_array($category, $userCategories) ? 'checked' : '' }}>
                                    <span class="category-label">{{ $category }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-header">
                            <h3><i class="fas fa-file-contract"></i> Documents officiels</h3>
                        </div>
                        <div class="section-body">
                            <div class="documents-upload">
                                <div class="document-item">
                                    <div class="document-info">
                                        <h5>Récépissé de déclaration</h5>
                                        <p>Document officiel d'enregistrement de l'association</p>
                                        @if(Auth::user()->association_documents && Auth::user()->association_documents->recepisse)
                                        <a href="{{ asset('storage/' . Auth::user()->association_documents->recepisse) }}" target="_blank" class="btn-text">
                                            <i class="fas fa-eye"></i> Voir le document
                                        </a>
                                        @endif
                                    </div>
                                    <div class="document-upload">
                                        <input type="file" id="recepisse" name="recepisse" accept=".pdf,.jpg,.jpeg,.png" hidden>
                                        <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('recepisse').click()">
                                            <i class="fas fa-upload"></i>
                                            {{ Auth::user()->association_documents && Auth::user()->association_documents->recepisse ? 'Remplacer' : 'Télécharger' }}
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="document-item">
                                    <div class="document-info">
                                        <h5>Statuts</h5>
                                        <p>Statuts officiels de l'association</p>
                                        @if(Auth::user()->association_documents && Auth::user()->association_documents->statuts)
                                        <a href="{{ asset('storage/' . Auth::user()->association_documents->statuts) }}" target="_blank" class="btn-text">
                                            <i class="fas fa-eye"></i> Voir le document
                                        </a>
                                        @endif
                                    </div>
                                    <div class="document-upload">
                                        <input type="file" id="statuts" name="statuts" accept=".pdf,.jpg,.jpeg,.png" hidden>
                                        <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('statuts').click()">
                                            <i class="fas fa-upload"></i>
                                            {{ Auth::user()->association_documents && Auth::user()->association_documents->statuts ? 'Remplacer' : 'Télécharger' }}
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="document-item">
                                    <div class="document-info">
                                        <h5>RIB / Coordonnées bancaires</h5>
                                        <p>Pour recevoir les dons</p>
                                        @if(Auth::user()->association_documents && Auth::user()->association_documents->rib)
                                        <a href="{{ asset('storage/' . Auth::user()->association_documents->rib) }}" target="_blank" class="btn-text">
                                            <i class="fas fa-eye"></i> Voir le document
                                        </a>
                                        @endif
                                    </div>
                                    <div class="document-upload">
                                        <input type="file" id="rib" name="rib" accept=".pdf,.jpg,.jpeg,.png" hidden>
                                        <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('rib').click()">
                                            <i class="fas fa-upload"></i>
                                            {{ Auth::user()->association_documents && Auth::user()->association_documents->rib ? 'Remplacer' : 'Télécharger' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Mettre à jour l'association
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ===== PROFILE EDIT STYLES ===== */
    .profile-edit-container {
        padding: 40px 0;
        background: #f8fafc;
        min-height: calc(100vh - 200px);
    }

    /* En-tête */
    .profile-header {
        text-align: center;
        position: relative;
    }

    .back-button {
        position: absolute;
        left: 0;
        top: 0;
    }

    .profile-title {
        font-size: 2.5rem;
        color: var(--black);
        margin-bottom: 10px;
        font-weight: 800;
    }

    .profile-subtitle {
        color: var(--gray);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Navigation */
    .profile-nav {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 20px;
        margin-bottom: 30px;
    }

    .nav-tabs {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 10px;
    }

    .nav-tab {
        padding: 15px 25px;
        background: #f3f4f6;
        border: 2px solid transparent;
        border-radius: var(--border-radius);
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
        background: #e5e7eb;
        color: #4b5563;
    }

    .nav-tab.active {
        background: var(--primary-light);
        border-color: var(--primary-color);
        color: var(--primary-dark);
    }

    /* Formulaire */
    .profile-edit-form {
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
    .form-section {
        margin-bottom: 40px;
        padding-bottom: 40px;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .section-header {
        margin-bottom: 25px;
    }

    .section-header h3 {
        color: #1f2937;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Avatar */
    .avatar-upload {
        display: flex;
        justify-content: center;
    }

    .avatar-preview {
        text-align: center;
    }

    .avatar-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 20px;
        border: 5px solid white;
        box-shadow: var(--shadow-lg);
        position: relative;
    }

    .avatar-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 4rem;
    }

    .avatar-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
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
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .error-message {
        display: block;
        margin-top: 6px;
        color: #dc2626;
        font-size: 13px;
        font-weight: 500;
    }

    .form-text {
        display: block;
        margin-top: 6px;
        color: #9ca3af;
        font-size: 12px;
    }

    /* Centres d'intérêt */
    .interests-grid, .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }

    .interest-checkbox, .category-checkbox {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px;
        background: #f8fafc;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius-sm);
        cursor: pointer;
        transition: all 0.2s;
    }

    .interest-checkbox:hover, .category-checkbox:hover {
        border-color: var(--primary-color);
        background: var(--primary-light);
    }

    .interest-checkbox input, .category-checkbox input {
        width: 18px;
        height: 18px;
    }

    .interest-label, .category-label {
        font-weight: 500;
        color: #4b5563;
        font-size: 14px;
    }

    /* Force du mot de passe */
    .password-strength {
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .strength-bar {
        flex: 1;
        height: 6px;
        background: #e5e7eb;
        border-radius: 3px;
        overflow: hidden;
    }

    .strength-bar::after {
        content: '';
        display: block;
        height: 100%;
        width: 0%;
        background: #ef4444;
        transition: width 0.3s;
    }

    .strength-text {
        font-size: 12px;
        font-weight: 600;
        color: #9ca3af;
        min-width: 50px;
    }

    /* Sécurité */
    .security-settings, .privacy-settings {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .security-item, .privacy-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: #f9fafb;
        border-radius: var(--border-radius);
        border: 1px solid #e5e7eb;
    }

    .security-info, .privacy-info {
        flex: 1;
    }

    .security-info h5, .privacy-info h5 {
        margin: 0 0 8px 0;
        color: #1f2937;
        font-size: 16px;
    }

    .security-info p, .privacy-info p {
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

    /* Notifications */
    .notifications-settings {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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
        font-size: 14px;
    }

    .notification-item .switch {
        width: 50px;
        height: 26px;
    }

    .notification-item .slider:before {
        height: 18px;
        width: 18px;
    }

    /* Documents association */
    .documents-upload {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .document-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
    }

    .document-info h5 {
        margin: 0 0 8px 0;
        color: #1f2937;
        font-size: 16px;
    }

    .document-info p {
        margin: 0 0 10px 0;
        color: #6b7280;
        font-size: 14px;
    }

    .btn-text {
        background: none;
        border: none;
        color: var(--primary-color);
        cursor: pointer;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0;
        text-decoration: none;
    }

    .btn-text:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Actions */
    .form-actions {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .nav-tabs {
            flex-wrap: wrap;
        }
        
        .nav-tab {
            flex: 1;
            min-width: 200px;
        }
        
        .security-item, .privacy-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .security-switch, .privacy-switch {
            align-self: flex-end;
        }
        
        .notifications-settings {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .profile-edit-container {
            padding: 20px 0;
        }
        
        .profile-title {
            font-size: 2rem;
            margin-top: 40px;
        }
        
        .back-button {
            position: static;
            margin-bottom: 20px;
        }
        
        .nav-tab {
            padding: 12px 20px;
            font-size: 14px;
        }
        
        .profile-edit-form {
            padding: 20px;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .interests-grid, .categories-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .document-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .form-actions button {
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
    
    // Gestion de l'avatar
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const changeAvatarBtn = document.getElementById('changeAvatar');
    const removeAvatarBtn = document.getElementById('removeAvatar');
    
    if (changeAvatarBtn) {
        changeAvatarBtn.addEventListener('click', function() {
            avatarInput.click();
        });
    }
    
    if (removeAvatarBtn) {
        removeAvatarBtn.addEventListener('click', function() {
            if (confirm('Supprimer votre photo de profil ?')) {
                // Créer un placeholder
                const placeholder = document.createElement('div');
                placeholder.className = 'avatar-placeholder';
                placeholder.innerHTML = '<i class="fas fa-user"></i>';
                
                // Remplacer l'image par le placeholder
                avatarPreview.innerHTML = '';
                avatarPreview.appendChild(placeholder);
                
                // Cacher le bouton supprimer
                removeAvatarBtn.style.display = 'none';
                
                // Mettre à jour le bouton changer
                changeAvatarBtn.innerHTML = '<i class="fas fa-camera"></i> Ajouter une photo';
                
                // Ajouter un champ caché pour supprimer l'avatar
                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'delete_avatar';
                deleteInput.value = '1';
                document.getElementById('personalForm').appendChild(deleteInput);
            }
        });
    }
    
    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (!file.type.startsWith('image/')) {
                alert('Veuillez sélectionner une image valide.');
                return;
            }
            
            if (file.size > 5 * 1024 * 1024) {
                alert('L\'image est trop volumineuse (max 5MB).');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Avatar';
                
                avatarPreview.innerHTML = '';
                avatarPreview.appendChild(img);
                
                // Afficher le bouton supprimer
                if (removeAvatarBtn) {
                    removeAvatarBtn.style.display = 'inline-block';
                }
                
                // Mettre à jour le bouton changer
                if (changeAvatarBtn) {
                    changeAvatarBtn.innerHTML = '<i class="fas fa-camera"></i> Changer';
                }
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Force du mot de passe
    const passwordInput = document.getElementById('new_password');
    const strengthBar = document.querySelector('.strength-bar');
    const strengthText = document.querySelector('.strength-text');
    
    if (passwordInput && strengthBar && strengthText) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Longueur
            if (password.length >= 8) strength += 20;
            if (password.length >= 12) strength += 20;
            
            // Complexité
            if (/[a-z]/.test(password)) strength += 20;
            if (/[A-Z]/.test(password)) strength += 20;
            if (/[0-9]/.test(password)) strength += 20;
            if (/[^a-zA-Z0-9]/.test(password)) strength += 20;
            
            // Limiter à 100%
            strength = Math.min(strength, 100);
            
            // Mettre à jour la barre
            strengthBar.style.width = strength + '%';
            
            // Couleur et texte
            if (strength < 40) {
                strengthBar.style.backgroundColor = '#ef4444';
                strengthText.textContent = 'Faible';
                strengthText.style.color = '#ef4444';
            } else if (strength < 70) {
                strengthBar.style.backgroundColor = '#f59e0b';
                strengthText.textContent = 'Moyen';
                strengthText.style.color = '#f59e0b';
            } else {
                strengthBar.style.backgroundColor = '#10b981';
                strengthText.textContent = 'Fort';
                strengthText.style.color = '#10b981';
            }
        });
    }
    
    // Annuler
    document.getElementById('cancelEdit')?.addEventListener('click', function() {
        if (confirm('Annuler les modifications ?')) {
            window.location.href = '{{ route("profile.show") }}';
        }
    });
    
    // Voir les sessions
    document.getElementById('viewSessions')?.addEventListener('click', function() {
        alert('Fonctionnalité en développement');
    });
    
    // Validation des formulaires
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            // Validation personnalisée ici si nécessaire
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
        });
    });
});
</script>
@endpush