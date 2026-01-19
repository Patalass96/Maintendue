# 📁 STRUCTURE DU PROJET MAINTENDUE

## 🎯 Vue d'ensemble

MainTendue est une plateforme de partage de dons qui connecte:
- 👥 **Donateurs** (particuliers)
- 🏢 **Associations** (organisations à but non lucratif)
- 🎁 **Dons** (objets, denrées, services)
- 📍 **Points de collecte** (lieux physiques)

---

## 📊 Architecture des Données

```
USERS (Centrale)
├── Role: admin, association, donateur
├── Avatar, phone, localisation
└── Statut: active, suspended, inactive

ASSOCIATIONS (Profil d'association)
├── Manager (user_id)
├── Legal info (registration, address)
├── Settings (delivery_radius, accepts_direct_delivery)
├── Statistics (total_donations, satisfaction_rate)
└── Verification status (pending, verified, rejected)

COLLECTION_POINTS (Points physiques)
├── Association FK
├── Localisation (lat, lng)
└── Horaires, instructions

DONATIONS (Annonces de dons)
├── Donor (user_id)
├── Category
├── Status (available, reserved, delivered, cancelled)
├── Location (city, address)
├── Images (multiple)
└── Timestamps

DONATION_IMAGES
├── Donation FK
├── Image path
└── Order index

DONATION_REQUESTS (Demandes des associations)
├── Donation FK
├── Association FK
├── Status (pending, accepted, rejected, cancelled, completed)
├── Admin notes
└── Messages

CONVERSATIONS (Messaging entre utilisateurs)
├── Participants (user1, user2, optionnel donation)
└── Started at

MESSAGES (Contenu des conversations)
├── Conversation FK
├── Sender FK
├── Content
├── Read at
└── Timestamps

REVIEWS (Avis/évaluations)
├── Reviewer (user_id)
├── Reviewed (user_id)
├── Donation FK (nullable)
├── Rating (1-5)
├── Comment
├── Response (du reviewed)
└── Is visible

REPORTS (Signalements)
├── Reporter (user_id)
├── Reported (polymorphe: User, Donation, Association, Review)
├── Reason (spam, inappropriate, fraud, other)
├── Status (pending, reviewed, resolved, dismissed)
├── Admin notes
├── Resolved by (admin_id)
└── Resolved at

NOTIFICATIONS (Alertes utilisateur)
├── User FK
├── Type (donation_published, review_received, etc)
├── Data (JSON)
├── Read at
└── Timestamps

USER_NOTIFICATION_SETTINGS
├── User FK
├── Preferences (JSON ou colonnes)
├── Opt-in/out par type

CATEGORIES (Classification des dons)
├── Name, slug
├── Icon, description
├── Is active
└── Order index

ADMIN_ACTIONS (Audit trail)
├── Admin FK
├── Action type
├── Target (polymorphe)
├── Description
├── Metadata (JSON)
└── Timestamps

ASSOCIATION_NEEDS (Besoins des associations)
├── Association FK
├── Title, description
├── Item type (clothing, shoes, food, school, furniture, other)
├── Quantity, condition
├── Urgency (low, medium, high, urgent)
└── Status

FAQS (Questions fréquemment posées)
├── Category
├── Question, answer
├── Is visible
├── Order index
└── Timestamps

APP_SETTINGS (Configuration)
├── Key
├── Value (JSON)
└── Description

SOCIAL_ACCOUNTS (OAuth)
├── User FK
├── Provider (google, facebook, twitter, etc)
├── Provider ID
├── Unique constraint (user + provider)
└── Timestamps
```

---

## 🔄 Flux Principal (User Journey)

### 1️⃣ Donateur
```
Register → Login → Create Donation → 
Upload Images → Wait for Offers → 
Accept Association → Chat → 
Mark Delivered → Leave Review
```

### 2️⃣ Association
```
Register → Complete Profile → 
Validation (Admin) → Browse Donations → 
Request Donation → Chat with Donor → 
Receive Donation → Leave Review
```

