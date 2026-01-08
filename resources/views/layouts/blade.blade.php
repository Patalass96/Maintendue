<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tableau de bord') | MAIN TENDUE</title>
    
    <!-- CSS Association -->
    @vite(['resources/css/app.css', 'resources/css/association.css'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Variables CSS pour compatibilité -->
    <style>
        :root {
            --primary-color: #2e59d9;
            --secondary-light: #d1fae5;
            --secondary-dark: #065f46;
            --black: #1f2937;
            --gray: #6c757d;
            --dark-gray: #343a40;
            --white: #ffffff;
            --border-radius: 8px;
            --shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
    
    @stack('styles')
</head>
<body class="association-layout1">
    
    <!-- Header Association -->
    {{-- <header class="assoc-header">
        <div class="container">
            
        </div>
    </header> --}}

    <!-- Flash messages -->
    <div class="flash-container">
        @if(session('success'))
            <div class="alert-flash success fade-in">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button class="close-btn">&times;</button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert-flash error fade-in">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
                <button class="close-btn">&times;</button>
            </div>
        @endif
        
        @if(session('warning'))
            <div class="alert-flash warning fade-in">
                <i class="fas fa-exclamation-triangle"></i>
                <span>{{ session('warning') }}</span>
                <button class="close-btn">&times;</button>
            </div>
        @endif
    </div>
    
    <!-- Main Content -->
    <main class="assoc-main1">
        <div class="assoc-container">
            <!-- Header de page comme la maquette -->
            <div class="assoc-page-header1">
                <h1 class="assoc-page-title">@yield('page-title', 'Bienvienue sur la page d\'inscription d\'une Association')</h1>
                <p class="assoc-page-subtitle">
                    @yield('page-subtitle', 'Votre association est vérifiée et active sur la plateforme MAIN TENDUE')
                </p>
            </div>

            @yield('content')
        </div>
    </main>
    
    <!-- Footer Association -->
    <footer class="assoc-footer">
        <div class="container">
            <p>© {{ date('Y') }} MAIN TENDUE. Tous droits réservés.</p>
             <div class="footer-bottom-links">
              <a href="{{ route('privacy') }}" class="footer-link" style="color: #cbd5e0; text-decoration: none; margin-left: 20px;">Confidentialité</a>
              <a href="{{ route('terms') }}" class="footer-link" style="color: #cbd5e0; text-decoration: none; margin-left: 20px;">Conditions</a>
              <a href="{{ route('mentions') }}" class="footer-link" style="color: #cbd5e0; text-decoration: none; margin-left: 20px;">Mentions légales</a>
              </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/js/association.js'])
    
    <!-- Ajout des scripts spécifiques au layout -->
    <script>
        // Gestion du menu utilisateur
        document.addEventListener('DOMContentLoaded', function() {
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
                
                userDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
            
            // Animation pour le badge des messages
            const messageBadge = document.querySelector('.assoc-nav-link[href*="messages"] .badge');
            if (messageBadge && parseInt(messageBadge.textContent) > 0) {
                setInterval(() => {
                    messageBadge.classList.toggle('bg-danger');
                    messageBadge.classList.toggle('bg-warning');
                }, 2000);
            }
            
            // Fermer les flash messages
            document.querySelectorAll('.alert-flash .close-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.alert-flash').remove();
                });
            });
            
            // Auto-remove flash messages after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('.alert-flash').forEach(flash => {
                    flash.remove();
                });
            }, 5000);
        });
    </script>
    
    @stack('scripts')

     <!-- jQuery et DataTables (optionnel) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</body>
</html>


{{-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Association @yield('title') | MAIN TENDUE</title>
    
    <!-- CSS Association -->
    @vite(['resources/css/app.css', 'resources/css/association.css'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('styles')
</head>
<body class="association-layout">
    
    <!-- Header Association -->
    <header class="assoc-header">
         <header class="assoc-header">
        <div class="container">
            <div class="header-content">
                <h1>MAIN TENDUE</h1>

                <nav class="assoc-nav">
                    <!-- Exactement comme ton screenshot -->
                    <a href="{{ route('association.dashboard') }}" class="nav-link">Tableau de bord</a>
                    <a href="{{ route('association.dons') }}" class="nav-link">Catalogue des dons</a>
                    <a href="{{ route('association.historique') }}" class="nav-link">Suivi des dons</a>
                    <a href="{{ route('association.messages') }}" class="nav-link">Messages</a>
                    <a href="{{ route('association.profile') }}" class="nav-link">Profil</a>
                </nav>

               <div class="user-menu">
                    <span>{{ Auth::user()->association->name ?? 'Mon association' }}</span>
                    <a href="{{ route('logout') }}">Déconnexion</a>
                </div>
            </div>
        </div>

    </header>

    <!-- Flash messages -->
    <div class="flash-container">
        @if(session('success'))
            <div class="alert-flash success fade-in">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button class="close-btn">&times;</button>
            </div>
        @endif
    </div>
    
    <!-- Main Content -->
    <main class="assoc-main">
        <div class="container">
            <!-- Titre comme ton screenshot -->
            <div class="page-header">
                <h2>Tableau de bord de l'Association</h2>
                <p class="page-subtitle">Votre association est vérifiée et active sur la plateforme MAIN TENDUE</p>
            </div>

            @yield('content')
        </div>
    </main>
    
    <!-- Footer -->
    {{-- @include('layouts.footer') --}}
    
    <!-- Scripts -->
    {{-- @vite(['resources/js/app.js', 'resources/js/association.js'])
    @stack('scripts')
</body>
</html>  --}}