// DONATEUR.JS - JavaScript spécifique au layout Donateur
// S'exécute uniquement sur les pages donateur

(function() {
    // Vérifie si on est sur une page donateur
    const isDonateurLayout = document.querySelector('.donateur-layout');
    if (!isDonateurLayout) return;
    
    console.log('Donateur JS initialisé');
    
    // ==== FONCTIONS DONATEUR ====
    
    // Gestion du menu utilisateur
    function initUserMenu() {
        const userProfile = document.querySelector('.donateur-user-profile');
        const userDropdown = document.querySelector('.donateur-user-dropdown');
        
        if (userProfile && userDropdown) {
            userProfile.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('show');
            });
            
            // Fermer en cliquant ailleurs
            document.addEventListener('click', function() {
                userDropdown.classList.remove('show');
            });
            
            // Empêcher la fermeture quand on clique dans le dropdown
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    }
    
    // Gestion des notifications
    function initNotifications() {
        const notifBtn = document.querySelector('.donateur-btn-notif');
        if (notifBtn) {
            notifBtn.addEventListener('click', function() {
                // Ici, tu pourrais ouvrir un modal de notifications
                console.log('Notifications donateur');
            });
        }
    }
    
    // Publication de don
    function initPublishDonation() {
        const publishForm = document.querySelector('.donation-publish-form');
        if (publishForm) {
            // Upload d'images
            const imageUpload = document.getElementById('donation-images');
            const imagePreview = document.getElementById('image-preview');
            
            if (imageUpload && imagePreview) {
                imageUpload.addEventListener('change', function(e) {
                    imagePreview.innerHTML = '';
                    Array.from(e.target.files).forEach((file, index) => {
                        if (index < 5) { // Limite à 5 images
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const imgContainer = document.createElement('div');
                                imgContainer.className = 'image-preview-item';
                                imgContainer.innerHTML = `
                                    <img src="${e.target.result}" alt="Preview">
                                    <button type="button" class="remove-image" data-index="${index}">×</button>
                                `;
                                imagePreview.appendChild(imgContainer);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                    
                    // Gestion de la suppression d'images
                    imagePreview.addEventListener('click', function(e) {
                        if (e.target.classList.contains('remove-image')) {
                            const index = e.target.dataset.index;
                            e.target.closest('.image-preview-item').remove();
                            
                            // Mise à jour du champ file
                            const dt = new DataTransfer();
                            const files = imageUpload.files;
                            
                            for (let i = 0; i < files.length; i++) {
                                if (i != index) {
                                    dt.items.add(files[i]);
                                }
                            }
                            
                            imageUpload.files = dt.files;
                        }
                    });
                });
            }
            
            // Validation du formulaire
            publishForm.addEventListener('submit', function(e) {
                const title = this.querySelector('input[name="title"]');
                const category = this.querySelector('select[name="category"]');
                
                if (!title.value.trim()) {
                    e.preventDefault();
                    alert('Veuillez saisir un titre pour votre don');
                    title.focus();
                    return;
                }
                
                if (!category.value) {
                    e.preventDefault();
                    alert('Veuillez sélectionner une catégorie');
                    category.focus();
                    return;
                }
                
                // Afficher un loader
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Publication en cours...';
                submitBtn.disabled = true;
                
                // Réactiver le bouton après 3 secondes (au cas où)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 3000);
            });
        }
    }
    
    // Gestion des favoris
    function initFavorites() {
        document.querySelectorAll('.btn-favorite').forEach(btn => {
            btn.addEventListener('click', function() {
                const associationId = this.dataset.id;
                const isFavorite = this.classList.contains('active');
                
                if (isFavorite) {
                    this.classList.remove('active');
                    this.innerHTML = '<i class="far fa-heart"></i>';
                    console.log('Retiré des favoris:', associationId);
                } else {
                    this.classList.add('active');
                    this.innerHTML = '<i class="fas fa-heart"></i>';
                    console.log('Ajouté aux favoris:', associationId);
                }
                
                // Ici, tu ferais un appel AJAX pour sauvegarder
            });
        });
    }
    
    // Carte interactive pour la localisation
    function initLocationMap() {
        const useLocationBtn = document.querySelector('.btn-use-location');
        if (useLocationBtn && navigator.geolocation) {
            useLocationBtn.addEventListener('click', function() {
                const addressField = document.querySelector('input[name="address"]');
                
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Localisation...';
                this.disabled = true;
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Convertir les coordonnées en adresse
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        // Utiliser une API de géocodage (ici un exemple)
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.address) {
                                    const address = `${data.address.road || ''} ${data.address.house_number || ''}, ${data.address.postcode || ''} ${data.address.city || ''}`;
                                    addressField.value = address.trim();
                                }
                            })
                            .catch(() => {
                                addressField.value = `${lat}, ${lng}`;
                            })
                            .finally(() => {
                                useLocationBtn.innerHTML = '<i class="fas fa-location-dot"></i> Utiliser ma position';
                                useLocationBtn.disabled = false;
                            });
                    },
                    function() {
                        alert('Impossible d\'obtenir votre position');
                        useLocationBtn.innerHTML = '<i class="fas fa-location-dot"></i> Utiliser ma position';
                        useLocationBtn.disabled = false;
                    }
                );
            });
        }
    }
    
    // ==== INITIALISATION ====
    document.addEventListener('DOMContentLoaded', function() {
        initUserMenu();
        initNotifications();
        initPublishDonation();
        initFavorites();
        initLocationMap();
        
        // Gestion des flash messages (compatible avec ton app.js)
        const flashes = document.querySelectorAll('.alert-flash');
        flashes.forEach(flash => {
            setTimeout(() => {
                flash.classList.add('fade-out');
                setTimeout(() => flash.remove(), 500);
            }, 5000);
            
            const closeBtn = flash.querySelector('.close-btn');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    flash.remove();
                });
            }
        });
        
        // Animation des éléments (compatible avec ton home.js)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        document.querySelectorAll('.donation-card, .association-card').forEach(el => {
            observer.observe(el);
        });
    });
    
})();