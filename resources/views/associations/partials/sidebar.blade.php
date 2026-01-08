<div class="card mb-3">
    <div class="card-body text-center">
        @if(isset($association) && $association->logo)
            <img src="{{ asset('storage/' . $association->logo) }}" 
                 alt="{{ $association->legal_name }}" 
                 class="rounded-circle mb-3" width="80" height="80">
        @else
            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                 style="width: 80px; height: 80px;">
                <i class="fas fa-hands-helping fa-2x text-white"></i>
            </div>
        @endif
        
        @if(isset($association))
            <h6 class="mb-1">{{ $association->legal_name }}</h6>
            <p class="text-muted small mb-2">{{ $association->contact_person }}</p>
        @endif
        
        <div class="d-grid gap-2">
            <a href="{{ route('associations.profile') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-user me-1"></i>Mon profil
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-2">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('associations.dashboard') ? 'active' : '' }}" 
                   href="{{ route('associations.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Tableau de bord
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('association.donations.available') ? 'active' : '' }}" 
                   href="{{ route('associations.donations.available') }}">
                    <i class="fas fa-gift me-2"></i>Dons disponibles
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('association.donations.received') ? 'active' : '' }}" 
                   href="{{ route('associations.donations.received') }}">
                    <i class="fas fa-box-open me-2"></i>Dons reçus
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('associations.requests*') ? 'active' : '' }}" 
                   href="{{ route('associations.requests') }}">
                    <i class="fas fa-bullhorn me-2"></i>Mes demandes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('associations.messages') ? 'active' : '' }}" 
                   href="{{ route('associations.messages') }}">
                    <i class="fas fa-envelope me-2"></i>Messages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('associations.profile*') ? 'active' : '' }}" 
                   href="{{ route('associations.profile') }}">
                    <i class="fas fa-cog me-2"></i>Paramètres
                </a>
            </li>
            <li class="nav-item mt-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link text-danger w-100 text-start" style="border: none; background: none;">
                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>