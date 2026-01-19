<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MAIN TENDUE')</title>

    <!-- CSS Donateur -->
    @vite(['resources/css/app.css', 'resources/css/donateur.css'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>
<body class="donateur-layout">

    <!-- Header Donateur -->
    <header class="donateur-header">
        <div class="header-content">
            <h1>MAIN TENDUE</h1>

            <nav class="donateur-nav">

                <!-- Exactement comme ton screenshot -->
                    <a href="{{ route('donator.dashboard') }}" class="nav-link">Tableau de bord</a>
                    <a href="{{ route('donateur.historique') }}" class="nav-link">Historique des dons</a>
                    <a href="{{ route('donateur.messages') }}" class="nav-link">Messages</a>
                    <a href="{{ route('donateur.notifications') }}" class="nav-link">Notifications</a>
                    <a href="{{ route('donateur.settings') }}" class="nav-link">Paramètres</a>
                </nav>

                <!-- Bouton Publier un don -->
                <div class="header-actions">
                    <a href="{{ route('donations.create') }}" class="btn-publier">
                        <i class="fas fa-plus-circle"></i>
                        Publier un don
                    </a>
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
    <main class="donateur-main">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    {{-- @include('layouts.footer') --}}

    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/js/donateur.js'])
    @stack('scripts')
</body>
</html>
