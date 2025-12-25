 @vite(['resources/css/auth.css','resources/js/form.js', 'resources/js/app.js'])


@section('title', 'Authentification')


<div class="auth-wrapper">
    <div class="auth-logo">
        <img src="{{ asset('assets/images/logos/MainTendue.png') }}" alt="MainTendue Logo">
    </div>

    <div class="auth-card">
        <h2>Bienvenue sur MAIN TENDUE</h2>
        <p class="auth-subtitle">Connectez-vous ou créez un compte pour commencer.</p>

        <div class="auth-buttons-row">
            <button type="button" id="btn-show-login" class="btn-toggle active">Se connecter</button>
            <button type="button" id="btn-show-register" class="btn-toggle">S'inscrire</button>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" style="color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 8px; font-size: 13px; margin: 15px 0;">
                {{ $errors->first() }}
            </div>
        @endif

        <div id="login-form-container">
            <form method="POST" action="{{ url('login') }}">
                @csrf
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" placeholder="votre.email@exemple.com" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock"> Mot de passe</label>
                    <input type="password" name="password" placeholder="Votre mot de passe" required>
                </div>
                <button type="submit" class="btn-submit-main">Se connecter</button>
            </form>
        </div>

        <div id="register-form-container" style="display: none;">
            <form method="POST" action="{{ url('register') }}">
                @csrf
                <div class="form-group">
                    <label>Nom complet</label>
                    <input type="text" name="name" placeholder="Jean Dupont" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" placeholder="votre.email@exemple.com" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Mot de passe</label>
                    <input type="password" name="password" placeholder="Minimum 8 caractères" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa- check-double"></i>Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" placeholder="Répétez le mot de passe" required>
                </div>
                <button type="submit" class="btn-submit-main">Créer mon compte</button>
            </form>
        </div>

        <div class="auth-divider"><span>Ou</span></div>

        <div class="social-auth">
            <a href="{{ route('social.login', 'google') }}" class="btn-social">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google">
                Continuer avec Google
            </a>
            <a href="{{ route('social.login', 'facebook') }}" class="btn-social">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b9/2023_Facebook_icon.svg" alt="Facebook">
                Continuer avec Facebook
            </a>
        </div>

        {{-- <div class="auth-footer" style="text-align: center; margin-top: 15px;">
            <a href="#" id="link-forgot" class="forgot-link">Mot de passe oublié ?</a>
        </div> --}}
    </div>
</div>

@section('scripts')
<script>
    const btnLogin = document.getElementById('btn-show-login');
   const btnRegister = document.getElementById('btn-show-register');
   const loginForm = document.getElementById('login-form-container');
    const registerForm = document.getElementById('register-form-container');

function toggleAuth(mode) {
    if (mode === 'login') {
        // État des boutons
        btnLogin.classList.add('active');
        btnRegister.classList.remove('active');
        
        // Affichage des formulaires avec animation
        loginForm.style.display = 'block';
        loginForm.classList.add('fade-in');
        registerForm.style.display = 'none';
        registerForm.classList.remove('fade-in');
    } else {
        // État des boutons
        btnRegister.classList.add('active');
        btnLogin.classList.remove('active');
        
        // Affichage des formulaires avec animation
        registerForm.style.display = 'block';
        registerForm.classList.add('fade-in');
        loginForm.style.display = 'none';
        loginForm.classList.remove('fade-in');
    }

    }

    btnLogin.addEventListener('click', () => toggleAuth('login'));
    btnRegister.addEventListener('click', () => toggleAuth('register'));

    @if($errors->has('name') || $errors->has('password_confirmation') || old('name'))
        toggleAuth('register');
    @endif

</script>
@endsection