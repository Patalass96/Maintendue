// ASSOCIATION.JS - JavaScript spécifique au layout Association
// S'exécute uniquement sur les pages association

(function() {
    // Vérifie si on est sur une page association
    const isAssocLayout = document.querySelector('.association-layout');
    if (!isAssocLayout) return;
    
    console.log('Association JS initialisé');
    
    // ==== FONCTIONS ASSOCIATION ====
    
    // Gestion du menu utilisateur
    function initUserMenu() {
        const userMenuBtn = document.querySelector('.user-menu-btn');
        const userDropdown = document.querySelector('.user-dropdown');
        
        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', function(e) {
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
    
    // Gestion des dons
    function initDonations() {
        // Accepter un don
        document.querySelectorAll('.btn-accept').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const donationId = this.dataset.id;
                if (confirm('Accepter ce don ? Vous serez mis en contact avec le donateur.')) {
                    // Ici, tu ferais un appel AJAX
                    console.log('Acceptation du don:', donationId);
                    const card = this.closest('.donation-card');
                    card.style.border = '2px solid #10b981';
                }
            });
        });
        
        // Refuser un don
        document.querySelectorAll('.btn-refuse').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const donationId = this.dataset.id;
                const reason = prompt('Raison du refus :');
                if (reason) {
                    console.log('Refus du don:', donationId, 'Raison:', reason);
                    const card = this.closest('.donation-card');
                    card.style.opacity = '0.5';
                }
            });
        });
    }
    
    // Graphiques association
    function initCharts() {
        if (typeof Chart === 'undefined') return;
        
        // Graphique de collecte mensuelle
        const monthlyChart = document.getElementById('monthlyChart');
        if (monthlyChart) {
            new Chart(monthlyChart, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                    datasets: [{
                        label: 'Dons collectés',
                        data: [120, 150, 180, 90, 200, 160],
                        backgroundColor: '#0ea5e9',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Nombre de dons'
                            }
                        }
                    }
                }
            });
        }
        
        // Graphique par catégorie
        const categoryChart = document.getElementById('categoryChart');
        if (categoryChart) {
            new Chart(categoryChart, {
                type: 'pie',
                data: {
                    labels: ['Vestimentaires', 'Alimentaire', 'Scolaire', 'Hygiène', 'Autres'],
                    datasets: [{
                        data: [40, 25, 20, 10, 5],
                        backgroundColor: [
                            '#0ea5e9',
                            '#10b981',
                            '#f59e0b',
                            '#8b5cf6',
                            '#ef4444'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        }
    }
    
    // Messagerie rapide
    function initMessaging() {
        const messageBtn = document.querySelector('.btn-send-message');
        if (messageBtn) {
            messageBtn.addEventListener('click', function() {
                const donatorId = this.dataset.donator;
                const message = prompt('Votre message au donateur :');
                if (message) {
                    console.log('Envoi message à', donatorId, ':', message);
                    alert('Message envoyé !');
                }
            });
        }
    }
    
    // ==== INITIALISATION ====
    document.addEventListener('DOMContentLoaded', function() {
        initUserMenu();
        initDonations();
        initCharts();
        initMessaging();
        
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
        
        // Animation des cartes (compatible avec ton home.js)
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);
        
        // Observer les cartes de dons
        document.querySelectorAll('.donation-card').forEach(el => {
            observer.observe(el);
        });
    });
    
})();