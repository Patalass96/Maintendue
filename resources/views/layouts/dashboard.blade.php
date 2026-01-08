{{-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - MAIN TENDUE</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> {{-- Pour les graphiques de la maquette --}}<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/css/dashboard.css'])

    <script src="https://kit.fontawesome.com/your-kit.js" crossorigin="anonymous"></script> 
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('assets/images/logos/MainTendue.png') }}" alt="Logo">
                <span>MAIN TENDUE</span>
            </div>
            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="active"><i class="fas fa-th-large"></i> Tableau de bord</a>
                <a href="#"><i class="fas fa-users"></i> Gestion des utilisateurs</a>
                <a href="#"><i class="fas fa-bullhorn"></i> Modération des annonces</a>
                <a href="#"><i class="fas fa-check-circle"></i> Validation associations</a>
                <a href="#"><i class="fas fa-chart-line"></i> Statistiques globales</a>
                <a href="#"><i class="fas fa-file-alt"></i> Reports</a>
                <div class="sidebar-divider"></div>
                <a href="#"><i class="fas fa-cog"></i> Paramètres</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Rechercher...">
                </div>
                <div class="header-actions">
                    <a href="#" class="btn-view-donations"><i class="fas fa-hand-holding-heart"></i> Voir les dons</a>
                    <i class="far fa-comment-dots"></i>
                    <i class="far fa-bell"></i>
                    <div class="user-profile">
                        <img src="{{ auth()->user()->avatar_url }}" alt="Avatar">
                    </div>
                </div>
            </header>

            <section class="content-wrapper">
                @yield('content')
            </section>
        </main>
    </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @vite(['resources/js/dashboard.js'])

</body>
</html> --}} 