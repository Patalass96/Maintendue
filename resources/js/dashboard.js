document.addEventListener('DOMContentLoaded', function () {
    // --- Graphique des Dons par Catégorie (Barres) ---
    const ctxDonations = document.getElementById('donationsChart').getContext('2d');
    new Chart(ctxDonations, {
        type: 'bar',
        data: {
            labels: ['Vestimentaires', 'Alimentaire', 'Scolaire', 'Mobilier', 'Jouets', 'Électronique'],
            datasets: [{
                label: 'Nombre de dons',
                data: [1900, 1400, 800, 450, 300, 150],
                backgroundColor: '#3b82f6',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, grid: { drawBorder: false } } }
        }
    });

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
});

document.addEventListener('DOMContentLoaded', function() {
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.querySelector('.hidden-input');
    
    // 1. Déclenche le clic sur l'input caché quand on clique sur la zone
    if (dropzone) {
        dropzone.addEventListener('click', () => fileInput.click());

        // 2. Gère le changement de fichiers
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });
    }

    function handleFiles(files) {
        // Supprime les anciens aperçus s'il y en a
        const oldPreview = document.getElementById('preview-container');
        if (oldPreview) oldPreview.remove();

        // Crée un conteneur pour les miniatures
        const previewContainer = document.createElement('div');
        previewContainer.id = 'preview-container';
        previewContainer.className = 'preview-grid'; // Style à ajouter en CSS
        
        // Limite à 5 images comme sur la maquette
        const filesToProcess = Array.from(files).slice(0, 5);

        filesToProcess.forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.className = 'preview-item';
                    
                    imgWrapper.innerHTML = `
                        <img src="${e.target.result}" alt="Aperçu">
                        <span class="remove-btn"><i class="fas fa-times"></i></span>
                    `;
                    
                    previewContainer.appendChild(imgWrapper);
                }
                
                reader.readAsDataURL(file);
            }
        });

        dropzone.after(previewContainer);
    }
});