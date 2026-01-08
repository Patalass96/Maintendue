@extends('layouts.association')

@section('title', 'Modifier mon profil - Main Tendue')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4">
            @include('association.partials.sidebar')
        </div>
        
        <!-- Main content -->
        <div class="col-lg-9 col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Modifier mon profil</h2>
                <a href="{{ route('association.profile') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
            </div>
            
            <form action="{{ route('association.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Informations générales -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informations générales</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          required>{{ old('description', $association->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Décrivez votre association pour les donateurs</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="needs_description" class="form-label">Besoins actuels</label>
                                <textarea class="form-control @error('needs_description') is-invalid @enderror" 
                                          id="needs_description" 
                                          name="needs_description" 
                                          rows="4">{{ old('needs_description', $association->needs_description) }}</textarea>
                                @error('needs_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Quels types de dons recherchez-vous ?</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Téléphone *</label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $association->phone) }}"
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="website" class="form-label">Site web</label>
                                <input type="url" 
                                       class="form-control @error('website') is-invalid @enderror" 
                                       id="website" 
                                       name="website" 
                                       value="{{ old('website', $association->website) }}">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Logistique -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Logistique</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="delivery_radius" class="form-label">Rayon d'acceptation (km)</label>
                                <input type="number" 
                                       class="form-control @error('delivery_radius') is-invalid @enderror" 
                                       id="delivery_radius" 
                                       name="delivery_radius" 
                                       value="{{ old('delivery_radius', $association->delivery_radius) }}"
                                       min="0" 
                                       max="200">
                                @error('delivery_radius')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">0 = seulement à votre adresse</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="opening_hours" class="form-label">Horaires d'ouverture</label>
                                <input type="text" 
                                       class="form-control @error('opening_hours') is-invalid @enderror" 
                                       id="opening_hours" 
                                       name="opening_hours" 
                                       value="{{ old('opening_hours', $association->opening_hours) }}"
                                       placeholder="Ex: Lun-Ven: 9h-12h, 14h-17h">
                                @error('opening_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="accepts_direct_delivery" 
                                           name="accepts_direct_delivery" 
                                           value="1"
                                           {{ old('accepts_direct_delivery', $association->accepts_direct_delivery) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="accepts_direct_delivery">
                                        Acceptez-vous les livraisons directes ?
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="accepts_collection_points" 
                                           name="accepts_collection_points" 
                                           value="1"
                                           {{ old('accepts_collection_points', $association->accepts_collection_points) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="accepts_collection_points">
                                        Disposez-vous de points de collecte ?
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Logo -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Logo</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if($association->logo)
                                    <div class="mb-3">
                                        <label class="form-label">Logo actuel</label>
                                        <div>
                                            <img src="{{ asset('storage/' . $association->logo) }}" 
                                                 alt="Logo actuel" 
                                                 class="img-thumbnail"
                                                 width="150">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">
                                        {{ $association->logo ? 'Changer le logo' : 'Ajouter un logo' }}
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('logo') is-invalid @enderror" 
                                           id="logo" 
                                           name="logo"
                                           accept="image/*">
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                                </div>
                                
                                @if($association->logo)
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="remove_logo" 
                                               name="remove_logo" 
                                               value="1">
                                        <label class="form-check-label text-danger" for="remove_logo">
                                            Supprimer le logo actuel
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Boutons -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('association.profile') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Edit Profile Form */
    .edit-profile-form .form-section {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        border: 1px solid #e3e6f0;
    }
    
    .edit-profile-form .section-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #4e73df;
    }
    
    .edit-profile-form .section-title {
        color: #2e59d9;
        font-weight: 600;
        font-size: 1.3rem;
        margin: 0;
    }
    
    .edit-profile-form .section-icon {
        width: 40px;
        height: 40px;
        background: #4e73df;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 1rem;
    }
    
    /* Form controls */
    .edit-profile-form .form-label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 0.5rem;
    }
    
    .edit-profile-form .form-control,
    .edit-profile-form .form-select {
        border: 1px solid #d1d3e2;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s;
    }
    
    .edit-profile-form .form-control:focus,
    .edit-profile-form .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .edit-profile-form .form-control.is-invalid {
        border-color: #e74a3b;
    }
    
    .edit-profile-form .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    /* Logo upload */
    .logo-upload-container {
        border: 2px dashed #d1d3e2;
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        background: #f8f9fc;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .logo-upload-container:hover {
        border-color: #4e73df;
        background: #f0f3ff;
    }
    
    .logo-upload-container.dragover {
        border-color: #1cc88a;
        background: #f0fff4;
    }
    
    .logo-upload-icon {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }
    
    .logo-upload-container:hover .logo-upload-icon {
        color: #4e73df;
    }
    
    .logo-preview {
        width: 150px;
        height: 150px;
        border-radius: 10px;
        overflow: hidden;
        margin: 0 auto 1rem;
        border: 2px solid #e3e6f0;
    }
    
    .logo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Switch controls */
    .switch-container {
        background: #f8f9fc;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .form-switch-lg .form-check-input {
        width: 3.5em;
        height: 1.75em;
        margin-right: 0.75rem;
    }
    
    .form-switch-lg .form-check-label {
        font-size: 1.1rem;
        font-weight: 500;
    }
    
    /* Help text */
    .form-text-help {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.25rem;
        display: block;
    }
    
    /* Form actions */
    .form-actions {
        background: #f8f9fc;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    /* Tags input (pour les besoins) */
    .tags-input-container {
        border: 1px solid #d1d3e2;
        border-radius: 8px;
        padding: 0.5rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        min-height: 46px;
    }
    
    .tags-input-container:focus-within {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .tag {
        background: #e3f2fd;
        color: #1565c0;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        margin: 0.25rem;
        display: inline-flex;
        align-items: center;
        font-size: 0.875rem;
    }
    
    .tag-remove {
        margin-left: 0.5rem;
        cursor: pointer;
        opacity: 0.7;
    }
    
    .tag-remove:hover {
        opacity: 1;
    }
    
    .tags-input {
        border: none;
        outline: none;
        flex: 1;
        min-width: 100px;
        padding: 0.25rem;
        background: transparent;
    }
    
    /* Character counter */
    .char-counter-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
    }
    
    .char-counter {
        font-size: 0.75rem;
        color: #6c757d;
    }
    
    .char-counter.warning {
        color: #f6c23e;
    }
    
    .char-counter.danger {
        color: #e74a3b;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .edit-profile-form .form-section {
            padding: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 1rem;
        }
        
        .form-actions .btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de l'upload du logo
        const logoInput = document.getElementById('logo');
        const logoContainer = document.querySelector('.logo-upload-container');
        const logoPreview = document.querySelector('.logo-preview');
        
        if (logoInput && logoContainer) {
            // Drag and drop
            logoContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });
            
            logoContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });
            
            logoContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                
                if (e.dataTransfer.files.length) {
                    logoInput.files = e.dataTransfer.files;
                    updateLogoPreview();
                }
            });
            
            // Click to upload
            logoContainer.addEventListener('click', function() {
                logoInput.click();
            });
            
            // Change event
            logoInput.addEventListener('change', updateLogoPreview);
        }
        
        function updateLogoPreview() {
            if (logoInput.files && logoInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (!logoPreview) {
                        const preview = document.createElement('div');
                        preview.className = 'logo-preview';
                        preview.innerHTML = `<img src="${e.target.result}" alt="Logo preview">`;
                        logoContainer.insertBefore(preview, logoContainer.firstChild);
                    } else {
                        logoPreview.innerHTML = `<img src="${e.target.result}" alt="Logo preview">`;
                    }
                    
                    // Mettre à jour le texte
                    const uploadText = logoContainer.querySelector('p');
                    if (uploadText) {
                        uploadText.textContent = 'Cliquez ou glissez pour changer le logo';
                    }
                };
                reader.readAsDataURL(logoInput.files[0]);
            }
        }
        
        // Système de tags pour les besoins
        const needsInput = document.getElementById('needs_tags');
        if (needsInput) {
            const tagsContainer = document.createElement('div');
            tagsContainer.className = 'tags-input-container';
            
            // Créer les tags existants
            const existingTags = needsInput.value.split(',').filter(tag => tag.trim());
            existingTags.forEach(tag => {
                addTag(tag.trim());
            });
            
            // Créer l'input
            const tagInput = document.createElement('input');
            tagInput.type = 'text';
            tagInput.className = 'tags-input';
            tagInput.placeholder = 'Ajouter un besoin...';
            
            tagsContainer.appendChild(tagInput);
            
            // Remplacer l'input original
            needsInput.parentNode.insertBefore(tagsContainer, needsInput);
            needsInput.style.display = 'none';
            
            tagInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    const tag = this.value.trim();
                    if (tag) {
                        addTag(tag);
                        this.value = '';
                        updateHiddenInput();
                    }
                }
                
                if (e.key === 'Backspace' && !this.value) {
                    const tags = tagsContainer.querySelectorAll('.tag');
                    if (tags.length > 0) {
                        tags[tags.length - 1].remove();
                        updateHiddenInput();
                    }
                }
            });
            
            function addTag(text) {
                const tag = document.createElement('span');
                tag.className = 'tag';
                tag.innerHTML = `
                    ${text}
                    <span class="tag-remove">&times;</span>
                `;
                
                tag.querySelector('.tag-remove').addEventListener('click', function() {
                    tag.remove();
                    updateHiddenInput();
                });
                
                tagsContainer.insertBefore(tag, tagInput);
            }
            
            function updateHiddenInput() {
                const tags = Array.from(tagsContainer.querySelectorAll('.tag'))
                    .map(tag => tag.childNodes[0].textContent.trim());
                needsInput.value = tags.join(',');
            }
        }
        
        // Compteur de caractères pour la description
        const descriptionInput = document.getElementById('description');
        if (descriptionInput) {
            const counterContainer = document.createElement('div');
            counterContainer.className = 'char-counter-container';
            
            const counter = document.createElement('span');
            counter.className = 'char-counter';
            
            const maxLength = 2000;
            counter.textContent = `${descriptionInput.value.length}/${maxLength}`;
            
            counterContainer.appendChild(counter);
            descriptionInput.parentNode.appendChild(counterContainer);
            
            descriptionInput.addEventListener('input', function() {
                const length = this.value.length;
                counter.textContent = `${length}/${maxLength}`;
                
                counter.classList.remove('warning', 'danger');
                if (length > maxLength * 0.9) {
                    counter.classList.add('warning');
                }
                if (length > maxLength) {
                    counter.classList.add('danger');
                    this.value = this.value.substring(0, maxLength);
                    counter.textContent = `${maxLength}/${maxLength}`;
                }
            });
        }
        
        // Validation en temps réel
        const form = document.getElementById('editProfileForm');
        if (form) {
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
                    validateField(this);
                });
                
                field.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        validateField(this);
                    }
                });
            });
            
            function validateField(field) {
                const value = field.value.trim();
                const feedback = field.parentNode.querySelector('.invalid-feedback');
                
                if (!value && field.required) {
                    field.classList.add('is-invalid');
                    if (feedback) feedback.style.display = 'block';
                } else {
                    field.classList.remove('is-invalid');
                    if (feedback) feedback.style.display = 'none';
                }
            }
            
            // Soumission du formulaire
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim() && field.required) {
                        field.classList.add('is-invalid');
                        isValid = false;
                        
                        // Scroll vers le premier champ invalide
                        if (isValid === false) {
                            field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs obligatoires.');
                }
            });
        }
        
        // Sauvegarde automatique (draft)
        let saveTimeout;
        const formData = new FormData();
        
        function autoSave() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                // Collecter les données du formulaire
                const data = new FormData(form);
                
                // Envoyer une requête AJAX de sauvegarde
                fetch('{{ route("association.profile.autosave") }}', {
                    method: 'POST',
                    body: data,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAutoSaveNotification();
                    }
                })
                .catch(error => console.error('Erreur de sauvegarde:', error));
            }, 2000);
        }
        
        function showAutoSaveNotification() {
            const notification = document.createElement('div');
            notification.className = 'alert alert-info alert-dismissible fade show';
            notification.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                opacity: 0.9;
            `;
            
            notification.innerHTML = `
                <i class="fas fa-save me-2"></i>
                Progression sauvegardée automatiquement
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }
        
        // Activer la sauvegarde automatique si nécessaire
        if (form) {
            form.addEventListener('input', autoSave);
            form.addEventListener('change', autoSave);
        }
    });
</script>
@endpush
@endsection