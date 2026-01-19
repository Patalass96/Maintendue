# MainTendue - Plateforme de Donation

## 📋 Vue d'ensemble

MainTendue est une plateforme collaborative de donation qui met en relation les donateurs avec les associations. Elle facilite le partage de biens, la création de besoins spécifiques et le suivi des donations.

## ✨ Fonctionnalités principales

### Pour les Donateurs
- **Gestion des donations**: Créer, modifier, publier des donations
- **Réservation**: Réserver des donations auprès des associations
- **Système de notation**: Évaluer les associations
- **Messagerie**: Communiquer directement avec les associations
- **Historique**: Suivre vos donations et réservations

### Pour les Associations
- **Gestion des besoins**: Définir les types de donations recherchées
- **Points de collecte**: Gérer les points physiques de collecte
- **Profil public**: Présenter l'association et ses projets
- **Réservations reçues**: Gérer les donations réservées
- **Conversations**: Communiquer avec les donateurs

### Pour les Administrateurs
- **Modération**: Gérer les signalements et les rapports
- **Gestion FAQ**: Maintenir la base de connaissances
- **Points de collecte**: Administrer tous les points
- **Utilisateurs**: Gérer les rôles et permissions
- **Analyses**: Statistiques et rapports

##  Architecture

### Stack Technique
- **Framework**: Laravel 11.x
- **Base de données**: MySQL
- **Frontend**: Blade templating + Bootstrap 5 + Alpine.js
- **Authentication**: Laravel Sanctum + 2FA + OAuth (Google, Facebook, GitHub, Twitter)
- **File Storage**: Laravel Storage avec disque public
- **Real-time**: Laravel Reverb (WebSocket)

### Structure du projet

```
app/
├── Models/                 # Eloquent models (19 modèles)
├── Http/
│   ├── Controllers/       # 22+ controllers
│   ├── Requests/          # Form requests
│   ├── Resources/         # API resources
│   └── Middleware/        # Custom middleware
├── Services/              # Business logic services
│   ├── NotificationService
│   ├── ReportService
│   ├── SearchService
│   ├── LocationService
│   └── FileUploadService
├── Policies/              # Authorization policies
├── Events/                # Event classes
├── Listeners/             # Event listeners
├── Mail/                  # Mailable classes
└── Providers/             # Service providers

resources/
├── views/                 # Blade templates
│   ├── layouts/          # Layout files
│   ├── admin/            # Admin panel views
│   ├── donations/        # Donation management
│   ├── reviews/          # Reviews system
│   ├── associations/     # Association views
│   └── ...
└── css/, js/             # Frontend assets

database/
├── migrations/           # 26 migrations
├── factories/            # Model factories
└── seeders/              # Database seeders

routes/
├── web.php               # Web routes (80+)
├── channels.php          # Broadcasting channels
└── console.php           # Console routes
```

##  Modèles de données

### Entités principales
1. **User** - Utilisateurs (donateurs, associations, admins)
2. **Donation** - Dons proposés
3. **DonationRequest** - Besoins d'associations
4. **Association** - Organisations partenaires
5. **AssociationNeed** - Besoins spécifiques
6. **Review** - Évaluations et avis
7. **Report** - Signalements
8. **Conversation** - Communications entre utilisateurs
9. **CollectionPoint** - Points de collecte physiques
10. **Category** - Catégories de donations
11. **Faq** - Base de connaissances
12. **SocialAccount** - Comptes sociaux liés

##  Authentification et Autorisation

### Rôles
- `admin` - Administrateur système
- `association` - Organisations
- `donateur` - Contributeurs individuels

### Authentification multi-niveaux
- Email/Mot de passe
- Two-Factor Authentication (2FA)
- OAuth social (Google, Facebook, GitHub, Twitter)
- Session-based + Token-based (Sanctum)

### Policies
- `CollectionPointPolicy` - Gestion des points
- `AssociationNeedPolicy` - Gestion des besoins
- `FaqPolicy` - Gestion FAQ
- `SocialAccountPolicy` - Gestion comptes sociaux
- `ReviewPolicy` - Gestion des avis

## 📱 Routes principales

### Publiques
```
GET  /                           # Accueil
GET  /associations               # Liste des associations
GET  /associations/{id}          # Profil association
GET  /donations                  # Catalogue de donations
GET  /faq                        # Page FAQ
```

### Authentifiées (Donateurs)
```
GET  /donator/dashboard
GET  /donator/profile
POST /donations                  # Créer une donation
PUT  /donations/{id}             # Modifier
GET  /donations/{id}             # Détail
```

### Authentifiées (Associations)
```
GET  /association/dashboard
GET  /association/needs          # Mes besoins
POST /association/needs          # Créer besoin
GET  /association/donation/available
POST /donations/{donation}/accept
```

### Administration
```
GET  /admin/dashboard
GET  /admin/collection-points    # Points de collecte
GET  /admin/faqs                 # FAQ management
GET  /admin/moderation/reports   # Signalements
GET  /admin/users                # Gestion utilisateurs
```

##  Services

### NotificationService
- Créer/envoyer notifications
- Gérer les paramètres utilisateur
- Marquer comme lu

### ReportService
- Créer signalements
- Résoudre/rejeter rapports
- Statistiques

### SearchService
- Recherche donations/associations
- Filtrage par catégorie/distance
- Recommandations personnalisées

### LocationService
- Calcul de distances
- Géocodage (Nominatim)
- Validation coordonnées

### FileUploadService
- Upload d'images
- Génération miniatures
- Validation fichiers

##  Installation et configuration

### Prérequis
- PHP 8.2+
- MySQL 8.0+
- Node.js 18+
- Composer

### Setup
```bash
# Clone le repo
git clone <repository>

# Installation
composer install
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données
php artisan migrate
php artisan db:seed

# Assets
npm run dev

# Server
php artisan serve
```

##  Tests

```bash
# Tests unitaires
php artisan test

# Avec couverture
php artisan test --coverage
```

## 📚 Documentation supplémentaire

- [AUDIT_PROJET.md](AUDIT_PROJET.md) - Audit complet du projet
- [ROADMAP.md](ROADMAP.md) - Roadmap de développement
- [PROJECT_STRUCTURE.md](PROJECT_STRUCTURE.md) - Architecture détaillée

##  Étapes suivantes

### Court terme
- [ ] Écrire tests complets
- [ ] Optimiser requêtes base de données
- [ ] Implémenter indexing MySQL
- [ ] Ajouter pagination

### Moyen terme
- [ ] Système de notifications push
- [ ] Intégration Google Maps
- [ ] Export données CSV/PDF
- [ ] API REST complète

### Long terme
- [ ] Application mobile (React Native)
- [ ] Machine learning recommandations
- [ ] Système de gamification
- [ ] Marketplace intégrée

##  Licence

Ce projet est sous licence MIT.

## 👥 Contribution

Les contributions sont bienvenues! Veuillez consulter CONTRIBUTING.md pour les guidelines.

##  Support

Pour toute question ou problème, ouvrir une issue sur GitHub.

---

**Dernière mise à jour**: 2024
**Version**: 1.0.0
**Statut**: En développement
