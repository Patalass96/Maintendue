import './bootstrap';

// // Import des styles globaux
// import '../css/app.css';

// // Alpine.js pour les interactions simples
// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();

// Fonction pour initialiser les composants Vue
import { createApp } from 'vue';

// Import des composants Vue
import NotificationBell from './components/NotificationBell.vue';
import ChatWidget from './components/ChatWidget.vue';
import DonationCard from './components/DonationCard.vue';

// Initialiser les composants Vue
const initializeVueComponents = () => {
    // Notification Bell
    const notificationBellElement = document.getElementById('notification-bell-vue');
    if (notificationBellElement) {
        createApp(NotificationBell).mount('#notification-bell-vue');
    }

    // Chat Widget
    const chatWidgetElement = document.getElementById('chat-widget-vue');
    if (chatWidgetElement) {
        const userId = chatWidgetElement.dataset.userId;
        const conversationId = chatWidgetElement.dataset.conversationId;
        createApp(ChatWidget, { userId, conversationId }).mount('#chat-widget-vue');
    }

    // Donation Cards (multiples instances)
    document.querySelectorAll('.donation-card-vue').forEach(element => {
        const donationId = element.dataset.donationId;
        createApp(DonationCard, { donationId }).mount(element);
    });
};

// Initialiser quand le DOM est prêt
document.addEventListener('DOMContentLoaded', initializeVueComponents);

// Exporter pour les autres fichiers JS
window.initializeVueComponents = initializeVueComponents;



document.addEventListener('DOMContentLoaded', function() {

    // ===== MENU MOBILE =====
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mainMenu = document.getElementById('main-menu');

    if (mobileMenuBtn && mainMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mainMenu.classList.toggle('active');
        });

        // Fermer le menu en cliquant en dehors
        document.addEventListener('click', function(event) {
            if (!mainMenu.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                mainMenu.classList.remove('active');
            }
        });
    }

    // ===== DROPDOWNS =====
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.nextElementSibling;
            // Correction : Utilisation de la classe
            if (dropdown) dropdown.classList.toggle('show');
        });
    });

    // Fermer les dropdowns en cliquant en dehors
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
    });
});


// 1. Gestion des formulaires
document.addEventListener('DOMContentLoaded', function() {
    // Validation simple
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            this.classList.add('was-validated');
        });
    });

    // 2. Galerie d'images pour les dons
    const initImageGallery = () => {
        const thumbnails = document.querySelectorAll('.image-thumbnail');
        const mainImage = document.getElementById('main-image');

        if (mainImage && thumbnails.length) {
            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', () => {
                    mainImage.src = thumb.src;
                });
            });
        }
    };

    // 3. Filtres simples
    const initFilters = () => {
        const filterSelects = document.querySelectorAll('.filter-select');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
    };

    // 4. Toggle de réservation
    const initReservationButtons = () => {
        const reserveButtons = document.querySelectorAll('.btn-reserve');
        reserveButtons.forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();

                if (!confirm('Confirmez-vous la réservation de ce don ?')) {
                    return;
                }

                const donationId = this.dataset.donationId;

                try {
                    const response = await fetch(`/donations/${donationId}/reserve`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                    });

                    if (response.ok) {
                        this.textContent = 'Réservé ✓';
                        this.disabled = true;
                        this.classList.remove('btn-primary');
                        this.classList.add('btn-success');

                        alert('Don réservé avec succès !');
                    }
                } catch (error) {
                    alert('Erreur lors de la réservation');
                }
            });
        });
    };

    // 5. Géolocalisation simple
    const initGeolocation = () => {
        const locationButton = document.getElementById('btn-use-my-location');
        if (!locationButton) return;

        locationButton.addEventListener('click', function() {
            if (!navigator.geolocation) {
                alert('Géolocalisation non supportée par votre navigateur');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    // Pré-remplir les champs cachés
                    document.getElementById('user_latitude').value = lat;
                    document.getElementById('user_longitude').value = lng;

                    // Soumettre le formulaire de recherche
                    document.getElementById('search-form').submit();
                },
                (error) => {
                    alert('Impossible d\'accéder à votre position');
                }
            );
        });
    };

    // 6. Upload d'images avec prévisualisation
    const initImageUpload = () => {
        const fileInput = document.getElementById('donation-images');
        const previewContainer = document.getElementById('image-preview');

        if (fileInput && previewContainer) {
            fileInput.addEventListener('change', function() {
                previewContainer.innerHTML = '';

                Array.from(this.files).forEach((file, index) => {
                    if (index >= 5) return; // Limite à 5 images

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const div = document.createElement('div');
                        div.className = 'image-preview-item';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="img-thumbnail">
                            <button type="button" class="btn-remove-image" data-index="${index}">×</button>
                        `;
                        previewContainer.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            });
        }
    };

    // 7. Initialiser tout
    initImageGallery();
    initFilters();
    initReservationButtons();
    initGeolocation();
    initImageUpload();
});
