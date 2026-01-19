# 💡 Exemples d'utilisation des Services

## NotificationService

### Exemple 1: Créer une notification pour un utilisateur
```php
use App\Services\NotificationService;
use App\Models\User;

$notificationService = app(NotificationService::class);
$user = User::find(1);

// Créer une notification
$notificationService->notify(
    $user,
    'donation_published',
    'Une nouvelle donation est disponible!',
    ['donation_id' => 42],
    '/donations/42'
);
```

### Exemple 2: Initialiser les paramètres de notification
```php
// Pour un nouvel utilisateur
$user = User::create([...]);
$notificationService->initializeNotificationSettings($user);
```

### Exemple 3: Obtenir les notifications non lues
```php
// Récupérer les 10 dernières non lues
$unread = $notificationService->getUnreadNotifications($user, 10);

// Compter les non lues
$count = $notificationService->getUnreadCount($user);
```

### Exemple 4: Marquer comme lues
```php
// Marquer une notification
$notificationService->markAsRead($notification);

// Marquer toutes les notifications
$notificationService->markAllAsRead($user);
```

### Exemple 5: Désactiver des notifications
```php
// Désactiver les notifications de donations
$notificationService->updateSetting($user, 'donation_published', false);
```

## ReportService

### Exemple 1: Signaler un utilisateur
```php
use App\Services\ReportService;

$reportService = app(ReportService::class);

// Créer un rapport
$report = $reportService->create(
    auth()->user(),              // Rapporteur
    'App\Models\User',           // Type entité
    5,                           // ID entité
    'comportement_offensant',    // Raison
    'Description détaillée du problème...'
);
```

### Exemple 2: Obtenir les rapports en attente
```php
$pending = $reportService->getPendingReports(20);

foreach ($pending as $report) {
    echo $report->reason;
    echo $report->description;
}
```

### Exemple 3: Résoudre un rapport (Admin)
```php
$reportService->resolve(
    $report,
    auth()->user(),  // Admin
    'user_suspended',
    'Utilisateur suspendu pour 30 jours'
);
```

### Exemple 4: Rejeter un rapport
```php
$reportService->dismiss(
    $report,
    auth()->user(),
    'Pas de violation détectée'
);
```

### Exemple 5: Obtenir les statistiques
```php
$stats = $reportService->getStats();

echo "Total: " . $stats['total'];
echo "En attente: " . $stats['pending'];
echo "Résolus: " . $stats['resolved'];
```

## SearchService

### Exemple 1: Recherche donations
```php
use App\Services\SearchService;

$searchService = app(SearchService::class);

// Recherche avec filtres
$donations = $searchService->searchDonations(
    query: 'chaises',           // Recherche
    categoryId: 3,              // Catégorie
    status: 'available',        // Statut
    sortBy: 'latest',           // Tri
    perPage: 15                 // Pagination
);

foreach ($donations as $donation) {
    echo $donation->title;
}
```

### Exemple 2: Recherche associations
```php
$associations = $searchService->searchAssociations(
    query: 'Croix',
    sortBy: 'popular',  // popular, newest, oldest
    perPage: 10
);
```

### Exemple 3: Recherche globale
```php
$results = $searchService->globalSearch('aide alimentaire', limit: 5);

echo "Donations: " . count($results['donations']);
echo "Associations: " . count($results['associations']);
echo "Catégories: " . count($results['categories']);
```

### Exemple 4: Recommandations personnalisées
```php
$recommendations = $searchService->getRecommendedDonations(
    $user->id,
    limit: 6
);

// Affiche 6 donations pertinentes pour l'utilisateur
```

### Exemple 5: Filtrage par distance
```php
$nearby = $searchService->filterByDistance(
    latitude: 48.8566,
    longitude: 2.3522,
    radiusKm: 50,
    perPage: 15
);
```

## LocationService

### Exemple 1: Calculer distance
```php
use App\Services\LocationService;

$locationService = app(LocationService::class);

// Distance entre Paris et Marseille
$distance = $locationService->calculateDistance(
    lat1: 48.8566,   // Paris latitude
    lon1: 2.3522,    // Paris longitude
    lat2: 43.2965,   // Marseille latitude
    lon2: 5.3698,    // Marseille longitude
    unit: 'km'
);

echo "Distance: " . $locationService->formatDistance($distance);
// Distance: 661.4 km
```

### Exemple 2: Géocodage (Adresse → Coordonnées)
```php
// Convertir une adresse en coordonnées
$coords = $locationService->geocodeAddress('Paris, France');

if ($coords) {
    echo "Lat: " . $coords['latitude'];
    echo "Lon: " . $coords['longitude'];
    echo "Nom: " . $coords['display_name'];
}
```

### Exemple 3: Géocodage inverse (Coordonnées → Adresse)
```php
// Obtenir l'adresse à partir de coordonnées
$country = $locationService->reverseGeocode(48.8566, 2.3522);
echo "Pays: " . $country;
```

