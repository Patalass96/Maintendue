@push('styles')
<style>
    /* Profile Show Page */
    .profile-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 20px 20px;
    }
    
    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        object-fit: cover;
    }
    
    .profile-avatar-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid white;
        background: rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .profile-name {
        font-size: 2rem;
        font-weight: 700;
        margin: 1rem 0 0.5rem 0;
    }
    
    .profile-title {
        opacity: 0.9;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }
    
    .profile-stats {
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 2rem;
    }
    
    .stat-item {
        text-align: center;
        padding: 0 1rem;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        display: block;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.8;
    }
    
    /* Profile content */
    .profile-section {
        margin-bottom: 2rem;
    }
    
    .profile-section .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s;
    }
    
    .profile-section .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.12);
    }
    
    .profile-section .card-header {
        background: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: 1.25rem 1.5rem;
        border-radius: 10px 10px 0 0 !important;
    }
    
    .profile-section .card-header h5 {
        margin: 0;
        color: #4e73df;
        font-weight: 600;
    }
    
    .profile-section .card-body {
        padding: 1.5rem;
    }
    
    /* Info items */
    .info-item {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .info-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        color: #2e59d9;
        font-weight: 500;
        font-size: 1.1rem;
    }
    
    .info-value a {
        color: #2e59d9;
        text-decoration: none;
    }
    
    .info-value a:hover {
        text-decoration: underline;
    }
    
    /* Verification badge */
    .verification-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        margin-top: 1rem;
    }
    
    .verified {
        background: #d4edda;
        color: #155724;
    }
    
    .pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .rejected {
        background: #f8d7da;
        color: #721c24;
    }
    
    /* Social links */
    .social-links {
        display: flex;
        gap: 10px;
        margin-top: 1rem;
    }
    
    .social-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: transform 0.3s;
    }
    
    .social-link:hover {
        transform: translateY(-3px);
    }
    
    .social-facebook { background: #3b5998; }
    .social-twitter { background: #1da1f2; }
    .social-instagram { background: #e1306c; }
    .social-linkedin { background: #0077b5; }
    .social-website { background: #4e73df; }
    
    /* Map container */
    .profile-map {
        height: 200px;
        border-radius: 10px;
        overflow: hidden;
        background: #f8f9fa;
        margin-top: 1rem;
    }
    
    /* Contact button */
    .contact-button {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #4e73df;
        color: white;
        border: none;
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: all 0.3s;
    }
    
    .contact-button:hover {
        transform: scale(1.1);
        background: #3a56c4;
    }
    
    /* Print styles */
    @media print {
        .profile-header {
            background: #4e73df !important;
            -webkit-print-color-adjust: exact;
        }
        
        .contact-button,
        .btn {
            display: none !important;
        }
        
        .profile-section .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser la carte (exemple avec Leaflet)
        const mapElement = document.getElementById('associationMap');
        if (mapElement && typeof L !== 'undefined') {
            const lat = mapElement.dataset.lat || 48.8566;
            const lng = mapElement.dataset.lng || 2.3522;
            
            const map = L.map('associationMap').setView([lat, lng], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            L.marker([lat, lng]).addTo(map)
                .bindPopup('<b>Localisation de l\'association</b>')
                .openPopup();
        }
        
        // Bouton de contact
        const contactBtn = document.querySelector('.contact-button');
        if (contactBtn) {
            contactBtn.addEventListener('click', function() {
                // Ouvrir un modal de contact
                const modal = new bootstrap.Modal(document.getElementById('contactModal'));
                modal.show();
            });
        }
        
        // Partage du profil
        const shareButtons = document.querySelectorAll('.share-profile');
        shareButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (navigator.share) {
                    navigator.share({
                        title: document.title,
                        text: 'Découvrez cette association sur Main Tendue',
                        url: window.location.href
                    });
                } else {
                    // Fallback pour le copier/coller
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        alert('Lien copié dans le presse-papier !');
                    });
                }
            });
        });
        
        // Animation des sections
        const sections = document.querySelectorAll('.profile-section');
        sections.forEach((section, index) => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                section.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                section.style.opacity = '1';
                section.style.transform = 'translateY(0)';
            }, index * 200);
        });
        
        // QR Code pour le profil (optionnel)
        const qrElement = document.getElementById('profileQR');
        if (qrElement && typeof QRCode !== 'undefined') {
            new QRCode(qrElement, {
                text: window.location.href,
                width: 128,
                height: 128,
                colorDark: "#4e73df",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        }
        
        // Suivi des vues (exemple)
        if (typeof gtag !== 'undefined') {
            gtag('event', 'view_profile', {
                'event_category': 'engagement',
                'event_label': 'association_profile'
            });
        }
        
        // Modal de contact
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Envoi...';
                submitBtn.disabled = true;
                
                // Simulation d'envoi
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('contactModal'));
                    modal.hide();
                    
                    // Afficher une notification
                    showAlert('Message envoyé avec succès !', 'success');
                }, 2000);
            });
        }
        
        function showAlert(message, type) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show`;
            alert.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
            `;
            
            alert.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check' : 'info'}-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(alert);
            
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 5000);
        }
    });
</script>
@endpush