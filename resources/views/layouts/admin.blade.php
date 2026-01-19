<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin @yield('title') | MAIN TENDUE</title>

    <!-- CSS Admin -->
    @vite(['resources/css/app.css', 'resources/css/admin.css'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- DataTables (optionnel) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    @stack('styles')
</head>

<body class="admin-layout" style="width: 100% !important">

    <!-- Sidebar Admin -->
    <aside class="admin-sidebar">


        <div class="sidebar-header">
            <img src="{{ asset('assets/images/logos/MainTendue.png') }}" alt="Logo">
            {{-- <h1></h1> --}}
            <p>Administration</p>
        </div>
        <nav class="sidebar-nav">
            <!-- Exactement comme ton screenshot -->
            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <i class="fas fa-tachometer-alt"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item">
                <i class="fas fa-users"></i>
                <span> Gestion des utilisateurs</span>
            </a>
            <a href="{{ route('admin.associations') }}" class="nav-item">
                <i class="fas fa-handshake"></i>
                <span>Associations</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="nav-item">
                <i class="fas fa-flag"></i>
                <span>Signalements</span>
                <span class="badge"></span>
            </a>
            <a href="{{ route('admin.moderation') }}" class="nav-item">
                <i class="fas fa-clipboard-check"></i>
                <span>Modération des annonces</span>
                <span class="badge"></span>
            </a>


            <a href="{{ route('admin.validateAssociations') }}" class="nav-item">
                <i class="fas fa-check-circle"></i>
                <span>Valider une association</span>
                <span class="badge"></span>
            </a>

            <a href="{{ route('admin.statistique') }}" class="nav-item">
                <i class="fas fa-chart-line"></i>
                <span>Statistiques globales</span>
            </a>

            <a href="{{ route('admin.settings') }}" class="nav-item" style="margin-top: 3em">
                <i class="fas fa-cog"></i>
                <span>Parametres</span>
                <a>

                    <div class="sidebar-divider"></div>
                    {{-- <a href="{{ route('admin.settings') }}" class="fas fa-cog"></i> Parametres</a> --}}

                    <div class="user-info">
                        <div class="user-avatar">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div>
                            <strong>{{ Auth::user()->name }}</strong>
                            {{-- <small>Administrateur</small> --}}
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i>
                            Déconnexion
                        </button>
                    </form>
        </nav>


        {{-- <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <strong>{{ Auth::user()->name }}</strong>
                    <small>Administrateur</small>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                </button>
            </form>
        </div> --}}

    </aside>

    <!-- Main Content -->
    <div class="red" style="width: 100% !important">
        <main class="admin-main">
            <!-- Topbar -->
            <header class="admin-topbar">
                <div class="topbar-left">
                    <h2>@yield('page-title', 'Tableau de bord Administrateur')</h2>
                </div>
            </header>

            <!-- Flash messages (comme dans ton app.blade.php) -->
            <div class="flash-container">
                @if (session('success'))
                    <div class="alert-flash success fade-in">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                        <button class="close-btn">&times;</button>
                    </div>
                @endif
            </div>

            <!-- Contenu -->
            <div class="admin-content">
                @yield('content')
            </div>


            <!-- Footer -->
            {{-- @include('layouts.footer') --}}
        </main>
    </div>

    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/js/admin.js'])

    <!-- jQuery et DataTables (optionnel) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @stack('scripts')
</body>

</html>
