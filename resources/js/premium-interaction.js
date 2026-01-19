/* ===== PREMIUM INTERACTION SYSTEM - MAIN TENDUE ===== */

document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialiser les animations d'entrée (Intersection Observer)
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const appearanceObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                appearanceObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Cibler les éléments à animer
    const elementsToAnimate = document.querySelectorAll('.premium-stat-card, .assoc-card, .donation-card, .table-card, .kpi-card');
    elementsToAnimate.forEach(el => appearanceObserver.observe(el));

    // 2. Feedback sur les boutons (Ripple Effect léger)
    const buttons = document.querySelectorAll('.btn-premium, .btn-primary, .btn-secondary');
    buttons.forEach(button => {
        button.addEventListener('mousedown', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const ripple = document.createElement('span');
            ripple.style.position = 'absolute';
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            ripple.style.width = '0px';
            ripple.style.height = '0px';
            ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
            ripple.style.borderRadius = '50%';
            ripple.style.transform = 'translate(-50%, -50%)';
            ripple.style.transition = 'width 0.5s ease-out, height 0.5s ease-out, opacity 0.5s ease-out';
            ripple.style.pointerEvents = 'none';

            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);

            // Forcer le reflow
            ripple.offsetWidth;

            ripple.style.width = `${Math.max(rect.width, rect.height) * 2}px`;
            ripple.style.height = `${Math.max(rect.width, rect.height) * 2}px`;
            ripple.style.opacity = '0';

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // 3. Hover sophistiqué pour les lignes de tableau
    const tableRows = document.querySelectorAll('table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', () => {
             row.style.transition = 'all 0.2s ease';
             // row.style.transform = 'scale(1.005)';
             row.style.boxShadow = 'inset 4px 0 0 var(--p-primary, #0ea5e9)';
        });
        row.addEventListener('mouseleave', () => {
             row.style.boxShadow = 'none';
        });
    });

    // 4. Auto-hide alerts avec animation
    const alerts = document.querySelectorAll('.alert-flash, .alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'all 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateX(50px)';
            setTimeout(() => alert.remove(), 550);
        }, 6000);
    });
});
