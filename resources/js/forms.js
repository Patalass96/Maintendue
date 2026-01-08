document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.input-with-icon input');

    // Animation des icônes au focus
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.previousElementSibling.style.color = '#3b82f6';
        });
        input.addEventListener('blur', () => {
            input.previousElementSibling.style.color = '#94a3b8';
        });
    });

    // Validation simple côté client pour la correspondance des mots de passe
    const registerForm = document.querySelector('form[action*="register"]');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const pass = document.querySelector('input[name="password"]').value;
            const confirm = document.querySelector('input[name="password_confirmation"]').value;

            if (pass !== confirm) {
                e.preventDefault();
                alert("Les mots de passe ne correspondent pas !");
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // 1. Animation des icônes lors du focus
    const inputs = document.querySelectorAll('.input-with-icon input, .input-with-icon select');
    
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            const icon = input.parentElement.querySelector('i');
            if (icon) icon.style.color = '#1e40af'; // Bleu plus foncé au focus
        });

        input.addEventListener('blur', () => {
            const icon = input.parentElement.querySelector('i');
            if (icon) icon.style.color = '#3b82f6'; // Retour au bleu initial
        });
    });

    // 2. Gestion dynamique des erreurs (si Laravel renvoie des erreurs)
    const errorAlert = document.querySelector('.alert-danger');
    if (errorAlert) {
        // Optionnel : On fait vibrer la carte si il y a une erreur
        const card = document.querySelector('.auth-card');
        card.style.animation = 'shake 0.5s';
    }
});


// Pour la page de connexion uniquement
if (document.querySelector('#loginForm')) {
    // Validation en temps réel de l'email
    const emailInput = document.querySelector('#email');
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            const email = this.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.style.borderColor = '#ef4444';
                this.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
            } else {
                this.style.borderColor = '';
                this.style.boxShadow = '';
            }
        });
    }
    
    // Effet de vibration sur erreur
    function shakeForm() {
        const card = document.querySelector('.auth-card');
        card.style.animation = 'shake 0.5s';
        setTimeout(() => {
            card.style.animation = '';
        }, 500);
    }
    
    // Si des erreurs existent déjà, faire vibrer
    if (document.querySelector('.alert-danger')) {
        setTimeout(shakeForm, 300);
    }
}

document.addEventListener('DOMContentLoaded', function() {
        const roleInputs = document.querySelectorAll('input[name="role"]');
        const associationFields = document.getElementById('associationFields');
        
        roleInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.value === 'association') {
                    associationFields.style.display = 'block';
                    // Rendre les champs association requis
                    document.querySelectorAll('[data-association]').forEach(field => {
                        field.required = true;
                    });
                } else {
                    associationFields.style.display = 'none';
                    // Retirer le required des champs association
                    document.querySelectorAll('[data-association]').forEach(field => {
                        field.required = false;
                    });
                }
            });
        });
        
        // Sélectionner "donateur" par défaut
        document.querySelector('input[value="donateur"]').click();
    });