### 3️⃣ Admin
```
Login → Dashboard → 
Validate Associations → 
Manage Users → 
Moderate Content → 
View Reports → 
Settings & FAQs Management
```

---

## 📁 Structure des Dossiers

```
app/
├── Console/
│   └── Commands/ (artisan commands)
├── Events/
│   ├── DonationDelivered
│   ├── DonationPublished
│   ├── DonationRequestCreated
│   ├── DonationReserved
│   └── NewDonationPublished
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── AdminController
│   │   │   └── ModerationController
│   │   ├── Auth/
│   │   │   ├── LoginController
│   │   │   ├── RegisterController
│   │   │   ├── ForgotPasswordController
│   │   │   ├── ResetPasswordController
│   │   │   ├── TwoFactorController
│   │   │   └── SocialAuthController
│   │   ├── Shared/
│   │   │   ├── NotificationController
│   │   │   ├── ReportController
│   │   │   └── ReviewController
│   │   ├── AssociationController
│   │   ├── CategoryController
│   │   ├── ConversationController
│   │   ├── DonationController
│   │   ├── DonatorController
│   │   ├── NotificationController
│   │   ├── PageController
│   │   ├── ProfileController
│   │   ├── ReportController
│   │   └── UserController
│   ├── Middleware/
│   └── Services/
│       └── NotificationService
├── Listeners/
│   ├── SendDeliveryNotifications
│   └── SendNewRequestNotification
├── Mail/
│   ├── ResetPasswordMail
│   ├── TestMail
│   └── WelcomeMail
├── Models/
│   ├── AdminAction
│   ├── AppSetting
│   ├── Association
│   ├── AssociationNeed
│   ├── Category
│   ├── CollectionPoint
│   ├── Conversation
│   ├── Donation
│   ├── DonationImage
│   ├── DonationRequest
│   ├── Faq
│   ├── Message
│   ├── Notification
│   ├── Report
│   ├── Review
│   ├── SocialAccount
│   ├── User
│   └── UserNotificationSetting
├── Notifications/
│   ├── NewDonationAvailable
│   └── SendOtpNotification
├── Policies/
│   └── ReviewPolicy
├── Providers/
│   └── (ServiceProviders)
└── View/ (View composers)

database/
├── factories/
│   └── (Model factories pour tests)
├── migrations/
│   ├── (26 migrations)
│   └── (Tous les schemas)
└── seeders/
    ├── DatabaseSeeder
    ├── CategorySeeder
    ├── UserSeeder
    ├── AssociationSeeder
    ├── CollectionPointSeeder
    ├── DonationSeeder
    ├── FaqSeeder
    └── AppSettingSeeder

resources/
├── css/
│   ├── app.css
│   ├── admin.css
│   ├── dashboard.css
│   ├── home.css
│   └── Autres...
├── js/
│   ├── app.js
│   ├── home.js
│   └── Autres...
└── views/
    ├── admin/
    │   ├── dashboard
    │   ├── users
    │   ├── associations
    │   ├── moderation/reports/show
    │   ├── settings
    │   ├── validateAssociation
    │   └── Autres
    ├── associations/
    │   ├── index (liste publique)
    │   ├── show (profil public)
    │   ├── dashboard (privé)
    │   ├── complete-profile
    │   ├── pending
    │   └── Autres...
    ├── auth/
    │   ├── login
    │   ├── register
    │   ├── forgot-password
    │   ├── reset-password
    │   └── 2fa
    ├── conversations/
    │   ├── index
    │   └── show
    ├── donations/
    │   ├── index (liste)
    │   ├── create
    │   ├── edit
    │   └── show
    ├── donator/
    │   ├── dashboard
    │   └── profile
    ├── layouts/
    │   ├── app
    │   ├── admin
    │   ├── association
    │   ├── auth
    │   ├── footer
    │   ├── header
    │   ├── validate
    │   └── Autres
    ├── notifications/
    │   └── index
    ├── pages/
    │   ├── home
    │   ├── about
    │   ├── faq
    │   ├── privacy
    │   ├── terms
    │   ├── mentions-legales
    │   └── contact
    ├── profile/
    │   ├── edit
    │   └── dashboard
    ├── reviews/
    │   ├── index
    │   ├── create
    │   └── show
    └── errors/
        ├── 404
        ├── 500
        └── Autres

routes/
├── web.php (toutes les routes)
├── channels.php (WebSockets)
└── console.php

tests/
├── Feature/
│   └── (Tests des contrôleurs)
├── Unit/
│   └── (Tests des modèles)
└── TestCase.php

config/
├── app.php
├── auth.php
├── database.php
├── filesystems.php
├── mail.php
├── queue.php
├── services.php
└── Autres

public/
├── index.php
├── robots.txt
├── assets/
│   ├── images/
│   │   ├── hero/
│   │   ├── MainTendue.png
│   │   └── Autres
│   └── fonts/
└── build/ (Vue build output)

storage/
├── app/ (uploads utilisateurs)
├── framework/ (cache, sessions)
└── logs/

.env (Configuration)
.env.example
composer.json
package.json
vite.config.js
postcss.config.js
tailwind.config.js
phpunit.xml
artisan (CLI)
```

