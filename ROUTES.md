# 🛣️ Routes Documentation - MainTendue

## Aperçu général

```
Total Routes: 80+
Groupes: 10+
Middleware: auth, 2fa, verify.association, role:*
```

---

## 📍 Routes publiques

### Accueil & Pages
```
GET  /                          # Accueil
GET  /about                     # À propos
GET  /faq                       # FAQ publique
GET  /privacy                   # Politique privacy
GET  /terms                     # Conditions d'utilisation
GET  /mentions-legales          # Mentions légales
```

### Associations publiques
```
GET  /associations              # Liste associations
GET  /associations/{id}         # Détail association
```

### Donations publiques
```
GET  /donations                 # Catalogue donations
GET  /donations/{id}            # Détail donation
```

---

## 👤 Routes Authentification

### Login/Register
```
GET  /login                     # Formulaire login
POST /login                     # Traiter login
GET  /register                  # Formulaire register
POST /register                  # Traiter register
GET  /forgot-password           # Oubli mot de passe
POST /forgot-password           # Envoyer reset link
GET  /reset-password/{token}    # Reset password form
POST /reset-password            # Reset password
```

### Two-Factor Authentication
```
GET  /two-factor-challenge      # Challenge 2FA
POST /two-factor-challenge      # Vérifier 2FA
POST /two-factor-authentication # Activer 2FA
DELETE /two-factor-authentication # Désactiver 2FA
```

### OAuth Social
```
GET  /auth/redirect/{provider}  # Redirect vers provider
GET  /auth/callback/{provider}  # Callback oauth
```

---

## 🎯 Routes Donateur

### Dashboard & Profil
```
GET  /donator/dashboard         # Dashboard donateur
GET  /donator/profile           # Profil
```

### Donation Management
```
GET  /donations/create          # Formulaire création
POST /donations                 # Créer donation
GET  /donations/{id}/edit       # Formulaire édition
PUT  /donations/{id}            # Mettre à jour
DELETE /donations/{id}          # Supprimer
GET  /donations/{id}            # Détail donation
POST /donations/{id}/reserve    # Réserver donation
POST /donations/{id}/mark-delivered # Marquer livré
```

---

## 🏢 Routes Association

### Authentication spécifique
```
GET  /associations/complete-profile    # Compléter profil
POST /associations/complete-profile    # Soumettre profil
GET  /associations/pending             # Attente vérification
```

### Dashboard & Profil
```
GET  /association/dashboard                    # Dashboard
GET  /association/associations/profile.show    # Profil
GET  /association/associations/profile.edit    # Édition profil
PUT  /association/associations/profile.update  # Mettre à jour
GET  /association/settings                    # Paramètres
```

### Donation Management
```
GET  /association/donation/available          # Dons disponibles
GET  /association/donation/received           # Dons reçus
POST /donations/{id}/accept                   # Accepter don
POST /donations/{id}/deliver                  # Marquer livré
PUT  /donations/{id}/status                   # Changer statut
```

### Association Needs ✨
```
GET  /association/needs                       # Mes besoins
GET  /association/needs/create                # Formulaire création
POST /association/needs                       # Créer besoin
GET  /association/needs/{id}                  # Détail besoin
GET  /association/needs/{id}/edit             # Formulaire édition
PUT  /association/needs/{id}                  # Mettre à jour
DELETE /association/needs/{id}                # Supprimer
POST /association/needs/{id}/toggle           # Activer/désactiver
```

### Messaging
```
GET  /association/messages                    # Messages
```

### Requests
```
GET  /association/requests                    # Mes demandes
GET  /association/requests/create             # Formulaire création
POST /association/requests                    # Créer demande
```

---

## 👥 Routes Utilisateur Authentifiés

### Profile Management
```
GET  /profile/edit              # Éditer profil
PUT  /profile/update            # Mettre à jour profil
GET  /dashboard                 # Dashboard
```

### Social Accounts ✨
```
GET  /social-accounts           # Liste comptes sociaux
GET  /social-accounts/connect/{provider}     # Initier connexion
GET  /social-accounts/callback/{provider}    # Callback connexion
DELETE /social-accounts/{id}    # Déconnecter
```

---

## 💬 Routes Conversations (Authentifiées)

```
GET  /conversations             # Mes conversations
GET  /conversations/{id}        # Détail conversation
POST /conversations/{id}/messages # Envoyer message
POST /conversations/start/{donation} # Démarrer conversation
```

---

## ⭐ Routes Avis/Reviews (Authentifiées)