### Exemple 4: Valider coordonnées
```php
if ($locationService->isValidCoordinate(48.8566, 2.3522)) {
    echo "Coordonnées valides";
}
```

### Exemple 5: Point central entre deux points
```php
$center = $locationService->getCenterPoint(
    48.8566, 2.3522,  // Paris
    43.2965, 5.3698   // Marseille
);

echo "Centre: " . $center['latitude'] . ", " . $center['longitude'];
```

## FileUploadService

### Exemple 1: Uploader une image
```php
use App\Services\FileUploadService;

$fileService = app(FileUploadService::class);

// Depuis une requête HTTP
$path = $fileService->uploadImage(
    $request->file('image'),
    path: 'donations'
);

echo "Image stockée à: " . $path;
```

### Exemple 2: Uploader plusieurs images
```php
$paths = $fileService->uploadImages(
    $request->file('images'),  // Array de fichiers
    path: 'donations'
);

foreach ($paths as $path) {
    echo "Image: " . $path;
}
```

### Exemple 3: Obtenir l'URL d'une image
```php
$url = $fileService->getUrl($path);
// Exemple: /storage/images/donations/uuid.jpg
```

### Exemple 4: Obtenir une miniature
```php
$thumbUrl = $fileService->getThumbnailUrl($path, '200x200');
// Exemple: /storage/images/donations/thumbnails/200x200/uuid.jpg
```

### Exemple 5: Supprimer une image
```php
if ($fileService->deleteImage($path)) {
    echo "Image supprimée";
}
```

### Exemple 6: Valider et uploader
```php
try {
    $fileService->uploadImage($request->file('image'));
} catch (\InvalidArgumentException $e) {
    echo "Erreur: " . $e->getMessage();
    // "Image size must be less than 5MB"
}
```

## Cas d'usage réels

### Création d'une donation avec notification
```php
use App\Services\NotificationService;
use App\Models\Donation;

$donation = Donation::create([
    'title' => 'Chaises',
    'donator_id' => auth()->id(),
    ...
]);

$notificationService->notify(
    $user,
    'donation_published',
    "Votre donation '{$donation->title}' est maintenant visible!",
    ['donation_id' => $donation->id]
);
```

### Signaler un utilisateur malveillant
```php
use App\Services\ReportService;

$reportService = app(ReportService::class);

$report = $reportService->create(
    auth()->user(),
    'App\Models\User',
    $suspiciousUser->id,
    'comportement_offensant',
    'Cet utilisateur utilise un langage offensant'
);

// Plus tard, l'admin résout
$reportService->resolve(
    $report,
    $admin,
    'avertissement',
    'Utilisateur averti'
);
```

### Recherche intelligente de donations
```php
use App\Services\SearchService;
use App\Services\LocationService;

$searchService = app(SearchService::class);
$locationService = app(LocationService::class);

// Rechercher à proximité
$myCoords = $locationService->geocodeAddress('15 Rue de la Paix, Paris');

$donations = $searchService->filterByDistance(
    $myCoords['latitude'],
    $myCoords['longitude'],
    radiusKm: 25
);
```

### Upload d'image de donation
```php
use App\Services\FileUploadService;
use App\Models\Donation;
use App\Models\DonationImage;

$fileService = app(FileUploadService::class);

$path = $fileService->uploadImage($request->file('image'));

DonationImage::create([
    'donation_id' => $donation->id,
    'path' => $path,
    'is_primary' => true,
]);
```

## Injection de dépendances

### Dans un contrôleur
```php
namespace App\Http\Controllers;

use App\Services\SearchService;

class DonationController extends Controller
{
    public function __construct(
        private SearchService $searchService
    ) {}

    public function index()
    {
        $donations = $this->searchService->searchDonations();
        return view('donations.index', compact('donations'));
    }
}
```

### Dans un service/classe
```php
class DonationManager
{
    public function __construct(
        private NotificationService $notificationService,
        private FileUploadService $fileService,
        private SearchService $searchService,
    ) {}
}
```

## Configuration et personnalisation

### Limites de fichiers
```php
// Dans FileUploadService
protected int $maxImageSize = 5;      // MB
protected int $maxDocumentSize = 10;  // MB
```

### Notifications par défaut
```php
// Dans NotificationService
$defaultSettings = [
    'donation_published' => true,
    'new_message' => true,
    'review_received' => true,
    ...
];
```

### Raisons de rapport
```php
// Options personnalisables selon besoins
'contenu_offensant'
'arnaque'
'faux_compte'
'spam'
'harcelement'
```

---

**Notes**: 
- Tous les exemples supposent l'injection de dépendances ou `app()` helper
- Adapter les IDs/valeurs selon vos données
- Consulter PHPDoc pour toutes les méthodes disponibles
