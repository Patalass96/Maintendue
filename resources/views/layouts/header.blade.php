
<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-top-content">
                <div class="contact-info">
                    <span><i class="fas fa-phone"></i> +228 92719630/99444263</span>
                    <span><i class="fas fa-envelope"></i>maintenduepatience01@gmail.com</span>
                </div>
                <div class="language-switcher">
                    <select id="language-select">
                        <option value="fr" selected>Français</option>
                        <option value="en">English</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="{{ url('/') }}" class="navbar-brand">
                <div class="brand-logo">
                    <img src="{{ asset('assets/images/logos/MainTendue.png') }}" 
                         alt="MainTendue Logo">
                </div>
                {{-- <div class="brand-text">
                    <h1>MAIN <span>TENDUE</span></h1>
                    <p class="brand-subtitle">Donner, c'est changer une vie</p>
                </div> --}}
            </a>

            <!-- Menu Principal -->
            <div class="nav-menu" id="main-menu">
                <a href="{{ route('home') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Accueil</span>
                </a>
                
                <div class="dropdown">
                    {{-- <a href="{{ route('donations') }}" class="nav-link {{ request()->is('donations*') ? 'active' : '' }}"> --}}
                        <i class="fas fa-gift"></i>
                        <span>Donner/Recevoir</span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu">
                        {{-- <a href="{{ route('donations/create') }}" class="dropdown-item"> --}}
                            <i class="fas fa-plus-circle"></i>
                            Publier un don
                        </a>
                        {{-- <a href="{{ route('donations') }}" class="dropdown-item"> --}}
                            <i class="fas fa-search"></i>
                            Chercher des dons
                        </a>
                    </div>
                </div>
                
                {{-- <a href="{{ route('associations') }}" class="nav-link {{ request()->is('associations*') ? 'active' : '' }}"> --}}
                    <i class="fas fa-hands-helping"></i>
                    <span>Associations</span>
                </a>
                
                 <a href="{{ route('about') }}" class="nav-link {{ request()->is('about*') ? 'active' : '' }}"> 
                    <i class="fas fa-info-circle"></i>
                    <span>À propos</span>
                </a>
                
                 <a href="{{ route('faq') }}" class="nav-link {{ request()->is('faq*') ? 'active' : '' }}"> 
                    <i class="fas fa-question-circle"></i>
                    <span>FAQ</span>
                </a>
                
                <!-- Menu utilisateur -->
                @auth
                    <div class="dropdown user-menu">
                        <button class="dropdown-toggle user-toggle">
                            <div class="user-avatar">
                                <img src="{{ auth()->user()->avatar_url }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="avatar">
                            </div>
                            <span class="user-name">{{ Str::limit(auth()->user()->name, 12) }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu user-dropdown">
                            {{-- <a href="{{ route('profile') }}" class="dropdown-item"> --}}
                                <i class="fas fa-user"></i> Mon profil
                            </a>
                            <hr>
                            <form method="POST" action="{{ url('/logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-outline">
                            <i class="fas fa-sign-in-alt"></i> Connexion
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> S'inscrire
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Menu Mobile -->
            <button class="mobile-menu-btn" id="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>
</header>