@extends('layouts.auth')

@section('content')
<div  class="gradient-bg"></div>

<div  class="auth-wrapper-2fa">
    <div  class="auth-card-2fa">
        <!-- Security Icon -->
        <div class="security-icon-wrapper">
            <div class="security-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
        </div>

        <!-- Header -->
        <h2 class="auth-title-2fa">Vérification de sécurité</h2>
        <p class="auth-subtitle-2fa">
            Entrez le code à 6 chiffres envoyé à votre adresse email
        </p>

        <!-- Test OTP Display -->
        @if (session('otp_code_display'))
            <div class="otp-display-card">
                <div class="otp-display-header">
                    <i class="fas fa-code"></i>
                    <span>CODE DE TEST</span>
                </div>
                <div class="otp-display-code">
                    {{ session('otp_code_display') }}
                </div>
                <p class="otp-display-note">
                    <i class="fas fa-info-circle"></i>
                    Ce code est affiché car vous utilisez un email de test
                </p>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('status'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('status') }}
            </div>
        @endif

        <!-- Email Error -->
        @if (session('email_error'))
            <div class="alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('email_error') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert-error">
                <i class="fas fa-times-circle"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- OTP Form -->
        <form method="POST" action="{{ route('2fa.store') }}" id="otp-form">
            @csrf

            <div class="otp-container">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="off" data-index="0">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="off" data-index="1">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="off" data-index="2">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="off" data-index="3">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="off" data-index="4">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="off" data-index="5">
            </div>

            <!-- Hidden input for actual form submission -->
            <input type="hidden" name="code" id="code-hidden">

            <button type="submit" class="btn-verify">
                <i class="fas fa-check"></i>
                Vérifier le code
            </button>
            </form>

        <!-- Resend Code -->
        <div class="resend-section">
            <p class="resend-text">Vous n'avez pas reçu le code ?</p>
            <form method="POST" action="{{ route('2fa.resend') }}" id="resend-form">
                @csrf
                <button type="submit" class="btn-resend" id="resend-btn">
                    <i class="fas fa-redo"></i>
                    <span id="resend-text">Renvoyer le code</span>
                </button>
            </form>
        </div>

        <!-- Footer Info -->
        <div class="security-footer">
            <i class="fas fa-lock"></i>
            <span>Connexion sécurisée - Vos données sont protégées</span>
        </div>
    </div>
</div>

@push('styles')
    <style>

/* Background gradient */
.gradient-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    z-index: -1;
}

