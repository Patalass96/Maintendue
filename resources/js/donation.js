// Fonctions spécifiques à la page des dons

// Filtres avancés
const initDonationFilters = () => {
    const filterForm = document.getElementById('donation-filters');
    if (!filterForm) return;

    // Filtre en temps réel
    const inputs = filterForm.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            filterForm.submit();
        });
    });

    // Filtre par distance
    const distanceFilter = document.getElementById('distance-filter');
    if (distanceFilter && navigator.geolocation) {
        distanceFilter.addEventListener('change', (e) => {
            const maxDistance = e.target.value;
            if (maxDistance && maxDistance !== 'all') {
                getLocationAndFilter(maxDistance);
            }
        });
    }
};

// Géolocalisation
const getLocationAndFilter = (maxDistance) => {
    if (!navigator.geolocation) return;

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const { latitude, longitude } = position.coords;
            
            // Ajouter les coordonnées au formulaire
            const latInput = document.createElement('input');
            latInput.type = 'hidden';
            latInput.name = 'user_latitude';
            latInput.value = latitude;
            
            const lngInput = document.createElement('input');
            lngInput.type = 'hidden';
            lngInput.name = 'user_longitude';
            lngInput.value = longitude;
            
            const distanceInput = document.createElement('input');
            distanceInput.type = 'hidden';
            distanceInput.name = 'max_distance';
            distanceInput.value = maxDistance;
            
            const form = document.getElementById('donation-filters');
            form.appendChild(latInput);
            form.appendChild(lngInput);
            form.appendChild(distanceInput);
            form.submit();
        },
        (error) => {
            console.error('Erreur géolocalisation:', error);
            alert('Impossible d\'accéder à votre position. Vérifiez les permissions.');
        }
    );
};

// Galerie d'images
const initImageGallery = () => {
    const galleryImages = document.querySelectorAll('.gallery-image');
    const modal = document.getElementById('imageModal');
    
    if (!galleryImages.length || !modal) return;

    galleryImages.forEach(img => {
        img.addEventListener('click', () => {
            const modalImage = modal.querySelector('.modal-image');
            const caption = modal.querySelector('.modal-caption');
            
            if (modalImage) modalImage.src = img.src;
            if (caption) caption.textContent = img.alt;
            
            // Afficher la modal Bootstrap
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        });
    });
};

// Actions rapides sur les dons
const initQuickActions = () => {
    // Réservation rapide
    document.querySelectorAll('.quick-reserve-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const donationId = btn.dataset.donationId;
            
            if (!confirm('Voulez-vous vraiment réserver ce don ?')) return;
            
            try {
                const response = await axios.post(`/donations/${donationId}/reserve`);
                
                if (response.data.success) {
                    btn.closest('.donation-card').classList.add('reserved');
                    btn.disabled = true;
                    btn.innerHTML = '<i class="bi bi-check"></i> Réservé';
                    
                    // Afficher un message de succès
                    showToast('Don réservé avec succès!', 'success');
                }
            } catch (error) {
                showToast('Erreur lors de la réservation', 'error');
            }
        });
    });
};

// Toast notifications
const showToast = (message, type = 'info') => {
    const toastContainer = document.getElementById('toast-container');
    if (!toastContainer) return;

    const toastId = 'toast-' + Date.now();
    const toastHtml = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;

    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
    toast.show();

    // Supprimer après fermeture
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
};

// Initialiser quand le DOM est prêt
document.addEventListener('DOMContentLoaded', () => {
    initDonationFilters();
    initImageGallery();
    initQuickActions();
    
    // Réinitialiser les composants Vue si nécessaire
    if (window.initializeVueComponents) {
        window.initializeVueComponents();
    }
});

// Exporter pour les tests
export {
    initDonationFilters,
    initImageGallery,
    initQuickActions,
    showToast
};