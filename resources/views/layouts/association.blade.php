<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tableau de bord') | MAIN TENDUE</title>

    <!-- CSS Global and Association -->
    @vite(['resources/css/app.css', 'resources/css/association.css'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Variables CSS pour compatibilité et design système -->
    <style>
        :root {
            --primary-color: #0ea5e9;
            --primary-dark: #0369a1;
            --primary-light: #e0f2fe;
            --secondary-color: #22c55e;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --white: #ffffff;
            --border-radius-lg: 16px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Top Navbar */
        .top-navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            height: 70px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            z-index: 1030;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            padding: 0 2rem;
        }

        /* Sidebar Navigation */
        .assoc-sidebar {
            width: var(--sidebar-width);
            background: var(--white);
            border-right: 1px solid #e2e8f0;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .sidebar-logo {
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .sidebar-logo img {
            height: 40px;
        }

        .nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.2s;
            gap: 12px;
        }

        .nav-link-item:hover {
            background-color: var(--bg-light);
            color: var(--primary-color);
        }

        .nav-link-item.active {
            background-color: var(--primary-light);
            color: var(--primary-color);
            font-weight: 600;
        }

        .nav-link-item i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        /* Main Content Area */
        .main-container {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 100px 2rem 2rem; /* padding-top for fixed navbar */
            transition: all 0.3s ease;
        }

        /* User Menu inside SideBar bottom */
        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid #e2e8f0;
            padding-top: 1.5rem;
            position: absolute;
            bottom: 1.5rem;
            width: calc(100% - 3rem);
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            background: var(--bg-light);
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        /* Flash messages styling */
        .flash-msg-container {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 1060;
            max-width: 400px;
        }

        @media (max-width: 991.98px) {
            .assoc-sidebar {
                transform: translateX(-100%);
            }
            .assoc-sidebar.show {
                transform: translateX(0);
            }
            .main-container {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-50">

    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="assoc-sidebar shadow-sm">
            <a href="{{ url('/') }}" class="sidebar-logo">
                <img src="{{ asset('assets/images/logos/MainTendue.png') }}" alt="MainTendue Logo">
                <span class="fw-800 text-dark h5 mb-0">MainTendue</span>
            </a>

            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('associations.dashboard') }}" class="nav-link-item {{ request()->routeIs('associations.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('associations.donation.available') }}" class="nav-link-item {{ request()->routeIs('associations.donations.available') ? 'active' : '' }}">
                        <i class="fas fa-gift"></i>
                        <span>Catalogue des dons</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('associations.donation.received') }}" class="nav-link-item {{ request()->routeIs('associations.donations.received') ? 'active' : '' }}">
                        <i class="fas fa-history"></i>
                        <span>Suivi des dons</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('associations.messages') }}" class="nav-link-item {{ request()->routeIs('associations.messages') ? 'active' : '' }}">
                        <i class="fas fa-comment-alt"></i>
                        <span>Messages</span>
                        <span class="badge bg-danger rounded-pill ms-auto">2</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('associations.profile.edit') }}" class="nav-link-item {{ request()->routeIs('associations.profile.*') ? 'active' : '' }}">
                        <i class="fas fa-building"></i>
                        <span>Mon Profil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('associations.settings') }}" class="nav-link-item {{ request()->routeIs('associations.settings') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Paramètres</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <div class="user-pill mb-3">
                    <img src="{{ Auth::user()->profile_photo_url ?? asset('assets/images/default-avatar.png') }}" alt="Avatar" class="rounded-circle" width="32" height="32">
                    <div class="overflow-hidden">
                        <p class="mb-0 fw-bold small text-truncate">{{ Auth::user()->name }}</p>
                        <p class="mb-0 text-muted smaller text-truncate" style="font-size: 0.75rem;">Association vérifiée</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light w-100 rounded-pill border py-2 small fw-bold text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-container">
            <!-- Top Navbar Area (Search, notifications etc) -->
            <div class="top-navbar px-4">
                <button class="btn btn-light d-lg-none me-3" id="toggle-sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="fw-bold mb-0 d-none d-md-block text-slate-800">@yield('page-title', 'Tableau de bord')</h5>

                <div class="ms-auto d-flex align-items-center gap-3">
                    <button class="btn btn-white border-0 shadow-none position-relative p-2">
                        <i class="fas fa-bell text-slate-400"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-primary border border-white rounded-circle"></span>
                    </button>
                    <div class="vr mx-2 text-slate-200"></div>
                    <span class="small fw-medium text-slate-600">{{ Auth::user()->name }}</span>
                    <a href="{{ route('associations.profile.edit') }}">
                        <img src="{{ Auth::user()->profile_photo_url ?? asset('assets/images/default-avatar.png') }}" class="rounded-circle border-2 border-white shadow-sm" width="36" height="36" alt="Avatar">
                    </a>
                </div>
            </div>

            <!-- Page Content -->
            <div class="page-content animate_animated animate_fadeIn">
                @if(isset($breadcrumbs))
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            @foreach($breadcrumbs as $label => $link)
                                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                                    @if(!$loop->last) <a href="{{ $link }}" class="text-decoration-none text-muted">{{ $label }}</a> @else {{ $label }} @endif
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                @endif

                @yield('content')
            </div>

             <!-- Footer dashboard wrapper -->
            <footer class="mt-auto pt-5 pb-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 border-top pt-4 text-muted small">
                    <p class="mb-0">© {{ date('Y') }} MainTendue. Système de gestion solidaire.</p>
                    <div class="d-flex gap-4">
                        <a href="{{ route('privacy') }}" class="text-decoration-none text-muted">Confidentialité</a>
                        <a href="{{ route('terms') }}" class="text-decoration-none text-muted">Conditions</a>
                        {{-- <a href="{{ route('contact') }}" class="text-decoration-none text-muted">Aide</a> --}}
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <!-- Notifications Container -->
    <div class="flash-msg-container">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-lg rounded-4 animate_animated animate_bounceInRight alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <div class="me-3 p-2 bg-success-subtle text-success rounded-circle">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-bold">Succès !</p>
                        <p class="mb-0 small">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-lg rounded-4 animate_animated animate_shakeX alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <div class="me-3 p-2 bg-danger-subtle text-danger rounded-circle">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-bold">Erreur !</p>
                        <p class="mb-0 small">{{ session('error') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Scripts section -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/js/app.js'])

    <script>
        $(document).ready(function() {
            // Sidebar toggle for mobile
            $('#toggle-sidebar').on('click', function() {
                $('.assoc-sidebar').toggleClass('show');
            });

            // Auto-hide alert after 8 seconds
            setTimeout(function() {
                $('.alert-dismissible').fadeOut();
            }, 8000);
        });
    </script>

    @stack('scripts')
</body>

</html>
