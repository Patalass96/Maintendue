@component('mail::message')
# Réinitialisation de votre mot de passe

Bonjour {{ $userName }},

Vous avez demandé la réinitialisation de votre mot de passe MainTendue. Cliquez sur le bouton ci-dessous pour continuer :

@component('mail::button', ['url' => $resetLink])
Réinitialiser mon mot de passe
@endcomponent

Ce lien expirera dans **60 minutes**.

Si vous n'avez pas demandé cette réinitialisation, vous pouvez ignorer cet email.

---

**Conseils de sécurité :**
- N'utilisez jamais le même mot de passe pour plusieurs services
- Choisissez un mot de passe fort contenant des majuscules, minuscules, chiffres et caractères spéciaux
- Ne partagez jamais votre mot de passe

Cordialement,<br>
**L'équipe MainTendue**

@endcomponent
