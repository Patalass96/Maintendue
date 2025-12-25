// App.js - Script principal

document.addEventListener('DOMContentLoaded', function() { // Correction : virgule ajoutée, accolade supprimée ici
    
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