 @extends('layouts.blade')

 @section('title', 'Compléter mon profil association - MainTendue')



 @section('content')

 @section('content')
     <div class="container1 py-5">
         <div class="rower justify-content-center">
             <div class="col-md-10">
                 <div class="card shadow-lg border-0">
                     <div class="card-header bg-primary text-white">
                         <div class="d-flex align-items-center">
                             <div class="me-3"
                                 style=" background-color:#fff; padding:1em 2em; border-radius:10px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
                                 <div style="display: flex; gap:1em">
                                     <i class="fas fa-hand-holding-heart fa-2x" style="color: #2e59d9"></i>
                                     <h4 class="mb-0" style="color: #2e59d9">Compléter le profil de votre association</h4>
                                 </div>

                                 <p class="mb-0 opacity-75">Une fois validé, vous pourrez recevoir des dons</p>
                             </div>
                         </div>
                     </div>

                     <div class="card-body p-4">
                         @if (session('success'))
                             <div class="alert alert-success alert-dismissible fade show" role="alert">
                                 <i class="fas fa-check-circle me-2"></i>
                                 {{ session('success') }}
                                 <button type="button" class="btn-close" data-bs-dismiss="alert"
                                     aria-label="Close"></button>
                             </div>
                         @endif

                         @if ($errors->any())
                             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                 <i class="fas fa-exclamation-triangle me-2"></i>
                                 <strong>Veuillez corriger les erreurs suivantes :</strong>
                                 <ul class="mb-0 mt-2">
                                     @foreach ($errors->all() as $error)
                                         <li>{{ $error }}</li>
                                     @endforeach
                                 </ul>
                                 <button type="button" class="btn-close" data-bs-dismiss="alert"
                                     aria-label="Close"></button>
                             </div>
                         @endif

                         <div class="alert alert-info border-start border-5 border-info">
                             <div class="d-flex"
                                 style=" background-color:#fff; padding:1em 2em; border-radius:10px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); margin:2em 0">                             
                                 <div class="me-3" style="display: flex; gap:1em">
                                     <i class="fas fa-info-circle fa-2x text-info" style="color: #2e59d9"></i>
                                     <h4 class="alert-heading mb-2" style="color: #2e59d9">Informations importantes</h4>
                                 </div>
                                 <div>
                                     <p class="mb-2">Votre compte association a été créé mais nécessite des informations
                                         supplémentaires pour être activé.</p>
                                      </div>
                             </div>
                             <p class="mb-0"><strong>Après soumission :</strong> Notre équipe validera votre
                                         profil sous 24-48h. Vous recevrez une notification par email.</p>
                                
                         </div>

                         <form method="POST" action="{{ route('associations.complete-profile') }}"
                             enctype="multipart/form-data" class="needs-validation" novalidate>
                             @csrf

                             <!-- Informations Légales -->
                             <div class="section-card mb-4">
                                 <div class="section-header">
                                     <h5 class="section-title">
                                         <i class="fas fa-gavel me-2"></i>
                                         Informations Légales
                                     </h5>
                                     <p class="section-subtitle">Informations officielles de votre association</p>
                                 </div>

                                 <div class="row1">
                                     <!-- Nom légal -->
                                     <div class="col-md-6 mb-3">
                                         <label for="legal_name" class="form-label fw-bold">
                                             Nom légal de l'association *
                                         </label>
                                         <input type="text"
                                             class="form-control form-control-lg @error('legal_name') is-invalid @enderror"
                                             id="legal_name" name="legal_name" value="{{ old('legal_name') }}" required
                                             placeholder="Ex: Les Restos du Cœur">
                                         <div class="invalid-feedback">
                                             Le nom légal de l'association est requis.
                                         </div>
                                         @error('legal_name')
                                             <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                     </div>

                                     <!-- Numéro d'enregistrement -->
                                     <div class="col-md-6 mb-3">
                                         <label for="registration_number" class="form-label fw-bold">
                                             Numéro d'enregistrement
                                             <span class="text-muted fw-normal">(optionnel)</span>
                                         </label>
                                         <input type="text"
                                             class="form-control form-control-lg @error('registration_number') is-invalid @enderror"
                                             id="registration_number" name="registration_number"
                                             value="{{ old('registration_number') }}" placeholder="Ex: RNA W123456789">
                                         <small class="text-muted">Numéro RNA, SIRET, ou équivalent selon votre pays</small>
                                         @error('registration_number')
                                             <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                     </div>
                                 </div>

                                 <!-- Personne de contact -->
                                 <div class="row1">
                                     <div class="col-md-6 mb-3">
                                         <label for="contact_person" class="form-label fw-bold">
                                             Personne de contact *
                                         </label>
                                         <input type="text"
                                             class="form-control form-control-lg @error('contact_person') is-invalid @enderror"
                                             id="contact_person" name="contact_person" value="{{ old('contact_person') }}"
                                             required placeholder="Ex: Marie Dupont">
                                         <div class="invalid-feedback">
                                             La personne de contact est requise.
                                         </div>
                                         @error('contact_person')
                                             <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                     </div>

                                     <!-- Téléphone -->
                                     <div class="col-md-6 mb-3">
                                         <label for="phone" class="form-label fw-bold">
                                             Téléphone de contact *
                                         </label>
                                         <input type="tel"
                                             class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                             id="phone" name="phone" value="{{ old('phone') }}" required
                                             placeholder="Ex: 01 23 45 67 89">
                                         <div class="invalid-feedback">
                                             Un numéro de téléphone valide est requis.
                                         </div>
                                         @error('phone')
                                             <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                     </div>
                                 </div>
                             </div>

                             <!-- Description et Site web -->
                             <div class="section-card mb-4">
                                 <div class="section-header">
                                     <h5 class="section-title">
                                         <i class="fas fa-align-left me-2"></i>
                                         Présentation
                                     </h5>
                                     <p class="section-subtitle">Décrivez votre association aux donateurs</p>
                                 </div>

                                 <!-- Description -->
                                 <div class="mb-3">
                                     <label for="description" class="form-label fw-bold">
                                         Description de votre association *
                                     </label>
                                     <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                         rows="5" required placeholder="Décrivez votre mission, vos activités, vos bénéficiaires...">{{ old('description') }}</textarea>
                                     <div class="invalid-feedback">
                                         Une description de votre association est requise.
                                     </div>
                                     <small class="text-muted">Cette description sera visible par les donateurs.</small>
                                     @error('description')
                                         <div class="invalid-feedback d-block">{{ $message }}</div>
                                     @enderror
                                 </div>

                                 <!-- Site web -->
                                 <div class="mb-3">
                                     <label for="website" class="form-label fw-bold">
                                         Site web
                                         <span class="text-muted fw-normal">(optionnel)</span>
                                     </label>
                                     <input type="url"
                                         class="form-control form-control-lg @error('website') is-invalid @enderror"
                                         id="website" name="website" value="{{ old('website') }}"
                                         placeholder="https://www.votre-association.org">
                                     @error('website')
                                         <div class="invalid-feedback d-block">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>

                             <!-- Adresse -->
                             <div class="section-card mb-4">
                                 <div class="section-header">
                                     <h5 class="section-title">
                                         <i class="fas fa-map-marker-alt me-2"></i>
                                         Adresse Légale
                                     </h5>
                                     <p class="section-subtitle">Adresse officielle de votre association</p>
                                 </div>

                                 <div class="mb-3">
                                     <label for="legal_address" class="form-label fw-bold">
                                         Adresse complète *
                                     </label>
                                     <textarea class="form-control @error('legal_address') is-invalid @enderror" id="legal_address" name="legal_address"
                                         rows="3" required placeholder="Numéro, rue, code postal, ville, pays">{{ old('legal_address') }}</textarea>
                                     <div class="invalid-feedback">
                                         L'adresse légale est requise.
                                     </div>
                                     @error('legal_address')
                                         <div class="invalid-feedback d-block">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>

                             <!-- Besoins et Logistique -->
                             <div class="section-card mb-4">
                                 <div class="section-header">
                                     <h5 class="section-title">
                                         <i class="fas fa-boxes me-2"></i>
                                         Logistique et Besoins
                                     </h5>
                                     <p class="section-subtitle">Comment recevez-vous les dons ?</p>
                                 </div>

                                 <!-- Section pour les besoins spécifiques (optionnel) -->
                                 <div class="row1">
                                     <!-- Type d'article -->
                                     <div class="col-md-6 mb-3">
                                         <label for="item_type" class="form-label fw-bold">
                                             Type d'article recherché
                                             <span class="text-muted fw-normal">(optionnel)</span>
                                         </label>
                                         <select
                                             class="form-control form-control-lg @error('item_type') is-invalid @enderror"
                                             id="item_type" name="item_type">
                                             <option value="">Sélectionnez un type</option>
                                             <option value="clothing"
                                                 {{ old('item_type') == 'clothing' ? 'selected' : '' }}>Vêtements</option>
                                             <option value="shoes" {{ old('item_type') == 'shoes' ? 'selected' : '' }}>
                                                 Chaussures</option>
                                             <option value="food" {{ old('item_type') == 'food' ? 'selected' : '' }}>
                                                 Alimentaire</option>
                                             <option value="school" {{ old('item_type') == 'school' ? 'selected' : '' }}>
                                                 Scolaire</option>
                                             <option value="furniture"
                                                 {{ old('item_type') == 'furniture' ? 'selected' : '' }}>Meubles</option>
                                             <option value="other" {{ old('item_type') == 'other' ? 'selected' : '' }}>
                                                 Autre</option>
                                         </select>
                                         @error('item_type')
                                             <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                     </div>

                                     <!-- Niveau scolaire (si type scolaire) -->
                                     <div class="col-md-6 mb-3">
                                         <label for="school_level" class="form-label fw-bold">
                                             Niveau scolaire
                                             <span class="text-muted fw-normal">(optionnel)</span>
                                         </label>
                                         <input type="text"
                                             class="form-control form-control-lg @error('school_level') is-invalid @enderror"
                                             id="school_level" name="school_level" value="{{ old('school_level') }}"
                                             placeholder="Ex: Primaire, Collège, Lycée">
                                         @error('school_level')
                                             <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                     </div>
                                 </div>

                                 <!-- Quantité et condition -->
                                 <div class="row1">
                                     <div class="col-md-6 mb-3">
                                         <label for="quantity" class="form-label fw-bold">
                                             Quantité souhaitée
                                             <span class="text-muted fw-normal">(optionnel)</span>
                                         </label>
                                         <input type="number"
                                             class="form-control form-control-lg @error('quantity') is-invalid @enderror"
                                             id="quantity" name="quantity" value="{{ old('quantity', 1) }}"
                                             min="1" max="1000">
                                         @error('quantity')
                                             <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                     </div>

                                     <div class="col-md-6 mb-3">
                                         <label for="condition" class="form-label fw-bold">
                                             Condition acceptée
                                             <span class="text-muted fw-normal">(optionnel)</span>
                                         </label>
                                         <select
                                             class="form-control form-control-lg @error('condition') is-invalid @enderror"
                                             id="condition" name="condition">
                                             <option value="">Toutes conditions</option>
                                             <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Neuf
                                             </option>
                                             <option value="very_good"
                                                 {{ old('condition') == 'very_good' ? 'selected' : '' }}>Très bon état
                                             </option>
                                             <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Bon
                                                 état</option>
                                             <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Usé
                                                 mais fonctionnel</option>
                                         </select>
                                         @error('condition')
                                             <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                     </div>
                                 </div>

                                 <!-- Description des besoins -->
                                 <div class="mb-4">
                                     <label for="needs_description" class="form-label fw-bold">
                                         Description de vos besoins actuels
                                         <span class="text-muted fw-normal">(optionnel)</span>
                                     </label>
                                     <textarea class="form-control @error('needs_description') is-invalid @enderror" id="needs_description"
                                         name="needs_description" rows="4"
                                         placeholder="Décrivez les types de dons dont vous avez besoin (vêtements, alimentaire, etc.)">{{ old('needs_description') }}</textarea>
                                     <small class="text-muted">Cette information aide les donateurs à savoir ce dont vous
                                         avez besoin.</small>
                                     @error('needs_description')
                                         <div class="invalid-feedback d-block">{{ $message }}</div>
                                     @enderror
                                 </div>

                                 <!-- Options de réception -->
                                 <div class="row1 mb-4">
                                     <div class="col-md-6">
                                         <div class="form-check form-switch">
                                             <input class="form-check-input" type="checkbox" id="accepts_direct_delivery"
                                                 name="accepts_direct_delivery" value="1"
                                                 {{ old('accepts_direct_delivery', 1) ? 'checked' : '' }}>
                                             <label class="form-check-label fw-bold" for="accepts_direct_delivery">
                                                 <i class="fas fa-truck me-2"></i>
                                                 Acceptez-vous les livraisons directes ?
                                             </label>
                                             <p class="text-muted small mb-0">Le donateur vient livrer directement à votre
                                                 association</p>
                                         </div>
                                     </div>

                                     <div class="col-md-6">
                                         <div class="form-check form-switch">
                                             <input class="form-check-input" type="checkbox"
                                                 id="accepts_collection_points" name="accepts_collection_points"
                                                 value="1" {{ old('accepts_collection_points') ? 'checked' : '' }}>
                                             <label class="form-check-label fw-bold" for="accepts_collection_points">
                                                 <i class="fas fa-map-pin me-2"></i>
                                                 Utilisez-vous des points de collecte ?
                                             </label>
                                             <p class="text-muted small mb-0">Vous disposez de points de dépôt fixes</p>
                                         </div>
                                     </div>
                                 </div>

                                 <!-- Rayon de livraison -->
                                 <div class="row1">
                                     <div class="col-md-6">
                                         <label for="delivery_radius" class="form-label fw-bold">
                                             Rayon d'acceptation (en km)
                                             <span class="text-muted fw-normal">(optionnel)</span>
                                         </label>
                                         <div class="input-group">
                                             <input type="number"
                                                 class="form-control form-control-lg @error('delivery_radius') is-invalid @enderror"
                                                 id="delivery_radius" name="delivery_radius"
                                                 value="{{ old('delivery_radius') }}" min="0" max="200"
                                                 placeholder="Ex: 20">
                                             <span class="input-group-text">km</span>
                                         </div>
                                         <small class="text-muted">Dans quel rayon acceptez-vous les dons ? (0 = seulement
                                             à votre adresse)</small>
                                         @error('delivery_radius')
                                             <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                     </div>

                                     <!-- Horaires d'ouverture -->
                                     <div class="col-md-6">
                                         <label for="opening_hours" class="form-label fw-bold">
                                             Horaires d'ouverture
                                             <span class="text-muted fw-normal">(optionnel)</span>
                                         </label>
                                         <textarea class="form-control @error('opening_hours') is-invalid @enderror" id="opening_hours" name="opening_hours"
                                             rows="2" placeholder="Ex: Lun-Ven: 9h-12h, 14h-17h">{{ old('opening_hours') }}</textarea>
                                         @error('opening_hours')
                                             <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                     </div>
                                 </div>
                             </div>

                             <!-- Logo et Document -->
                             <div class="section-card mb-4">
                                 <div class="section-header">
                                     <h5 class="section-title">
                                         <i class="fas fa-file-upload me-2"></i>
                                         Documents
                                     </h5>
                                     <p class="section-subtitle">Logo et justificatif pour validation</p>
                                 </div>

                                 <div class="row1">
                                     <!-- Logo -->
                                     <div class="col-md-6 mb-3">
                                         <label for="logo" class="form-label fw-bold">
                                             Logo de l'association
                                             <span class="text-muted fw-normal">(optionnel)</span>
                                         </label>
                                         <div class="file-upload-area">
                                             <input type="file"
                                                 class="form-control @error('logo') is-invalid @enderror" id="logo"
                                                 name="logo" accept="image/*" onchange="previewLogo(event)">
                                             <div class="mt-2 text-center">
                                                 <img id="logoPreview"
                                                     src="{{ asset('assets/images/default-logo.png') }}"
                                                     alt="Aperçu du logo" class="img-thumbnail mt-2"
                                                     style="max-height: 150px; display: none;">
                                             </div>
                                             <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF. Max: 2MB</small>
                                             @error('logo')
                                                 <div class="invalid-feedback d-block">{{ $message }}</div>
                                             @enderror
                                         </div>
                                     </div>

                                     <!-- Document de vérification -->
                                     <div class="col-md-6 mb-3">
                                         <label for="verification_document" class="form-label fw-bold">
                                             Justificatif légal *
                                         </label>
                                         <div class="file-upload-area">
                                             <input type="file"
                                                 class="form-control @error('verification_document') is-invalid @enderror"
                                                 id="verification_document" name="verification_document"
                                                 accept=".pdf,.jpg,.jpeg,.png" required>
                                             <div class="invalid-feedback">
                                                 Un justificatif légal est requis pour la validation.
                                             </div>
                                             <small class="text-muted d-block mt-1">
                                                 <i class="fas fa-info-circle me-1"></i>
                                                 Statuts, récépissé de déclaration, extrait Kbis, etc.
                                             </small>
                                             <small class="text-muted">Format: PDF, JPG, PNG. Max: 5MB</small>
                                             @error('verification_document')
                                                 <div class="invalid-feedback d-block">{{ $message }}</div>
                                             @enderror
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <!-- Section Préférences de notification -->
                             <div class="section-card mb-4">
                                 <div class="section-header">
                                     <h5 class="section-title">
                                         <i class="fas fa-bell me-2"></i>
                                         Préférences de notification
                                     </h5>
                                     <p class="section-subtitle">Choisissez comment vous souhaitez être informé</p>
                                 </div>

                                 <div class="row1">
                                     <div class="col-md-6">
                                         <h6 class="mb-3">Notifications par email</h6>

                                         <div class="form-check form-switch mb-3">
                                             <input class="form-check-input" type="checkbox" id="email_new_donations"
                                                 name="notification_settings[email_new_donations]" value="1"
                                                 {{ old('notification_settings.email_new_donations', true) ? 'checked' : '' }}>
                                             <label class="form-check-label" for="email_new_donations">
                                                 Nouveaux dons disponibles
                                             </label>
                                             <small class="text-muted d-block">Recevoir un email quand de nouveaux dons
                                                 sont postés</small>
                                         </div>

                                         <div class="form-check form-switch mb-3">
                                             <input class="form-check-input" type="checkbox" id="email_messages"
                                                 name="notification_settings[email_messages]" value="1"
                                                 {{ old('notification_settings.email_messages', true) ? 'checked' : '' }}>
                                             <label class="form-check-label" for="email_messages">
                                                 Nouveaux messages
                                             </label>
                                             <small class="text-muted d-block">Recevoir un email quand vous recevez un
                                                 message</small>
                                         </div>

                                         <div class="form-check form-switch mb-3">
                                             <input class="form-check-input" type="checkbox" id="email_requests"
                                                 name="notification_settings[email_requests]" value="1"
                                                 {{ old('notification_settings.email_requests', true) ? 'checked' : '' }}>
                                             <label class="form-check-label" for="email_requests">
                                                 Demandes de dons
                                             </label>
                                             <small class="text-muted d-block">Recevoir un email pour les nouvelles
                                                 demandes</small>
                                         </div>
                                     </div>

                                     <div class="col-md-6">
                                         <h6 class="mb-3">Notifications push (si application mobile)</h6>

                                         <div class="form-check form-switch mb-3">
                                             <input class="form-check-input" type="checkbox" id="push_new_donations"
                                                 name="notification_settings[push_new_donations]" value="1"
                                                 {{ old('notification_settings.push_new_donations', true) ? 'checked' : '' }}>
                                             <label class="form-check-label" for="push_new_donations">
                                                 Nouveaux dons disponibles
                                             </label>
                                             <small class="text-muted d-block">Notification push pour les nouveaux
                                                 dons</small>
                                         </div>

                                         <div class="form-check form-switch mb-3">
                                             <input class="form-check-input" type="checkbox" id="push_messages"
                                                 name="notification_settings[push_messages]" value="1"
                                                 {{ old('notification_settings.push_messages', true) ? 'checked' : '' }}>
                                             <label class="form-check-label" for="push_messages">
                                                 Nouveaux messages
                                             </label>
                                             <small class="text-muted d-block">Notification push pour les messages</small>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <!-- Section Système de messagerie -->
                             <div class="section-card mb-4">
                                 <div class="section-header">
                                     <h5 class="section-title">
                                         <i class="fas fa-comments me-2"></i>
                                         Préférences de messagerie
                                     </h5>
                                     <p class="section-subtitle">Configurez comment vous communiquez avec les donateurs</p>
                                 </div>

                                 <div class="row1">
                                     <div class="col-md-6 mb-3">
                                         <label for="default_message_template" class="form-label fw-bold">
                                             Modèle de message par défaut
                                             <span class="text-muted fw-normal">(optionnel)</span>
                                         </label>
                                         <textarea class="form-control @error('messaging_preferences.default_message_template') is-invalid @enderror"
                                             id="default_message_template" name="messaging_preferences[default_message_template]" rows="4"
                                             placeholder="Bonjour, merci pour votre don ! Nous vous contacterons pour organiser la récupération...">{{ old('messaging_preferences.default_message_template') }}</textarea>
                                         @error('messaging_preferences.default_message_template')
                                             <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                         <small class="text-muted">Ce message sera utilisé automatiquement pour remercier
                                             les donateurs</small>
                                     </div>

                                     <div class="col-md-6">
                                         <div class="form-check form-switch mb-3">
                                             <input class="form-check-input" type="checkbox" id="auto_reply_enabled"
                                                 name="messaging_preferences[auto_reply_enabled]" value="1"
                                                 {{ old('messaging_preferences.auto_reply_enabled', true) ? 'checked' : '' }}>
                                             <label class="form-check-label fw-bold" for="auto_reply_enabled">
                                                 Réponse automatique activée
                                             </label>
                                             <p class="text-muted small mb-0">Envoyer automatiquement un message de
                                                 remerciement</p>
                                         </div>

                                         <div class="form-check form-switch mb-3">
                                             <input class="form-check-input" type="checkbox" id="notify_on_message"
                                                 name="messaging_preferences[notify_on_message]" value="1"
                                                 {{ old('messaging_preferences.notify_on_message', true) ? 'checked' : '' }}>
                                             <label class="form-check-label fw-bold" for="notify_on_message">
                                                 Notifier par email pour chaque message
                                             </label>
                                             <p class="text-muted small mb-0">Recevoir un email à chaque nouveau message
                                             </p>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <!-- Section Évaluations et signalements -->
                             <div class="section-card mb-4">
                                 <div class="section-header">
                                     <h5 class="section-title">
                                         <i class="fas fa-star me-2"></i>
                                         Évaluations et signalements
                                     </h5>
                                     <p class="section-subtitle">Configurez vos préférences d'évaluation</p>
                                 </div>

                                 <div class="row1">
                                     <div class="col-md-6 mb-3">
                                         <label for="review_preferences" class="form-label fw-bold">
                                             Politique d'évaluation
                                             <span class="text-muted fw-normal">(optionnel)</span>
                                         </label>
                                         <select
                                             class="form-control form-control-lg @error('review_preferences.auto_request_review') is-invalid @enderror"
                                             id="review_preferences" name="review_preferences[auto_request_review]">
                                             <option value="">Ne pas demander automatiquement</option>
                                             <option value="1"
                                                 {{ old('review_preferences.auto_request_review') == '1' ? 'selected' : '' }}>
                                                 Demander une évaluation après chaque don livré
                                             </option>
                                             <option value="7"
                                                 {{ old('review_preferences.auto_request_review') == '7' ? 'selected' : '' }}>
                                                 Demander une évaluation 7 jours après livraison
                                             </option>
                                             <option value="14"
                                                 {{ old('review_preferences.auto_request_review') == '14' ? 'selected' : '' }}>
                                                 Demander une évaluation 14 jours après livraison
                                             </option>
                                         </select>
                                         @error('review_preferences.auto_request_review')
                                             <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                         <small class="text-muted">Quand demander une évaluation aux donateurs</small>
                                     </div>

                                     <div class="col-md-6">
                                         <div class="form-check form-switch mb-3">
                                             <input class="form-check-input" type="checkbox" id="show_ratings_public"
                                                 name="review_preferences[show_ratings_public]" value="1"
                                                 {{ old('review_preferences.show_ratings_public', true) ? 'checked' : '' }}>
                                             <label class="form-check-label fw-bold" for="show_ratings_public">
                                                 Afficher les évaluations publiquement
                                             </label>
                                             <p class="text-muted small mb-0">Montrer vos notes moyennes sur votre profil
                                             </p>
                                         </div>

                                         <div class="form-check form-switch mb-3">
                                             <input class="form-check-input" type="checkbox" id="auto_report_issues"
                                                 name="review_preferences[auto_report_issues]" value="1"
                                                 {{ old('review_preferences.auto_report_issues', false) ? 'checked' : '' }}>
                                             <label class="form-check-label fw-bold" for="auto_report_issues">
                                                 Signaler automatiquement les problèmes
                                             </label>
                                             <p class="text-muted small mb-0">Créer un signalement pour les dons
                                                 problématiques</p>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <!-- Section pour les demandes spécifiques (optionnel) -->
                             <div class="section-card mb-4">
                                 <div class="section-header">
                                     <h5 class="section-title">
                                         <i class="fas fa-bullhorn me-2"></i>
                                         Demande spécifique
                                     </h5>
                                     <p class="section-subtitle">Publiez une demande spécifique de don</p>
                                 </div>

                                 <div class="mb-3">
                                     <label for="request_title" class="form-label fw-bold">
                                         Titre de la demande
                                         <span class="text-muted fw-normal">(optionnel)</span>
                                     </label>
                                     <input type="text"
                                         class="form-control form-control-lg @error('request_title') is-invalid @enderror"
                                         id="request_title" name="request_title" value="{{ old('request_title') }}"
                                         placeholder="Ex: Besoin urgent de couvertures pour l'hiver">
                                     @error('request_title')
                                         <div class="invalid-feedback d-block">{{ $message }}</div>
                                     @enderror
                                 </div>

                                 <div class="mb-3">
                                     <label for="request_message" class="form-label fw-bold">
                                         Message aux donateurs
                                         <span class="text-muted fw-normal">(optionnel)</span>
                                     </label>
                                     <textarea class="form-control @error('request_message') is-invalid @enderror" id="request_message"
                                         name="request_message" rows="4" placeholder="Expliquez votre besoin spécifique...">{{ old('request_message') }}</textarea>
                                     @error('request_message')
                                         <div class="invalid-feedback d-block">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>

                             <!-- Boutons -->
                             <div class="d-flex justify-content-between align-items-center mt-5">
                                 <div>
                                     <a href="{{ route('logout') }}"
                                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                         class="btn btn-outline-secondary">
                                         <i class="fas fa-sign-out-alt me-2"></i>
                                         Se déconnecter
                                     </a>
                                     <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                         style="display: none;">
                                         @csrf
                                     </form>
                                 </div>

                                 <div class="d-flex gap-3">
                                     <button type="reset" class="btn btn-lg btn-outline-primary">
                                         <i class="fas fa-redo me-2"></i>
                                         Annuler
                                     </button>
                                     <button type="submit" class="btn btn-lg btn-primary px-5">
                                         <i class="fas fa-paper-plane me-2"></i>
                                         Soumettre pour validation
                                     </button>
                                 </div>
                             </div>
                         </form>
                     </div>

                     <div class="card-footer bg-light text-center py-3">
                         <small class="text-muted">
                             <i class="fas fa-shield-alt me-1"></i>
                             Vos données sont protégées conformément à notre
                             <a href="{{ route('privacy') }}" class="text-decoration-none">Politique de
                                 Confidentialité</a>.
                         </small>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection

 @push('styles')
     <style>
         .container1 {
             background-color: #fff;
         }

         /* Styles spécifiques au formulaire de profil - Compatible avec association.css */
         .section-card {
             background: #f8f9fa;
             border-radius: 10px;
             padding: 1.5rem;
             border-left: 4px solid #4e73df;
             margin-bottom: 1.5rem;
             border: 1px solid #e3e6f0;
         }

         .section-header {
             margin-bottom: 1.5rem;
             border-bottom: 1px solid #dee2e6;
             padding-bottom: 0.75rem;
         }

         .section-title {
             color: #2e59d9;
             font-weight: 600;
             margin: 0;
             font-size: 1.25rem;
         }

         .section-subtitle {
             color: #6c757d;
             font-size: 0.875rem;
             margin-bottom: 0;
         }

         .form-control-lg {
             padding: 0.75rem 1rem;
             font-size: 1rem;
         }

         .file-upload-area {
             border: 2px dashed #dee2e6;
             border-radius: 8px;
             padding: 1rem;
             background: white;
             transition: all 0.3s ease;
         }

         .file-upload-area:hover {
             border-color: #4e73df;
             background: #f8f9ff;
         }

         .form-check-input:checked {
             background-color: #4e73df;
             border-color: #4e73df;
         }

         .form-check-label {
             font-size: 1rem;
         }

         .card-header {
             border-radius: 10px 10px 0 0 !important;
             padding: 1.5rem 2rem;
         }

         .btn-lg {
             padding: 0.75rem 2rem;
             font-weight: 500;
         }

         /* Styles pour la barre de progression */
         .progress-container {
             margin-bottom: 1.5rem;
         }

         .radius-info {
             font-style: italic;
             display: block;
             margin-top: 0.5rem;
             font-size: 0.875rem;
             color: #6c757d;
         }

         /* Responsive */
         @media (max-width: 768px) {
             .section-card {
                 padding: 1rem;
             }

             .btn-lg {
                 padding: 0.5rem 1rem;
             }

             .d-flex.gap-3 {
                 gap: 0.5rem !important;
             }
         }
     </style>
 @endpush

 @push('scripts')
     <script>
         // ============ FONCTIONS SPÉCIFIQUES AU FORMULAIRE ============

         // Aperçu du logo
         function previewLogo(event) {
             const preview = document.getElementById('logoPreview');
             const file = event.target.files[0];

             if (file) {
                 const reader = new FileReader();
                 reader.onload = function(e) {
                     preview.src = e.target.result;
                     preview.style.display = 'block';
                 };
                 reader.readAsDataURL(file);
             } else {
                 preview.style.display = 'none';
             }
         }

         // Aperçu du document
         function previewDocument(event) {
             const file = event.target.files[0];
             let previewArea = document.getElementById('documentPreview');

             if (!previewArea) {
                 previewArea = document.createElement('div');
                 previewArea.id = 'documentPreview';
                 previewArea.className = 'mt-2';
                 event.target.parentNode.appendChild(previewArea);
             }

             if (file) {
                 if (file.type === 'application/pdf') {
                     previewArea.innerHTML = `
                    <div class="alert alert-info mt-2">
                        <i class="fas fa-file-pdf me-2"></i>
                        ${file.name} (PDF)
                        <div class="small">Taille: ${(file.size / 1024 / 1024).toFixed(2)} MB</div>
                    </div>
                `;
                 } else if (file.type.startsWith('image/')) {
                     const reader = new FileReader();
                     reader.onload = function(e) {
                         previewArea.innerHTML = `
                        <div class="alert alert-info mt-2">
                            <i class="fas fa-file-image me-2"></i>
                            ${file.name} (Image)
                            <div class="small">Taille: ${(file.size / 1024 / 1024).toFixed(2)} MB</div>
                            <img src="${e.target.result}" class="img-thumbnail mt-2" style="max-height: 100px;">
                        </div>
                    `;
                     };
                     reader.readAsDataURL(file);
                 } else {
                     previewArea.innerHTML = `
                    <div class="alert alert-warning mt-2">
                        <i class="fas fa-file me-2"></i>
                        ${file.name}
                        <div class="small">Format non prévisualisable</div>
                    </div>
                `;
                 }
             } else {
                 previewArea.innerHTML = '';
             }
         }

         // ============ INITIALISATION ============
         document.addEventListener('DOMContentLoaded', function() {
             console.log('Formulaire de profil association chargé');

             // ============ VALIDATION BOOTSTRAP ============
             (function() {
                 'use strict';

                 var forms = document.querySelectorAll('.needs-validation');

                 Array.prototype.slice.call(forms)
                     .forEach(function(form) {
                         form.addEventListener('submit', function(event) {
                             if (!form.checkValidity()) {
                                 event.preventDefault();
                                 event.stopPropagation();
                             }

                             form.classList.add('was-validated');
                         }, false);
                     });
             })();

             // ============ GESTION DES FICHIERS ============
             const docInput = document.getElementById('verification_document');
             if (docInput) {
                 docInput.addEventListener('change', previewDocument);
             }

             // ============ GESTION DU RAYON DE LIVRAISON ============
             const deliveryRadius = document.getElementById('delivery_radius');
             if (deliveryRadius) {
                 const updateRadiusInfo = () => {
                     const value = deliveryRadius.value;
                     const parentDiv = deliveryRadius.closest('.col-md-6');
                     let infoDiv = parentDiv.querySelector('.radius-info');

                     if (!infoDiv) {
                         infoDiv = document.createElement('div');
                         infoDiv.className = 'radius-info small text-muted mt-1';
                         parentDiv.appendChild(infoDiv);
                     }

                     if (!value || value === '') {
                         infoDiv.textContent = 'Aucun rayon défini - Seulement à votre adresse';
                     } else if (parseInt(value) === 0) {
                         infoDiv.textContent = 'Seulement à votre adresse exacte';
                     } else if (parseInt(value) <= 5) {
                         infoDiv.textContent = `Rayon réduit (${value} km) - Quartier proche`;
                     } else if (parseInt(value) <= 20) {
                         infoDiv.textContent = `Rayon moyen (${value} km) - Ville et proche banlieue`;
                     } else if (parseInt(value) <= 50) {
                         infoDiv.textContent = `Grand rayon (${value} km) - Département`;
                     } else {
                         infoDiv.textContent = `Très grand rayon (${value} km) - Région`;
                     }
                 };

                 deliveryRadius.addEventListener('input', updateRadiusInfo);
                 deliveryRadius.addEventListener('change', updateRadiusInfo);
                 updateRadiusInfo(); // Initialiser
             }

             // ============ APERÇU DU TEMPLATE DE MESSAGE ============
             const messageTemplate = document.getElementById('default_message_template');
             if (messageTemplate) {
                 const previewBtn = document.createElement('button');
                 previewBtn.type = 'button';
                 previewBtn.className = 'btn btn-sm btn-outline-secondary mt-2';
                 previewBtn.innerHTML = '<i class="fas fa-eye me-1"></i> Aperçu';

                 previewBtn.addEventListener('click', function() {
                     const template = messageTemplate.value.trim();
                     if (template) {
                         let previewContainer = document.getElementById('messagePreview');
                         if (!previewContainer) {
                             previewContainer = document.createElement('div');
                             previewContainer.id = 'messagePreview';
                             messageTemplate.parentNode.appendChild(previewContainer);
                         }

                         previewContainer.innerHTML = `
                        <div class="alert alert-info mt-2">
                            <h6 class="mb-2">Aperçu du message :</h6>
                            <div class="p-3 bg-white rounded border">
                                ${template.replace(/\n/g, '<br>')}
                            </div>
                            <small class="text-muted mt-2 d-block">
                                Ce message sera envoyé automatiquement aux donateurs
                            </small>
                        </div>
                    `;
                     }
                 });

                 messageTemplate.parentNode.appendChild(previewBtn);
             }

             // ============ BARRE DE PROGRESSION SIMPLE ============
             const form = document.querySelector('form.needs-validation');
             if (form) {
                 const updateProgress = () => {
                     const requiredFields = form.querySelectorAll('[required]');
                     const totalFields = requiredFields.length;
                     let filledFields = 0;

                     requiredFields.forEach(field => {
                         let isFilled = false;

                         if (field.type === 'checkbox') {
                             isFilled = field.checked;
                         } else if (field.type === 'file') {
                             isFilled = field.files && field.files.length > 0;
                         } else if (field.type === 'select-one') {
                             isFilled = field.value !== '';
                         } else {
                             isFilled = field.value.trim() !== '';
                         }

                         if (isFilled) filledFields++;
                     });

                     const percentage = totalFields > 0 ? Math.round((filledFields / totalFields) * 100) : 0;

                     // Mettre à jour un élément de progression s'il existe
                     const progressElement = document.querySelector('.progress-bar');
                     if (progressElement) {
                         progressElement.style.width = `${percentage}%`;
                         progressElement.textContent = `${percentage}%`;
                     }

                     // Afficher le pourcentage quelque part
                     const percentageElement = document.getElementById('progressPercentage');
                     if (percentageElement) {
                         percentageElement.textContent = `${percentage}%`;
                     }
                 };

                 // Écouter les changements sur les champs requis
                 form.querySelectorAll('[required]').forEach(field => {
                     field.addEventListener('input', updateProgress);
                     field.addEventListener('change', updateProgress);
                 });

                 updateProgress(); // Initialiser
             }

             // ============ FERMETURE DES ALERTES ============
             setTimeout(function() {
                 const alerts = document.querySelectorAll('.alert.alert-dismissible');
                 alerts.forEach(function(alert) {
                     const closeBtn = alert.querySelector('.btn-close');
                     if (closeBtn) {
                         closeBtn.click();
                     }
                 });
             }, 5000);
         });
     </script>
 @endpush


 {{-- <div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-hand-holding-heart fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Compléter le profil de votre association</h4>
                            <p class="mb-0 opacity-75">Une fois validé, vous pourrez recevoir des dons</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Veuillez corriger les erreurs suivantes :</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <div class="alert alert-info border-start border-5 border-info">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x text-info"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading mb-2">Informations importantes</h5>
                                <p class="mb-2">Votre compte association a été créé mais nécessite des informations supplémentaires pour être activé.</p>
                                <p class="mb-0"><strong>Après soumission :</strong> Notre équipe validera votre profil sous 24-48h. Vous recevrez une notification par email.</p>
                            </div>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('associations.complete-profile') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Informations Légales -->
                        <div class="section-card mb-4">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-gavel me-2"></i>
                                    Informations Légales
                                </h5>
                                <p class="section-subtitle">Informations officielles de votre association</p>
                            </div>
                            
                            <div class="row">
                                <!-- Nom légal -->
                                <div class="col-md-6 mb-3">
                                    <label for="legal_name" class="form-label fw-bold">
                                        Nom légal de l'association *
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('legal_name') is-invalid @enderror" 
                                           id="legal_name" 
                                           name="legal_name" 
                                           value="{{ old('legal_name') }}"
                                           required
                                           placeholder="Ex: Les Restos du Cœur">
                                    <div class="invalid-feedback">
                                        Le nom légal de l'association est requis.
                                    </div>
                                    @error('legal_name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Numéro d'enregistrement -->
                                <div class="col-md-6 mb-3">
                                    <label for="registration_number" class="form-label fw-bold">
                                        Numéro d'enregistrement
                                        <span class="text-muted fw-normal">(optionnel)</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('registration_number') is-invalid @enderror" 
                                           id="registration_number" 
                                           name="registration_number" 
                                           value="{{ old('registration_number') }}"
                                           placeholder="Ex: RNA W123456789">
                                    <small class="text-muted">Numéro RNA, SIRET, ou équivalent selon votre pays</small>
                                    @error('registration_number')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Personne de contact -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contact_person" class="form-label fw-bold">
                                        Personne de contact *
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('contact_person') is-invalid @enderror" 
                                           id="contact_person" 
                                           name="contact_person" 
                                           value="{{ old('contact_person') }}"
                                           required
                                           placeholder="Ex: Marie Dupont">
                                    <div class="invalid-feedback">
                                        La personne de contact est requise.
                                    </div>
                                    @error('contact_person')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Téléphone -->
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-bold">
                                        Téléphone de contact *
                                    </label>
                                    <input type="tel" 
                                           class="form-control form-control-lg @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}"
                                           required
                                           placeholder="Ex: 01 23 45 67 89">
                                    <div class="invalid-feedback">
                                        Un numéro de téléphone valide est requis.
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Description et Site web -->
                        <div class="section-card mb-4">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-align-left me-2"></i>
                                    Présentation
                                </h5>
                                <p class="section-subtitle">Décrivez votre association aux donateurs</p>
                            </div>
                            
                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">
                                    Description de votre association *
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="5" 
                                          required
                                          placeholder="Décrivez votre mission, vos activités, vos bénéficiaires...">{{ old('description') }}</textarea>
                                <div class="invalid-feedback">
                                    Une description de votre association est requise.
                                </div>
                                <small class="text-muted">Cette description sera visible par les donateurs.</small>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Site web -->
                            <div class="mb-3">
                                <label for="website" class="form-label fw-bold">
                                    Site web
                                    <span class="text-muted fw-normal">(optionnel)</span>
                                </label>
                                <input type="url" 
                                       class="form-control form-control-lg @error('website') is-invalid @enderror" 
                                       id="website" 
                                       name="website" 
                                       value="{{ old('website') }}"
                                       placeholder="https://www.votre-association.org">
                                @error('website')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Adresse -->
                        <div class="section-card mb-4">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    Adresse Légale
                                </h5>
                                <p class="section-subtitle">Adresse officielle de votre association</p>
                            </div>
                            
                            <div class="mb-3">
                                <label for="legal_address" class="form-label fw-bold">
                                    Adresse complète *
                                </label>
                                <textarea class="form-control @error('legal_address') is-invalid @enderror" 
                                          id="legal_address" 
                                          name="legal_address" 
                                          rows="3" 
                                          required
                                          placeholder="Numéro, rue, code postal, ville, pays">{{ old('legal_address') }}</textarea>
                                <div class="invalid-feedback">
                                    L'adresse légale est requise.
                                </div>
                                @error('legal_address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Besoins et Logistique -->
                        <div class="section-card mb-4">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-boxes me-2"></i>
                                    Logistique et Besoins
                                </h5>
                                <p class="section-subtitle">Comment recevez-vous les dons ?</p>
                            </div>


                            <!-- Section pour les besoins spécifiques (optionnel) -->
<div class="row">
    <!-- Type d'article -->
    <div class="col-md-6 mb-3">
        <label for="item_type" class="form-label fw-bold">
            Type d'article recherché
            <span class="text-muted fw-normal">(optionnel)</span>
        </label>
        <select class="form-control form-control-lg @error('item_type') is-invalid @enderror" 
                id="item_type" 
                name="item_type">
            <option value="">Sélectionnez un type</option>
            <option value="clothing" {{ old('item_type') == 'clothing' ? 'selected' : '' }}>Vêtements</option>
            <option value="shoes" {{ old('item_type') == 'shoes' ? 'selected' : '' }}>Chaussures</option>
            <option value="food" {{ old('item_type') == 'food' ? 'selected' : '' }}>Alimentaire</option>
            <option value="school" {{ old('item_type') == 'school' ? 'selected' : '' }}>Scolaire</option>
            <option value="furniture" {{ old('item_type') == 'furniture' ? 'selected' : '' }}>Meubles</option>
            <option value="other" {{ old('item_type') == 'other' ? 'selected' : '' }}>Autre</option>
        </select>
        @error('item_type')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- Niveau scolaire (si type scolaire) -->
    <div class="col-md-6 mb-3">
        <label for="school_level" class="form-label fw-bold">
            Niveau scolaire
            <span class="text-muted fw-normal">(optionnel)</span>
        </label>
        <input type="text" 
               class="form-control form-control-lg @error('school_level') is-invalid @enderror" 
               id="school_level" 
               name="school_level" 
               value="{{ old('school_level') }}"
               placeholder="Ex: Primaire, Collège, Lycée">
        @error('school_level')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Quantité et condition -->
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="quantity" class="form-label fw-bold">
            Quantité souhaitée
            <span class="text-muted fw-normal">(optionnel)</span>
        </label>
        <input type="number" 
               class="form-control form-control-lg @error('quantity') is-invalid @enderror" 
               id="quantity" 
               name="quantity" 
               value="{{ old('quantity', 1) }}"
               min="1"
               max="1000">
        @error('quantity')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="condition" class="form-label fw-bold">
            Condition acceptée
            <span class="text-muted fw-normal">(optionnel)</span>
        </label>
        <select class="form-control form-control-lg @error('condition') is-invalid @enderror" 
                id="condition" 
                name="condition">
            <option value="">Toutes conditions</option>
            <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Neuf</option>
            <option value="very_good" {{ old('condition') == 'very_good' ? 'selected' : '' }}>Très bon état</option>
            <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Bon état</option>
            <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Usé mais fonctionnel</option>
        </select>
        @error('condition')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
                            
                            <!-- Description des besoins -->
                            <div class="mb-4">
                                <label for="needs_description" class="form-label fw-bold">
                                    Description de vos besoins actuels
                                    <span class="text-muted fw-normal">(optionnel)</span>
                                </label>
                                <textarea class="form-control @error('needs_description') is-invalid @enderror" 
                                          id="needs_description" 
                                          name="needs_description" 
                                          rows="4"
                                          placeholder="Décrivez les types de dons dont vous avez besoin (vêtements, alimentaire, etc.)">{{ old('needs_description') }}</textarea>
                                <small class="text-muted">Cette information aide les donateurs à savoir ce dont vous avez besoin.</small>
                                @error('needs_description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Options de réception -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="accepts_direct_delivery" 
                                               name="accepts_direct_delivery" 
                                               value="1"
                                               {{ old('accepts_direct_delivery', 1) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="accepts_direct_delivery">
                                            <i class="fas fa-truck me-2"></i>
                                            Acceptez-vous les livraisons directes ?
                                        </label>
                                        <p class="text-muted small mb-0">Le donateur vient livrer directement à votre association</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="accepts_collection_points" 
                                               name="accepts_collection_points" 
                                               value="1"
                                               {{ old('accepts_collection_points') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="accepts_collection_points">
                                            <i class="fas fa-map-pin me-2"></i>
                                            Utilisez-vous des points de collecte ?
                                        </label>
                                        <p class="text-muted small mb-0">Vous disposez de points de dépôt fixes</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Rayon de livraison -->
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="delivery_radius" class="form-label fw-bold">
                                        Rayon d'acceptation (en km)
                                        <span class="text-muted fw-normal">(optionnel)</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control form-control-lg @error('delivery_radius') is-invalid @enderror" 
                                               id="delivery_radius" 
                                               name="delivery_radius" 
                                               value="{{ old('delivery_radius') }}"
                                               min="0"
                                               max="200"
                                               placeholder="Ex: 20">
                                        <span class="input-group-text">km</span>
                                    </div>
                                    <small class="text-muted">Dans quel rayon acceptez-vous les dons ? (0 = seulement à votre adresse)</small>
                                    @error('delivery_radius')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Horaires d'ouverture -->
                                <div class="col-md-6">
                                    <label for="opening_hours" class="form-label fw-bold">
                                        Horaires d'ouverture
                                        <span class="text-muted fw-normal">(optionnel)</span>
                                    </label>
                                    <textarea class="form-control @error('opening_hours') is-invalid @enderror" 
                                              id="opening_hours" 
                                              name="opening_hours" 
                                              rows="2"
                                              placeholder="Ex: Lun-Ven: 9h-12h, 14h-17h">{{ old('opening_hours') }}</textarea>
                                    @error('opening_hours')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Logo et Document -->
                        <div class="section-card mb-4">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-file-upload me-2"></i>
                                    Documents
                                </h5>
                                <p class="section-subtitle">Logo et justificatif pour validation</p>
                            </div>
                            
                            <div class="row">
                                <!-- Logo -->
                                <div class="col-md-6 mb-3">
                                    <label for="logo" class="form-label fw-bold">
                                        Logo de l'association
                                        <span class="text-muted fw-normal">(optionnel)</span>
                                    </label>
                                    <div class="file-upload-area">
                                        <input type="file" 
                                               class="form-control @error('logo') is-invalid @enderror" 
                                               id="logo" 
                                               name="logo"
                                               accept="image/*"
                                               onchange="previewLogo(event)">
                                        <div class="mt-2 text-center">
                                            <img id="logoPreview" src="{{ asset('assets/images/default-logo.png') }}" 
                                                 alt="Aperçu du logo" 
                                                 class="img-thumbnail mt-2" 
                                                 style="max-height: 150px; display: none;">
                                        </div>
                                        <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF. Max: 2MB</small>
                                        @error('logo')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Document de vérification -->
                                <div class="col-md-6 mb-3">
                                    <label for="verification_document" class="form-label fw-bold">
                                        Justificatif légal *
                                    </label>
                                    <div class="file-upload-area">
                                        <input type="file" 
                                               class="form-control @error('verification_document') is-invalid @enderror" 
                                               id="verification_document" 
                                               name="verification_document"
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               required>
                                        <div class="invalid-feedback">
                                            Un justificatif légal est requis pour la validation.
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Statuts, récépissé de déclaration, extrait Kbis, etc.
                                        </small>
                                        <small class="text-muted">Format: PDF, JPG, PNG. Max: 5MB</small>
                                        @error('verification_document')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

<!-- Section Préférences de notification -->
<div class="section-card mb-4">
    <div class="section-header">
        <h5 class="section-title">
            <i class="fas fa-bell me-2"></i>
            Préférences de notification
        </h5>
        <p class="section-subtitle">Choisissez comment vous souhaitez être informé</p>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <h6 class="mb-3">Notifications par email</h6>
            
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" 
                       type="checkbox" 
                       id="email_new_donations" 
                       name="notification_settings[email_new_donations]" 
                       value="1"
                       {{ old('notification_settings.email_new_donations', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="email_new_donations">
                    Nouveaux dons disponibles
                </label>
                <small class="text-muted d-block">Recevoir un email quand de nouveaux dons sont postés</small>
            </div>
            
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" 
                       type="checkbox" 
                       id="email_messages" 
                       name="notification_settings[email_messages]" 
                       value="1"
                       {{ old('notification_settings.email_messages', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="email_messages">
                    Nouveaux messages
                </label>
                <small class="text-muted d-block">Recevoir un email quand vous recevez un message</small>
            </div>
            
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" 
                       type="checkbox" 
                       id="email_requests" 
                       name="notification_settings[email_requests]" 
                       value="1"
                       {{ old('notification_settings.email_requests', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="email_requests">
                    Demandes de dons
                </label>
                <small class="text-muted d-block">Recevoir un email pour les nouvelles demandes</small>
            </div>
        </div>
        
        <div class="col-md-6">
            <h6 class="mb-3">Notifications push (si application mobile)</h6>
            
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" 
                       type="checkbox" 
                       id="push_new_donations" 
                       name="notification_settings[push_new_donations]" 
                       value="1"
                       {{ old('notification_settings.push_new_donations', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="push_new_donations">
                    Nouveaux dons disponibles
                </label>
                <small class="text-muted d-block">Notification push pour les nouveaux dons</small>
            </div>
            
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" 
                       type="checkbox" 
                       id="push_messages" 
                       name="notification_settings[push_messages]" 
                       value="1"
                       {{ old('notification_settings.push_messages', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="push_messages">
                    Nouveaux messages
                </label>
                <small class="text-muted d-block">Notification push pour les messages</small>
            </div>
        </div>
    </div>
</div>

<!-- Section Système de messagerie -->
<div class="section-card mb-4">
    <div class="section-header">
        <h5 class="section-title">
            <i class="fas fa-comments me-2"></i>
            Préférences de messagerie
        </h5>
        <p class="section-subtitle">Configurez comment vous communiquez avec les donateurs</p>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="default_message_template" class="form-label fw-bold">
                Modèle de message par défaut
                <span class="text-muted fw-normal">(optionnel)</span>
            </label>
            <textarea class="form-control @error('messaging_preferences.default_message_template') is-invalid @enderror" 
                      id="default_message_template" 
                      name="messaging_preferences[default_message_template]" 
                      rows="4"
                      placeholder="Bonjour, merci pour votre don ! Nous vous contacterons pour organiser la récupération...">{{ old('messaging_preferences.default_message_template') }}</textarea>
            @error('messaging_preferences.default_message_template')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="text-muted">Ce message sera utilisé automatiquement pour remercier les donateurs</small>
        </div>
        
        <div class="col-md-6">
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" 
                       type="checkbox" 
                       id="auto_reply_enabled" 
                       name="messaging_preferences[auto_reply_enabled]" 
                       value="1"
                       {{ old('messaging_preferences.auto_reply_enabled', true) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="auto_reply_enabled">
                    Réponse automatique activée
                </label>
                <p class="text-muted small mb-0">Envoyer automatiquement un message de remerciement</p>
            </div>
            
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" 
                       type="checkbox" 
                       id="notify_on_message" 
                       name="messaging_preferences[notify_on_message]" 
                       value="1"
                       {{ old('messaging_preferences.notify_on_message', true) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="notify_on_message">
                    Notifier par email pour chaque message
                </label>
                <p class="text-muted small mb-0">Recevoir un email à chaque nouveau message</p>
            </div>
        </div>
    </div>
</div>

     <!-- Section Évaluations et signalements -->
<div class="section-card mb-4">
    <div class="section-header">
        <h5 class="section-title">
            <i class="fas fa-star me-2"></i>
            Évaluations et signalements
        </h5>
        <p class="section-subtitle">Configurez vos préférences d'évaluation</p>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="review_preferences" class="form-label fw-bold">
                Politique d'évaluation
                <span class="text-muted fw-normal">(optionnel)</span>
            </label>
            <select class="form-control form-control-lg @error('review_preferences.auto_request_review') is-invalid @enderror" 
                    id="review_preferences" 
                    name="review_preferences[auto_request_review]">
                <option value="">Ne pas demander automatiquement</option>
                <option value="1" {{ old('review_preferences.auto_request_review') == '1' ? 'selected' : '' }}>
                    Demander une évaluation après chaque don livré
                </option>
                <option value="7" {{ old('review_preferences.auto_request_review') == '7' ? 'selected' : '' }}>
                    Demander une évaluation 7 jours après livraison
                </option>
                <option value="14" {{ old('review_preferences.auto_request_review') == '14' ? 'selected' : '' }}>
                    Demander une évaluation 14 jours après livraison
                </option>
            </select>
            @error('review_preferences.auto_request_review')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="text-muted">Quand demander une évaluation aux donateurs</small>
        </div>
        
        <div class="col-md-6">
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" 
                       type="checkbox" 
                       id="show_ratings_public" 
                       name="review_preferences[show_ratings_public]" 
                       value="1"
                       {{ old('review_preferences.show_ratings_public', true) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="show_ratings_public">
                    Afficher les évaluations publiquement
                </label>
                <p class="text-muted small mb-0">Montrer vos notes moyennes sur votre profil</p>
            </div>
            
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" 
                       type="checkbox" 
                       id="auto_report_issues" 
                       name="review_preferences[auto_report_issues]" 
                       value="1"
                       {{ old('review_preferences.auto_report_issues', false) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="auto_report_issues">
                    Signaler automatiquement les problèmes
                </label>
                <p class="text-muted small mb-0">Créer un signalement pour les dons problématiques</p>
            </div>
        </div>
    </div>
</div>
                        <!-- Section pour les demandes spécifiques (optionnel) -->
<div class="section-card mb-4">
    <div class="section-header">
        <h5 class="section-title">
            <i class="fas fa-bullhorn me-2"></i>
            Demande spécifique
        </h5>
        <p class="section-subtitle">Publiez une demande spécifique de don</p>
    </div>
    
    <div class="mb-3">
        <label for="request_title" class="form-label fw-bold">
            Titre de la demande
            <span class="text-muted fw-normal">(optionnel)</span>
        </label>
        <input type="text" 
               class="form-control form-control-lg @error('request_title') is-invalid @enderror" 
               id="request_title" 
               name="request_title" 
               value="{{ old('request_title') }}"
               placeholder="Ex: Besoin urgent de couvertures pour l'hiver">
        @error('request_title')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="request_message" class="form-label fw-bold">
            Message aux donateurs
            <span class="text-muted fw-normal">(optionnel)</span>
        </label>
        <textarea class="form-control @error('request_message') is-invalid @enderror" 
                  id="request_message" 
                  name="request_message" 
                  rows="4"
                  placeholder="Expliquez votre besoin spécifique...">{{ old('request_message') }}</textarea>
        @error('request_message')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
                        
                        <!-- Boutons -->
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <div>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Se déconnecter
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                            
                            <div class="d-flex gap-3">
                                <button type="reset" class="btn btn-lg btn-outline-primary">
                                    <i class="fas fa-redo me-2"></i>
                                    Annuler
                                </button>
                                <button type="submit" class="btn btn-lg btn-primary px-5">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Soumettre pour validation
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light text-center py-3">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt me-1"></i>
                        Vos données sont protégées conformément à notre 
                        <a href="{{ route('privacy') }}" class="text-decoration-none">Politique de Confidentialité</a>.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .section-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        border-left: 4px solid #4e73df;
    }
    
    .section-header {
        margin-bottom: 25px;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 15px;
    }
    
    .section-title {
        color: #2e59d9;
        font-weight: 600;
    }
    
    .section-subtitle {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 0;
    }
    
    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }
    
    .file-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 20px;
        background: white;
        transition: all 0.3s ease;
    }
    
    .file-upload-area:hover {
        border-color: #4e73df;
        background: #f8f9ff;
    }
    
    .form-check-input:checked {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    
    .form-check-label {
        font-size: 1rem;
    }
    
    .card-header {
        border-radius: 10px 10px 0 0;
        padding: 1.5rem 2rem;
    }
    
    .btn-lg {
        padding: 0.75rem 2rem;
        font-weight: 500;
    }

/* Styles pour les sections supplémentaires */
.radius-info {
    font-style: italic;
}

.message-preview {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
}

.progress {
    border-radius: 5px;
    overflow: hidden;
}

.progress-bar {
    transition: width 0.5s ease;
    font-size: 10px;
    line-height: 10px;
}

/* Groupes de préférences */
.preference-group {
    background: white;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    border: 1px solid #e3e6f0;
}

.preference-group h6 {
    color: #4e73df;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e3e6f0;
}

/* Style pour les switches */
.form-switch .form-check-input {
    width: 3em;
    margin-right: 10px;
}

.form-switch .form-check-label {
    font-weight: 500;
    cursor: pointer;
}

/* Indicateurs visuels */
.indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 5px;
}

.indicator-required {
    background-color: #e74a3b;
}

.indicator-optional {
    background-color: #f6c23e;
}

/* Tooltips personnalisés */
.custom-tooltip {
    position: relative;
    display: inline-block;
    margin-left: 5px;
    color: #6c757d;
    cursor: help;
}

.custom-tooltip .tooltip-text {
    visibility: hidden;
    width: 200px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -100px;
    opacity: 0;
    transition: opacity 0.3s;
    font-size: 12px;
}

.custom-tooltip:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
}


</style>
@endpush

@push('scripts')
<script>
    // Aperçu du logo
    function previewLogo(event) {
        const preview = document.getElementById('logoPreview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }
    
    // Validation Bootstrap
    (function () {
        'use strict'
        
        var forms = document.querySelectorAll('.needs-validation')
        
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    
                    form.classList.add('was-validated')
                }, false)
            })
    })()
    
    // Masquer les alertes après 5 secondes
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    })
    
    // Aperçu du document
    function previewDocument(event) {
        const file = event.target.files[0];
        const previewArea = document.getElementById('documentPreview');
        
        if (!previewArea) {
            const newPreview = document.createElement('div');
            newPreview.id = 'documentPreview';
            newPreview.className = 'mt-2';
            event.target.parentNode.appendChild(newPreview);
        }
        
        const preview = document.getElementById('documentPreview');
        
        if (file) {
            if (file.type === 'application/pdf') {
                preview.innerHTML = `
                <div class="alert alert-info">
                        <i class="fas fa-file-pdf me-2"></i>
                        ${file.name} (PDF)
                        <div class="small">Taille: ${(file.size / 1024 / 1024).toFixed(2)} MB</div>
                    </div>
                `;
            } else if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="alert alert-info">
                            <i class="fas fa-file-image me-2"></i>
                            ${file.name} (Image)
                            <div class="small">Taille: ${(file.size / 1024 / 1024).toFixed(2)} MB</div>
                            <img src="${e.target.result}" class="img-thumbnail mt-2" style="max-height: 100px;">
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = `
                    <div class="alert alert-warning">
                        <i class="fas fa-file me-2"></i>
                        ${file.name}
                        <div class="small">Format non prévisualisable</div>
                    </div>
                `;
            }
        } else {
            preview.innerHTML = '';
        }
    }
    
    // Attacher l'événement au document
    document.addEventListener('DOMContentLoaded', function() {
        const docInput = document.getElementById('verification_document');
        if (docInput) {
            docInput.addEventListener('change', previewDocument);
        }
    });
// Gestion des préférences de notification
document.addEventListener('DOMContentLoaded', function() {
    // Synchroniser les cases à cocher similaires
    const syncCheckboxes = (sourceId, targetId) => {
        const source = document.getElementById(sourceId);
        const target = document.getElementById(targetId);
        
        if (source && target) {
            source.addEventListener('change', function() {
                target.checked = this.checked;
            });
        }
    };
    
    // Synchroniser email et push pour "Nouveaux dons"
    syncCheckboxes('email_new_donations', 'push_new_donations');
    
    // Synchroniser email et push pour "Messages"
    syncCheckboxes('email_messages', 'push_messages');
    
    // Gestion de l'aperçu du template de message
    const messageTemplate = document.getElementById('default_message_template');
    const previewBtn = document.createElement('button');
    previewBtn.type = 'button';
    previewBtn.className = 'btn btn-sm btn-outline-secondary mt-2';
    previewBtn.innerHTML = '<i class="fas fa-eye me-1"></i> Aperçu';
    
    previewBtn.addEventListener('click', function() {
        const template = messageTemplate.value;
        if (template) {
            const preview = `
                <div class="alert alert-info mt-2">
                    <h6>Aperçu du message :</h6>
                    <div class="message-preview p-3 bg-white rounded border">
                        ${template.replace(/\n/g, '<br>')}
                    </div>
                    <small class="text-muted">Ce message sera envoyé automatiquement aux donateurs</small>
                </div>
            `;
            
            // Afficher ou mettre à jour l'aperçu
            let previewContainer = document.getElementById('messagePreview');
            if (!previewContainer) {
                previewContainer = document.createElement('div');
                previewContainer.id = 'messagePreview';
                messageTemplate.parentNode.appendChild(previewContainer);
            }
            previewContainer.innerHTML = preview;
        }
    });
    
    if (messageTemplate) {
        messageTemplate.parentNode.appendChild(previewBtn);
    }
    
    // Calcul du rayon de livraison estimé
    const deliveryRadius = document.getElementById('delivery_radius');
    const radiusInfo = document.createElement('div');
    radiusInfo.className = 'radius-info small text-muted mt-1';
    
    if (deliveryRadius) {
        deliveryRadius.parentNode.appendChild(radiusInfo);
        
        const updateRadiusInfo = () => {
            const value = deliveryRadius.value;
            if (!value) {
                radiusInfo.textContent = 'Aucun rayon défini - Seulement à votre adresse';
            } else if (value == 0) {
                radiusInfo.textContent = 'Seulement à votre adresse exacte';
            } else if (value <= 5) {
                radiusInfo.textContent = `Rayon réduit (${value} km) - Quartier proche`;
            } else if (value <= 20) {
                radiusInfo.textContent = `Rayon moyen (${value} km) - Ville et proche banlieue`;
            } else if (value <= 50) {
                radiusInfo.textContent = `Grand rayon (${value} km) - Département`;
            } else {
                radiusInfo.textContent = `Très grand rayon (${value} km) - Région`;
            }
        };
        
        deliveryRadius.addEventListener('input', updateRadiusInfo);
        deliveryRadius.addEventListener('change', updateRadiusInfo);
        updateRadiusInfo();
    }
    
    // Indicateur de progression
    const form = document.querySelector('form');
    const progressBar = document.createElement('div');
    progressBar.className = 'progress mb-4';
    progressBar.style.height = '10px';
    progressBar.innerHTML = `
        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
    `;
    
    if (form) {
        form.insertBefore(progressBar, form.firstChild);
        
        const updateProgress = () => {
            const requiredFields = form.querySelectorAll('[required]');
            const filledFields = Array.from(requiredFields).filter(field => {
                if (field.type === 'checkbox') return field.checked;
                if (field.type === 'file') return field.files.length > 0;
                return field.value.trim() !== '';
            });
            
            const percentage = Math.round((filledFields.length / requiredFields.length) * 100);
            const progressBarElement = progressBar.querySelector('.progress-bar');
            
            progressBarElement.style.width = `${percentage}%`;
            progressBarElement.textContent = `${percentage}%`;
            
            // Changer la couleur selon le pourcentage
            progressBarElement.classList.remove('bg-danger', 'bg-warning', 'bg-info', 'bg-success');
            if (percentage < 25) {
                progressBarElement.classList.add('bg-danger');
            } else if (percentage < 50) {
                progressBarElement.classList.add('bg-warning');
            } else if (percentage < 75) {
                progressBarElement.classList.add('bg-info');
            } else {
                progressBarElement.classList.add('bg-success');
            }
        };
        
        // Écouter les changements sur tous les champs
        form.querySelectorAll('input, textarea, select').forEach(field => {
            field.addEventListener('input', updateProgress);
            field.addEventListener('change', updateProgress);
        });
        
        updateProgress(); // Initialiser
    }
});
    
</script>


@endpush --}}