```
GET  /reviews/user/{id}         # Avis reçus par utilisateur
GET  /reviews/{id}              # Détail avis
GET  /reviews/donation/{id}/create # Formulaire création avis
POST /reviews/donation/{id}     # Créer avis
POST /reviews/{id}/reply        # Répondre à avis
POST /reviews/{id}/report       # Signaler avis
```

---

## 🚨 Routes Admin

### Dashboard & General
```
GET  /admin/dashboard           # Dashboard admin
GET  /admin/users               # Gestion utilisateurs
GET  /admin/users/{id}          # Détail utilisateur
GET  /admin/users/{id}/edit     # Éditer utilisateur
PUT  /admin/users/{id}          # Mettre à jour
DELETE /admin/users/{id}        # Supprimer utilisateur
PUT  /admin/users/{id}/suspend  # Suspendre utilisateur
PUT  /admin/users/{id}/activate # Activer utilisateur
PUT  /admin/users/{id}/promote  # Promouvoir en admin
```

### Categories
```
GET  /admin/categories          # Liste catégories
POST /admin/categories          # Créer catégorie
DELETE /admin/categories/{id}   # Supprimer catégorie
```

### Collection Points ✨
```
GET  /admin/collection-points           # Liste points
GET  /admin/collection-points/create    # Formulaire création
POST /admin/collection-points           # Créer point
GET  /admin/collection-points/{id}      # Détail point
GET  /admin/collection-points/{id}/edit # Formulaire édition
PUT  /admin/collection-points/{id}      # Mettre à jour
DELETE /admin/collection-points/{id}    # Supprimer
PUT  /admin/collection-points/{id}/toggle # Activer/désactiver
```

### FAQ ✨
```
GET  /admin/faqs                # Liste FAQ
GET  /admin/faqs/create         # Formulaire création
POST /admin/faqs                # Créer FAQ
GET  /admin/faqs/{id}           # Détail FAQ
GET  /admin/faqs/{id}/edit      # Formulaire édition
PUT  /admin/faqs/{id}           # Mettre à jour
DELETE /admin/faqs/{id}         # Supprimer FAQ
POST /admin/faqs/reorder        # Réordonnancer FAQ
```

### Moderation & Reports
```
GET  /admin/moderation/reports          # Liste rapports
GET  /admin/moderation/reports/{id}     # Détail rapport
PUT  /admin/moderation/reports/{id}/mark-reviewed # Marquer examiné
POST /admin/moderation/reports/{id}/resolve       # Résoudre
POST /admin/moderation/reports/{id}/dismiss       # Rejeter
DELETE /admin/moderation/reports/{id}   # Supprimer
GET  /admin/moderation/reports/filter   # Filtrer rapports
```

---

## 🏗️ Groupes de Routes

### Publiques (No Auth)
```
route/
├─ GET  /
├─ GET  /about, /faq, /privacy, /terms, /mentions-legales
├─ GET  /associations
├─ GET  /associations/{id}
├─ GET  /donations
└─ GET  /donations/{id}
```

### Authentication
```
route/
├─ GET  /login
├─ POST /login
├─ GET  /register
├─ POST /register
├─ GET  /forgot-password
├─ POST /forgot-password
├─ GET  /reset-password/{token}
├─ POST /reset-password
├─ GET  /auth/redirect/{provider}
└─ GET  /auth/callback/{provider}
```

### 2FA
```
Middleware: auth
route/
├─ GET  /two-factor-challenge
├─ POST /two-factor-challenge
├─ POST /two-factor-authentication
└─ DELETE /two-factor-authentication
```

### Donateur
```
Middleware: auth, 2fa, role:donateur
route/donator/
├─ GET  /dashboard
└─ GET  /profile
```

### Association
```
Middleware 1: auth
route/associations/
├─ GET  /complete-profile
├─ POST /complete-profile
└─ GET  /pending

Middleware 2: auth, 2fa, verify.association
route/association/
├─ GET  /dashboard
├─ GET  /associations/profile.show
├─ GET  /associations/profile.edit
├─ PUT  /associations/profile.update
├─ GET  /settings
├─ GET  /donation/available
├─ GET  /donation/received
├─ POST /donations/{id}/accept
├─ POST /donations/{id}/deliver
├─ PUT  /donations/{id}/status
├─ GET  /needs
├─ POST /needs
├─ GET  /needs/{id}
├─ GET  /needs/{id}/edit
├─ PUT  /needs/{id}
├─ DELETE /needs/{id}
├─ POST /needs/{id}/toggle
├─ GET  /messages
├─ GET  /requests
└─ POST /requests
```