/* Auth wrapper */
.auth-wrapper-2fa {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.auth-card-2fa {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    width: 100%;
    max-width: 500px;
    padding: 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

/* Security Icon */
.security-icon-wrapper {
    margin-bottom: 30px;
}

.security-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    position: relative;
    animation: pulse 2s infinite;
}

.security-icon::before {
    content: '';
    position: absolute;
    width: 100px;
    height: 100px;
    border: 2px solid rgba(102, 126, 234, 0.3);
    border-radius: 50%;
    animation: ripple 2s infinite;
}

.security-icon i {
    font-size: 32px;
    color: white;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

@keyframes ripple {
    0% { transform: scale(0.8); opacity: 1; }
    100% { transform: scale(1.2); opacity: 0; }
}

/* Typography */
.auth-title-2fa {
    color: #333;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 10px;
    letter-spacing: -0.5px;
}

.auth-subtitle-2fa {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 30px;
}

/* OTP Display Card (for test mode) */
.otp-display-card {
    background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 30px;
    animation: slideDown 0.5s ease;
    border: 2px solid #ff9966;
}

.otp-display-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: #d35400;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 15px;
}

.otp-display-code {
    font-size: 32px;
    font-weight: 700;
    letter-spacing: 10px;
    color: #333;
    font-family: 'Courier New', monospace;
    background: rgba(255, 255, 255, 0.9);
    padding: 15px;
    border-radius: 8px;
    margin: 10px 0;
}

.otp-display-note {
    font-size: 12px;
    color: #7d6608;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    margin-top: 10px;
}

/* Alerts */
.alert-success,
.alert-warning,
.alert-error {
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    animation: slideDown 0.5s ease;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert-warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border: 1px solid #ffeaa7;
    color: #856404;
}

.alert-error {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.alert-success i {
    color: #28a745;
    font-size: 20px;
}

.alert-warning i {
    color: #ffc107;
    font-size: 20px;
}

.alert-error i {
    color: #dc3545;
    font-size: 20px;
}

.alert-error div p {
    margin: 0;
    font-size: 14px;
}

/* OTP Input Container */
.otp-container {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin: 40px 0;
}

.otp-input {
    width: 60px;
    height: 70px;
    font-size: 32px;
    text-align: center;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    background: #f8f9fa;
    transition: all 0.3s ease;
    font-weight: 700;
    color: #333;
}

.otp-input:focus {
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
    outline: none;
    transform: translateY(-2px);
}

.otp-input.filled {
    border-color: #28a745;
    background: #f0fff4;
}

.otp-input.error {
    border-color: #dc3545;
    background: #fff5f5;
    animation: shake 0.5s;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Buttons */
.btn-verify {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.btn-verify:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

.btn-verify:active {
    transform: translateY(0);
}

.btn-verify:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.btn-verify i {
    font-size: 18px;
}

/* Resend Section */
.resend-section {
    margin: 30px 0;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.resend-text {
    color: #666;
    font-size: 14px;
    margin-bottom: 15px;
}

.btn-resend {
    background: transparent;
    border: 2px solid #667eea;
    color: #667eea;
    padding: 12px 25px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin: 0 auto;
}

.btn-resend:hover:not(:disabled) {
    background: #667eea;
    color: white;
    transform: translateY(-1px);
}

.btn-resend:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    border-color: #ccc;
    color: #999;
}

/* Security Footer */
.security-footer {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: #666;
    font-size: 13px;
}

.security-footer i {
    color: #28a745;
    font-size: 14px;
}

/* Animations */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 576px) {
    .auth-card-2fa {
        padding: 30px 20px;
        margin: 20px;
    }

    .otp-container {
        gap: 10px;
    }

    .otp-input {
        width: 50px;
        height: 60px;
        font-size: 28px;
    }

    .otp-display-code {
        font-size: 24px;
        letter-spacing: 8px;
        padding: 12px;
    }

    .auth-title-2fa {
        font-size: 24px;
    }

    .security-icon {
        width: 70px;
        height: 70px;
    }

    .security-icon i {
        font-size: 28px;
    }
}

@media (max-width: 400px) {
    .otp-container {
        gap: 8px;
    }

    .otp-input {
        width: 45px;
        height: 55px;
        font-size: 24px;
    }

    .btn-resend {
        padding: 10px 20px;
        font-size: 13px;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .auth-card-2fa {
        background: #1a1a1a;
    }

    .auth-title-2fa {
        color: #f0f0f0;
    }

    .auth-subtitle-2fa {
        color: #aaa;
    }

    .otp-input {
        background: #2d2d2d;
        border-color: #444;
        color: #f0f0f0;
    }

    .otp-input:focus {
        border-color: #667eea;
        background: #333;
    }

    .resend-text {
        color: #aaa;
    }

    .security-footer {
        color: #aaa;
        border-top-color: #444;
    }

    .alert-success {
        background: linear-gradient(135deg, #1a472a 0%, #2e8b57 100%);
        border-color: #2e8b57;
        color: #d4edda;
    }

    .alert-warning {
        background: linear-gradient(135deg, #664d03 0%, #ffc107 100%);
        border-color: #ffc107;
        color: #fff3cd;
    }

    .alert-error {
        background: linear-gradient(135deg, #5c1c24 0%, #dc3545 100%);
        border-color: #dc3545;
        color: #f8d7da;
    }
}

/* Loading state */
.btn-verify.loading {
    position: relative;
    color: transparent;
}

.btn-verify.loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>
@endpush



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.otp-input');
    const form = document.getElementById('otp-form');
    const hiddenInput = document.getElementById('code-hidden');
    const resendBtn = document.getElementById('resend-btn');
    const resendText = document.getElementById('resend-text');

    // Focus first input
    inputs[0].focus();

    // Handle input
    inputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            const value = this.value;
            // Only allow numbers
            if (!/^\d*$/.test(value)) {
                this.value = '';
                return;
            }

            // Move to next input
            if (value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            // Update hidden input
            updateHiddenInput();
        });

        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                inputs[index - 1].focus();
            }
        });

        // Handle paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/\D/g, '');

            for (let i = 0; i < Math.min(pastedData.length, inputs.length); i++) {
                inputs[i].value = pastedData[i];
            }

            const lastFilledIndex = Math.min(pastedData.length, inputs.length) - 1;
            inputs[lastFilledIndex].focus();
            updateHiddenInput();
        });
    });

    // Update hidden input with combined OTP
    function updateHiddenInput() {
        let code = '';
        inputs.forEach(input => {
            code += input.value;
        });
        hiddenInput.value = code;
    }

    // Resend countdown
    let resendCooldown = 0;

    document.getElementById('resend-form').addEventListener('submit', function() {
        if (resendCooldown > 0) return;

        resendCooldown = 60;
        resendBtn.disabled = true;

        const interval = setInterval(() => {
            resendCooldown--;
            resendText.textContent = `Renvoyer (${resendCooldown}s)`;
            if (resendCooldown <= 0) {
                clearInterval(interval);
                resendBtn.disabled = false;
                resendText.innerHTML = '<i class="fas fa-redo"></i> Renvoyer le code';
            }
        }, 1000);
    });
});
</script>
@endpush
@endsection
