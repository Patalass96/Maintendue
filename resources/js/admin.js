// ADMIN.JS - JavaScript spécifique au layout Admin
// S'exécute uniquement sur les pages admin

(function () {
    // Vérifie si on est sur une page admin
    const isAdminLayout = document.querySelector('.admin-layout');
    if (!isAdminLayout) return;

    console.log('Admin JS initialisé');

    // ==== FONCTIONS ADMIN ====

    // Toggle sidebar
    function initSidebarToggle() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function () {
                document.body.classList.toggle('sidebar-collapsed');
                localStorage.setItem('admin-sidebar-collapsed', document.body.classList.contains('sidebar-collapsed'));
            });

            // Restaurer l'état du sidebar
            const isCollapsed = localStorage.getItem('admin-sidebar-collapsed') === 'true';
            if (isCollapsed) {
                document.body.classList.add('sidebar-collapsed');
            }
        }
    }

    // Gestion des notifications
    function initNotifications() {
        const notificationBtn = document.querySelector('.btn-notification');
        if (notificationBtn) {
            notificationBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                // Ici tu pourrais ouvrir un dropdown de notifications
                console.log('Notifications cliqué');
            });
        }
    }

    // Initialiser les graphiques
    function initCharts() {
        if (typeof Chart === 'undefined') return;

        // Graphique des statistiques globales
        const statsChart = document.getElementById('statsChart');
        if (statsChart) {
            new Chart(statsChart, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                    datasets: [{
                        label: 'Utilisateurs actifs',
                        data: [1500, 1800, 2100, 1900, 2300, 2450, 2600, 2500, 2700, 2900, 3100, 3300],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
        }

        // Graphique des dons par catégorie
        const donationsChart = document.getElementById('donationsChart');
        if (donationsChart) {
            new Chart(donationsChart, {
                type: 'doughnut',
                data: {
                    labels: ['Vestimentaires', 'Scolaire', 'Alimentaire', 'Électronique', 'Jouets'],
                    datasets: [{
                        data: [35, 25, 20, 10, 10],
                        backgroundColor: [
                            '#3b82f6',
                            '#10b981',
                            '#f59e0b',
                            '#8b5cf6',
                            '#ef4444'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
        }

            // --- Graphique de Croissance (Ligne) ---

        const ctxGrowth = document.getElementById('growthChart').getContext('2d');
        new Chart(ctxGrowth, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [{
                    label: 'Utilisateurs',
                    data: [300, 450, 600, 750, 850, 980],
                    borderColor: '#10b981',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }

        });
    }

    // Gestion des tables de données
    function initDataTables() {
        // Initialiser les tables de données si DataTables est présent
        if (typeof $.fn.DataTable !== 'undefined') {
            $('.admin-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
                },
                pageLength: 10,
                responsive: true
            });
        }
    }

    // Actions rapides admin
    function initQuickActions() {
        // Validation rapide d'association
        document.querySelectorAll('.btn-validate').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const associationId = this.dataset.id;
                if (confirm('Valider cette association ?')) {
                    //  appel AJAX
                    console.log('Validation de l\'association:', associationId);
                    this.closest('tr').style.opacity = '0.5';
                }
            });
        });

        // Voir un signalement
        document.querySelectorAll('.btn-view-report').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const reportId = this.dataset.id;
                // Ouvrir un modal ou rediriger
                console.log('Voir le signalement:', reportId);
            });
        });
    }

    // ==== INITIALISATION ====
    document.addEventListener('DOMContentLoaded', function () {
        initSidebarToggle();
        initNotifications();
        initCharts();
        initDataTables();
        initQuickActions();

        // Gestion des flash messages (auto-dismiss)
        const flashes = document.querySelectorAll('.alert-flash');
        flashes.forEach(flash => {
            setTimeout(() => {
                flash.classList.add('fade-out');
                setTimeout(() => flash.remove(), 500);
            }, 5000);

            const closeBtn = flash.querySelector('.close-btn');
            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    flash.remove();
                });
            }
        });
    });

})();