### Admin
```
Middleware: auth, 2fa, role:admin
route/admin/
├─ GET  /dashboard
├─ GET  /users
├─ GET  /users/{id}
├─ GET  /users/{id}/edit
├─ PUT  /users/{id}
├─ DELETE /users/{id}
├─ PUT  /users/{id}/suspend
├─ PUT  /users/{id}/activate
├─ PUT  /users/{id}/promote
├─ GET  /categories
├─ POST /categories
├─ DELETE /categories/{id}
├─ GET  /collection-points
├─ GET  /collection-points/create
├─ POST /collection-points
├─ GET  /collection-points/{id}
├─ GET  /collection-points/{id}/edit
├─ PUT  /collection-points/{id}
├─ DELETE /collection-points/{id}
├─ PUT  /collection-points/{id}/toggle
├─ GET  /faqs
├─ GET  /faqs/create
├─ POST /faqs
├─ GET  /faqs/{id}
├─ GET  /faqs/{id}/edit
├─ PUT  /faqs/{id}
├─ DELETE /faqs/{id}
├─ POST /faqs/reorder
└─ Moderation routes (reports)
```

### Shared Authenticated
```
Middleware: auth, 2fa
route/donations/
├─ GET  /
├─ GET  /create
├─ POST /
├─ GET  /{id}/edit
├─ PUT  /{id}
├─ DELETE /{id}
├─ POST /{id}/reserve
└─ POST /{id}/mark-delivered

route/conversations/
├─ GET  /
├─ GET  /{id}
├─ POST /{id}/messages
└─ POST /start/{donation}

route/reviews/
├─ GET  /user/{user}
├─ GET  /{id}
├─ GET  /donation/{donation}/create
├─ POST /donation/{donation}
├─ POST /{id}/reply
└─ POST /{id}/report
```

---

## 🔗 Conventions de nommage

### Route names
```
admin.collection-points.index
admin.collection-points.create
admin.collection-points.store
admin.collection-points.show
admin.collection-points.edit
admin.collection-points.update
admin.collection-points.destroy
admin.collection-points.toggle

associations.needs.index
associations.needs.create
associations.needs.store
associations.needs.show
associations.needs.edit
associations.needs.update
associations.needs.destroy
associations.needs.toggle

social-accounts.index
social-accounts.connect
social-accounts.callback
social-accounts.disconnect
```

### URL patterns
```
/resource               # Index
/resource/create       # Create form
POST /resource         # Store
/resource/{id}         # Show
/resource/{id}/edit    # Edit form
PUT /resource/{id}     # Update
DELETE /resource/{id}  # Destroy
POST /resource/{id}/action # Custom action
```

---

## 🔐 Middleware Stack

### Auth (Authentification)
```
auth              Utilisateur authentifié
2fa               Two-Factor Authentication validé
verify.association Association vérifiée
role:admin        Admin uniquement
role:association  Association uniquement
role:donateur     Donateur uniquement
```

---

## 📊 Résumé statistiques

| Catégorie | Nombre |
|-----------|--------|
| Routes publiques | 7 |
| Routes auth | 10 |
| Routes 2fa | 4 |
| Routes donateur | 10 |
| Routes association | 25 |
| Routes utilisateur | 5 |
| Routes conversations | 4 |
| Routes reviews | 6 |
| Routes admin | 35 |
| **Total** | **~100** |

---

## 📝 Notes importantes

1. **Paramètres obligatoires**
   - `{id}` - ID de ressource
   - `{provider}` - Provider OAuth (google, facebook, github, twitter)

2. **Query parameters courants**
   - `page` - Pagination
   - `sort` - Tri
   - `filter` - Filtrage
   - `search` - Recherche

3. **Middleware d'ordre**
   - auth → 2fa → role/verify → specific

4. **Ressources imbriquées**
   - Donations sous association
   - Messages sous conversation
   - Avis sous utilisateur

---

## 🚀 Utilisation

### Dans les templates Blade
```blade
<a href="{{ route('admin.collection-points.index') }}">
    Voir les points
</a>

<form action="{{ route('associations.needs.store') }}" method="POST">
    @csrf
    <!-- form content -->
</form>
```

### Redirection dans controllers
```php
return redirect()->route('admin.collection-points.show', $point);
return redirect()->route('associations.needs.index');
```

### En JavaScript/Alpine
```javascript
fetch(route('admin.faqs.reorder'), {
    method: 'POST',
    body: JSON.stringify(data)
})
```

---

**Route Documentation** | v1.0.0 | 2024
