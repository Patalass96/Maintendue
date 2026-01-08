@extends('layouts.auth')  <!-- ou le nom de ton layout principal -->

@section('title', 'Authentification')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/auth.css'])
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-logo">
        <img src="{{ asset('assets/images/logos/MainTendue.png') }}" alt="Logo">
    </div>

    <div class="auth-card">
        <h2>Bienvenue sur MainTendue</h2>
        <p class="auth-subtitle">Accédez à votre espace MainTendue</p>

        @if ($errors->any())
            <div class="alert alert-danger" style="color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 8px; font-size: 13px; margin: 15px 0;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="votre@email.com" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <div class="form-utils">
                <label><input type="checkbox" name="remember"> Se souvenir de moi</label>
                <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn-submit">Se connecter</button>
        </form>

        <p class="auth-footer">Pas encore de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a></p>
    </div>
</div>
@endsection

@section('scripts')
    @vite(['resources/js/app.js', 'resources/js/form.js'])
@endsection

{{-- @extends('layouts.auth')

@section('title', 'Connexion - Main Tendue')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/auth.css']) --}}
    {{-- <style>
        /* Styles supplémentaires pour la page de connexion */
        .role-redirect-info {
            background: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        
        .role-redirect-info.show {
            display: block;
        }
        
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-right: 5px;
        }
        
        .badge-admin {
            background: #dc2626;
            color: white;
        }
        
        .badge-association {
            background: #059669;
            color: white;
        }
        
        .badge-donateur {
            background: #3b82f6;
            color: white;
        }
        
        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        
        .forgot-password {
            color: #3b82f6;
            text-decoration: none;
            font-size: 14px;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .status-active {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-verified {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .account-status {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .verification-notice {
            background: #fffbeb;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .verification-notice h5 {
            color: #92400e;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        } --}}
    {{-- </style> --}}
{{-- @endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-logo">
        <img src="{{ asset('assets/images/logos/MainTendue.png') }}" alt="Logo Main Tendue">
    </div>

    <div class="auth-card">
        <h2>Bienvenue sur Main Tendue</h2>
        <p class="auth-subtitle">Connectez-vous à votre espace personnel</p>

        @if(session('status'))
            <div class="alert alert-success" style="color: #065f46; background: #d1fae5; padding: 12px; border-radius: 8px; font-size: 14px; margin: 15px 0; border-left: 4px solid #10b981;">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success" style="color: #065f46; background: #d1fae5; padding: 12px; border-radius: 8px; font-size: 14px; margin: 15px 0; border-left: 4px solid #10b981;">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info" style="color: #1e40af; background: #dbeafe; padding: 12px; border-radius: 8px; font-size: 14px; margin: 15px 0; border-left: 4px solid #3b82f6;">
                <i class="fas fa-info-circle me-2"></i>
                {{ session('info') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning" style="color: #92400e; background: #fef3c7; padding: 12px; border-radius: 8px; font-size: 14px; margin: 15px 0; border-left: 4px solid #f59e0b;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('warning') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" style="color: #dc3545; background: #f8d7da; padding: 12px; border-radius: 8px; font-size: 14px; margin: 15px 0; border-left: 4px solid #dc2626;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Message pour utilisateurs non vérifiés -->
        @if(session('verification_required'))
            <div class="verification-notice">
                <h5><i class="fas fa-envelope me-1"></i> Vérification d'email requise</h5>
                <p style="margin-bottom: 10px; color: #92400e;">Vous devez vérifier votre adresse email avant de pouvoir vous connecter.</p>
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #3b82f6; cursor: pointer; font-size: 14px; padding: 0;">
                        <i class="fas fa-paper-plane me-1"></i> Renvoyer l'email de vérification
                    </button>
                </form>
            </div>
        @endif

        <!-- Info de redirection par rôle -->
        <div class="role-redirect-info" id="roleRedirectInfo">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <i class="fas fa-info-circle" style="color: #3b82f6;"></i>
                <strong>Redirection automatique :</strong>
            </div>
            <p style="margin: 0; font-size: 14px; color: #475569;">
                Vous serez redirigé vers votre tableau de bord en fonction de votre rôle.
            </p>
            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <span class="role-badge badge-admin">
                    <i class="fas fa-crown"></i> Admin
                </span>
                <span class="role-badge badge-association">
                    <i class="fas fa-hands-helping"></i> Association
                </span>
                <span class="role-badge badge-donateur">
                    <i class="fas fa-hand-holding-heart"></i> Donateur
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="form-group">
                <label>Adresse email *</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="votre@email.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Mot de passe *</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                    <i class="fas fa-eye toggle-password" style="position: absolute; right: 15px; cursor: pointer; color: #94a3b8;"></i>
                </div>
            </div>

            <div class="login-options">
                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" style="color: #64748b; font-size: 14px; cursor: pointer;">
                        Se souvenir de moi
                    </label>
                </div>
                <a href="{{ route('password.request') }}" class="forgot-password">
                    Mot de passe oublié ?
                </a>
            </div>

            <!-- Info sur le statut du compte (devine depuis l'email) -->
            <div class="account-status" id="accountStatus" style="display: none;">
                <div style="display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-user-circle" id="statusIcon"></i>
                    <span id="statusMessage"></span>
                </div>
                <span class="status-badge" id="statusBadge"></span>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fas fa-sign-in-alt me-2"></i>
                Se connecter
            </button>
        </form>

        <div class="divider">
            <span>Ou connectez-vous avec</span>
        </div>

        <div class="social-btns">
            <a href="{{ route('social.login', 'google') }}" class="social-link">
                <i class="fab fa-google"></i>
                Google
            </a>
            <a href="{{ route('social.login', 'facebook') }}" class="social-link">
                <i class="fab fa-facebook"></i>
                Facebook
            </a>
        </div>

        <p class="auth-footer">
            Pas encore de compte ? <a href="{{ route('register') }}">Inscrivez-vous ici</a>
        </p>
        
        <p class="legal-text">
            En vous connectant, vous acceptez nos 
            <a href="{{ route('terms') }}">conditions générales</a>
        </p>
    </div>
</div>
@endsection

@section('scripts')
    @vite(['resources/js/app.js', 'resources/js/form.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const togglePassword = document.querySelector('.toggle-password');
            const submitBtn = document.getElementById('submitBtn');
            const roleRedirectInfo = document.getElementById('roleRedirectInfo');
            const accountStatus = document.getElementById('accountStatus');
            const statusIcon = document.getElementById('statusIcon');
            const statusMessage = document.getElementById('statusMessage');
            const statusBadge = document.getElementById('statusBadge');
            const loginForm = document.getElementById('loginForm');

            // Afficher/masquer le mot de passe
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            // Animation au focus
            emailInput.addEventListener('focus', function() {
                roleRedirectInfo.classList.add('show');
            });

            // Vérification du format email et deviner le rôle
            emailInput.addEventListener('blur', function() {
                const email = this.value.trim();
                
                // Cacher le statut si email vide
                if (!email) {
                    accountStatus.style.display = 'none';
                    return;
                }
                
                // Simulation de détection de rôle basé sur l'email (à adapter)
                let roleGuess = 'donateur';
                let isVerified = false;
                let isActive = true;
                
                // Patterns simples (à remplacer par une vraie vérification AJAX si nécessaire)
                if (email.includes('admin') || email.includes('administrateur')) {
                    roleGuess = 'admin';
                } else if (email.includes('asso') || email.includes('association')) {
                    roleGuess = 'association';
                    isVerified = Math.random() > 0.5; // Simulation
                }
                
                // Afficher le statut
                accountStatus.style.display = 'flex';
                
                // Mettre à jour les infos selon le rôle deviné
                switch(roleGuess) {
                    case 'admin':
                        statusIcon.className = 'fas fa-crown';
                        statusIcon.style.color = '#dc2626';
                        statusMessage.textContent = 'Compte administrateur détecté';
                        statusBadge.className = 'status-badge status-verified';
                        statusBadge.textContent = 'Admin';
                        break;
                        
                    case 'association':
                        statusIcon.className = 'fas fa-hands-helping';
                        statusIcon.style.color = '#059669';
                        if (isVerified) {
                            statusMessage.textContent = 'Association vérifiée';
                            statusBadge.className = 'status-badge status-verified';
                            statusBadge.textContent = 'Vérifiée';
                        } else {
                            statusMessage.textContent = 'Association en attente';
                            statusBadge.className = 'status-badge status-pending';
                            statusBadge.textContent = 'En attente';
                        }
                        break;
                        
                    default:
                        statusIcon.className = 'fas fa-hand-holding-heart';
                        statusIcon.style.color = '#3b82f6';
                        statusMessage.textContent = 'Compte donateur';
                        statusBadge.className = 'status-badge status-active';
                        statusBadge.textContent = 'Actif';
                }
            });

            // Validation du formulaire
            loginForm.addEventListener('submit', function(e) {
                const email = emailInput.value.trim();
                const password = passwordInput.value;
                
                // Validation basique
                if (!email || !password) {
                    e.preventDefault();
                    showError('Veuillez remplir tous les champs obligatoires.');
                    return;
                }
                
                // Vérification format email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    showError('Veuillez entrer une adresse email valide.');
                    return;
                }
                
                // Vérification longueur mot de passe
                if (password.length < 6) {
                    e.preventDefault();
                    showError('Le mot de passe doit contenir au moins 6 caractères.');
                    return;
                }
                
                // Désactiver le bouton pendant l'envoi
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Connexion en cours...';
            });
            
            function showError(message) {
                // Créer une alerte d'erreur temporaire
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger';
                errorDiv.style.cssText = 'color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 8px; font-size: 13px; margin: 15px 0; border-left: 4px solid #dc2626;';
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i>${message}`;
                
                // Insérer après les éventuelles alertes existantes
                const existingAlerts = document.querySelector('.auth-card .alert');
                if (existingAlerts) {
                    existingAlerts.parentNode.insertBefore(errorDiv, existingAlerts.nextSibling);
                } else {
                    const form = document.querySelector('form');
                    form.parentNode.insertBefore(errorDiv, form);
                }
                
                // Supprimer après 5 secondes
                setTimeout(() => {
                    errorDiv.remove();
                }, 5000);
            }

            // Récupération automatique des infos de connexion (pour le développement)
            const urlParams = new URLSearchParams(window.location.search);
            const demo = urlParams.get('demo');
            
            if (demo) {
                // Remplir automatiquement les champs pour la démo
                switch(demo) {
                    case 'admin':
                        emailInput.value = 'admin@maintendue.fr';
                        break;
                    case 'association':
                        emailInput.value = 'asso@maintendue.fr';
                        break;
                    case 'donateur':
                        emailInput.value = 'donateur@maintendue.fr';
                        break;
                }
                passwordInput.value = 'password123';
                emailInput.dispatchEvent(new Event('blur'));
                
                // Afficher un message
                const demoAlert = document.createElement('div');
                demoAlert.className = 'alert alert-info';
                demoAlert.style.cssText = 'color: #1e40af; background: #dbeafe; padding: 10px; border-radius: 8px; font-size: 13px; margin: 15px 0; border-left: 4px solid #3b82f6;';
                demoAlert.innerHTML = '<i class="fas fa-vial me-2"></i>Mode démo activé - Remplissage automatique des champs';
                loginForm.parentNode.insertBefore(demoAlert, loginForm);
                
                setTimeout(() => {
                    demoAlert.remove();
                }, 5000);
            }
        });
    </script>
@endsection --}}

















{{-- @extends('layouts.auth')  

@section('title', 'Authentification')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/auth.css'])
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-logo">
        <img src="{{ asset('assets/images/logos/MainTendue.png') }}" alt="Logo">
    </div>

    <div class="auth-card">
        <h2>Bienvenue sur MainTendue</h2>
        <p class="auth-subtitle">Accédez à votre espace MainTendue</p>

        @if ($errors->any())
            <div class="alert alert-danger" style="color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 8px; font-size: 13px; margin: 15px 0;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="votre@email.com" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <div class="form-utils">
                <label><input type="checkbox" name="remember"> Se souvenir de moi</label>
                <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn-submit">Se connecter</button>
        </form>

        <p class="auth-footer">Pas encore de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a></p>
    </div>
</div>
@endsection

@section('scripts')
    @vite(['resources/js/app.js', 'resources/js/form.js'])
@endsection --}}