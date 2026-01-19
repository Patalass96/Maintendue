# 🚀 Quick Start - MainTendue

## Installation rapide

### 1. Dépendances
```bash
composer install
npm install
```

### 2. Configuration
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database
```bash
php artisan migrate
php artisan db:seed
```

### 4. Assets
```bash
npm run dev
# ou en production
npm run build
```

### 5. Server
```bash
php artisan serve
# Accéder à http://localhost:8000
```

## Comptes de test

### Admin
- Email: `admin@maintendue.test`
- Mot de passe: `password`

### Association
- Email: `association@maintendue.test`
- Mot de passe: `password`

### Donateur
- Email: `donateur@maintendue.test`
- Mot de passe: `password`

## Routes principales

### Publiques
- `/` - Accueil
- `/associations` - Liste associations
- `/associations/{id}` - Profil association
- `/donations` - Catalogue donations

### Admin Panel
- `/admin/dashboard` - Dashboard admin
- `/admin/collection-points` - Points de collecte
- `/admin/faqs` - FAQ management
- `/admin/moderation/reports` - Rapports

### Association Dashboard
- `/association/dashboard` - Dashboard
- `/association/needs` - Mes besoins
- `/association/donation/available` - Donations reçues

### Donateur Dashboard
- `/donator/dashboard` - Dashboard
- `/donations/create` - Créer donation
- `/reviews/user/{id}` - Avis reçus

## Tests rapides

### Tests unitaires
```bash
php artisan test
```

### Tests spécifiques
```bash
php artisan test --filter=DonationTest
php artisan test --filter=ReviewTest
```

### Avec couverture
```bash
php artisan test --coverage
```

## Commandes utiles

### Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Database
```bash
php artisan migrate:refresh    # Reset & remigrate
php artisan migrate:rollback   # Undo dernière migration
php artisan tinker             # REPL interactif
```

### Assets
```bash
npm run dev      # Mode développement
npm run build    # Production build
npm run watch    # Watch mode
```

## Structure de fichiers clés

```
app/
├── Services/
│   ├── NotificationService.php     # Gestion notifications
│   ├── ReportService.php           # Gestion rapports
│   ├── SearchService.php           # Recherche
│   ├── LocationService.php         # Géolocalisation
│   └── FileUploadService.php       # Uploads fichiers

├── Policies/
│   ├── CollectionPointPolicy.php
│   ├── AssociationNeedPolicy.php
│   ├── FaqPolicy.php
│   └── SocialAccountPolicy.php

routes/
└── web.php                         # Toutes les routes

resources/views/
├── admin/
│   ├── collection-points/         # 4 views
│   └── faqs/                       # 4 views
├── association-needs/              # 4 views
└── profile/
    └── social-accounts.blade.php   # 1 view
```

## Debugging

### Logs
```bash
tail -f storage/logs/laravel.log
```

### Debugbar (si installé)
- Barre en bas à droite de chaque page
- Queries, events, logs

### Tinker
```bash
php artisan tinker
> User::count()
> Donation::with('donator')->first()
```

## Problèmes courants

### 404 on routes
```bash
php artisan route:clear
php artisan route:cache  # Production
```

### 500 errors
```bash
php artisan config:clear
php artisan cache:clear
tail -f storage/logs/laravel.log
```

### Permissions storage
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Déploiement

### Production build
```bash
npm run build
php artisan optimize
```

### Environment
```
APP_ENV=production
APP_DEBUG=false
```

## Resources

- [Laravel Docs](https://laravel.com/docs)
- [Bootstrap 5](https://getbootstrap.com/docs/5.0)
- [Alpine.js](https://alpinejs.dev/)

## Support

Pour les problèmes:
1. Vérifier les logs: `storage/logs/laravel.log`
2. Vérifier .env configuration
3. Vérifier migrations: `php artisan migrate:status`
4. Consulter documentation complète

---

**Quick Start v1.0** | Prêt à développer! 🎉