---

## 🔐 Permissions & Rôles

```
┌──────────────────────────────────────────────┐
│            MATRICE DE PERMISSIONS             │
├────────────────┬──────┬──────────┬──────────┤
│ Action         │ Admin│Association│Donateur │
├────────────────┼──────┼──────────┼──────────┤
│ Voir accueil   │  ✅  │    ✅     │   ✅    │
│ Créer don      │  ✅  │    ✅     │   ✅    │
│ Modifier don   │  ✅  │    ✅ *   │   ✅ **  │
│ Valider assoc  │  ✅  │    ❌     │   ❌    │
│ Signaler user  │  ✅  │    ✅     │   ✅    │
│ Modérer contenu│  ✅  │    ❌     │   ❌    │
│ Gestion FAQs   │  ✅  │    ❌     │   ❌    │
│ Voir stats     │  ✅  │    ✅ ***  │   ❌    │
│ Créer besoin   │  ❌  │    ✅     │   ❌    │
│ Demander don   │  ❌  │    ✅     │   ❌    │
└────────────────┴──────┴──────────┴──────────┘

* Seulement les siens
** Seulement les leurs
*** Seulement les leurs
```

---

## 🔗 Relations Principales

```
User
├── 1:1 Association (user.id = association.user_id)
├── 1:N Donations (user.id = donation.donor_id)
├── 1:N Reviews (reviewer ou reviewed)
├── 1:N Conversations (participant)
├── 1:N Messages
├── 1:N Reports (reporter)
├── 1:N SocialAccounts
├── 1:N UserNotificationSettings
└── 1:N Notifications

Donation
├── N:1 User (donor)
├── N:1 Category
├── N:1 Association (assigned)
├── 1:N DonationImages
├── 1:N DonationRequests
├── 1:N Reviews
├── 1:N Messages (dans conversations)
└── 1:N Reports

Association
├── N:1 User (manager)
├── 1:N CollectionPoints
├── 1:N DonationRequests
├── 1:N AssociationNeeds
└── 1:N Reports

Review
├── N:1 User (reviewer)
├── N:1 User (reviewed)
├── N:1 Donation (optionnel)
└── 1:N Reports (signalements)

Report
├── N:1 User (reporter)
├── N:1 User (resolved_by)
├── Polymorphe reported (User, Donation, Association, Review)
└── 1:N AdminActions

Conversation
├── N:M User (participants)
├── 1:N Messages
└── N:1 Donation (optionnel)
```

---

## 📊 Statistiques du Code

| Métrique | Valeur |
|----------|--------|
| Models | 19 |
| Controllers | 22 |
| Migrations | 26 |
| Routes | 80+ |
| Views | 50+ |
| Tests | À compléter |
| Total Lines of Code | ~50000+ |
| Languages | PHP, Blade, Vue/JS, CSS, SQL |

---

**Mise à jour:** 19 Janvier 2026
**Version:** Beta 0.7 
