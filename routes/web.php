<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DonatorController;
use App\Http\Controllers\UserController; 



// --- PAGES PUBLIQUES ---
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/mentions-legales', [PageController::class, 'mentions'])->name('mentions');

// --- AUTHENTIFICATION CLASSIQUE ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// --- RÉINITIALISATION DE MOT DE PASSE ---
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');


// --- AUTHENTIFICATION SOCIALE (Google/Facebook) ---
Route::get('auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.login');
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);

// --- ROUTES ADMIN ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/associations', [AdminController::class, 'associations'])->name('admin.associations');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/moderation', [AdminController::class, 'moderation'])->name('admin.moderation');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/statistique', [AdminController::class, 'statistique'])->name('admin.statistique');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::match(['get', 'post'], '/validateAssociation/{id}', [AdminController::class, 'validateAssociation'])
    ->name('admin.validateAssociation');    Route::post('/reject-user/{id}', [AdminController::class, 'rejectUser'])->name('admin.reject');
    
    // Gestion des catégories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// --- ROUTES ASSOCIATION ---
// Utilisez 'verify.association' qui est l'alias que vous avez défini

    Route::middleware(['auth', 'role:association'])->prefix('associations')->group(function () {
    Route::get('/complete-profile', [AssociationController::class, 'showCompleteProfile'])
        ->name('associations.complete-profile');
    Route::post('/complete-profile', [AssociationController::class, 'completeProfile'])
        ->name('associations.complete-profile.submit');
});

// 2. Routes protégées (uniquement pour associations vérifiées)
Route::middleware(['auth', 'verify.association'])->prefix('association')->group(function () {
    Route::get('/dashboard', [AssociationController::class, 'index'])->name('associations.dashboard');


    Route::get('/profile', [AssociationController::class, 'profile'])->name('associations.profile');
    Route::get('/settings', [AssociationController::class, 'settings'])->name('associations.settings');
    Route::get('/donation/available', [AssociationController::class, 'availableDonations'])->name('associations.donation.available');
    Route::get('/donation/received', [AssociationController::class, 'receivedDonations'])->name('associations.donation.received');
    Route::get('/messages', [AssociationController::class, 'messages'])->name('associations.messages');

   Route::get('/requests', [AssociationController::class, 'myRequests'])->name('associations.requests');
    Route::get('/requests/create', [AssociationController::class, 'createRequestForm'])->name('associations.requests.create');
    Route::post('/requests', [AssociationController::class, 'createDonationRequest'])->name('associations.requests.store');
    Route::get('/requests/{request}', [AssociationController::class, 'showRequest'])->name('associations.requests.show');
    
    // Gestion des dons
    Route::post('/donations/{donation}/accept', [AssociationController::class, 'acceptDonation'])->name('associations.donations.accept');
    Route::post('/donations/{donation}/deliver', [AssociationController::class, 'markAsDelivered'])->name('associations.donations.deliver');
    
    // Gestion du profil
    Route::delete('/logo', [AssociationController::class, 'deleteLogo'])->name('associations.logo.delete');
    Route::get('/document/download', [AssociationController::class, 'downloadVerificationDocument'])->name('associations.document.download');

    // Route::get('/complete-profile', function () {
    //     return view('associations.complete-profile');
    // })->name('associations.complete-profile');
});

// --- ROUTES DONATEUR/UTILISATEUR STANDARD ---
// Route::middleware(['auth'])->prefix(donator)->group(function () {
    // Routes accessibles à tous les utilisateurs connectés
//     Route::get('/dashboard',[donatorController::class, 'dashboard'])->name('user.dashboard'); 
// //         
// });


// // Dashboard Donateur
// Route::middleware(['auth', 'role:donator'])->prefix('donator')->group(function () {
//     Route::get('/dashboard', [DonatorController::class, 'index'])->name('user.dashboard');
// });


// --- GESTION DES DONS (MVC) ---
// Route::group(['prefix' => 'donations', 'as' => 'donations.'], function() {
//     Route::get('/', [DonationController::class, 'index'])->name('index');
//     Route::get('/create', [DonationController::class, 'create'])->name('create')->middleware('auth');
//     Route::get('/{id}', [DonationController::class, 'show'])->name('show');
// });

// --- GESTION DES ASSOCIATIONS ---

// Dashboard Association (Double vérification : Rôle + Validation)
// Route::middleware(['auth', 'isAssociation'])->prefix('association')->group(function () {
//     Route::get('/dashboard', [AssociationController::class, 'index'])->name('association.dashboard');
//    Route::group(['prefix' => 'associations', 'as' => 'associations.'], function() {
//     Route::get('/', [AssociationController::class, 'index'])->name('index');
//      Route::get('/register', [AssociationController::class, 'create'])->name('register');
//  });

// --- ROUTES DE TEST ---
Route::get('/test-db', function() {
    return [
        'donations' => \App\Models\Donation::count(),
        'users' => \App\Models\User::count(),
        'status' => 'Connexion DB OK'
    ];
});

// use Illuminate\Support\Facades\Route;
// use App\Models\Donation;
// use App\Models\Category;
// use App\Models\Association;
// use App\Models\CollectionPoint;
// App\Http\Controllers\Auth\LoginController
// use App\Http\Controllers\Auth\SocialAuthController;
// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\DonationController;
// use App\Http\Controllers\AssociationController;
// use App\Http\Controllers\CollectionPointController;


// // Page d'accueil
// Route::get('/', function () {
//     return view('home');
// })->name('home');

// // Dons
// Route::get('/donations', function () {
//     $donations = Donation::with(['category', 'primaryImage'])
//         ->orderBy('created_at', 'desc')
//         ->paginate(12);
//     $categories = Category::all();
    
//     return view('donations.index', compact('donations', 'categories'));
// })->name('donations.index');

// Route::get('/donations/{id}', function ($id) {
//     $donation = Donation::with(['category', 'images', 'donor'])->findOrFail($id);
//     return view('donations.show', compact('donation'));
// })->name('donations.show');

// Route::get('/donations/create', function () {
//     $categories = Category::all();
//     return view('donations.create', compact('categories'));
// })->name('donations.create');

// // Associations
// Route::get('/associations', function () {
//     $associations = Association::with('manager')->paginate(12);
//     return view('associations.index', compact('associations'));
// })->name('associations.index');

// Route::get('/associations/register', function () {
//     return view('associations.register');
// })->name('associations.register');

// // Pages statiques
// Route::get('/about', function () {
//     return view('pages.about');
// })->name('about');

// Route::get('/faq', function () {
//     $faqs = \App\Models\Faq::all();
//     return view('pages.faq', compact('faqs'));
// })->name('faq');

// // Authentification avec contrôleur dédié

// // Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// // Route::post('/login', [LoginController::class, 'login']);
// // Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// // Authentification (temporaire)
// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');

// // Test route
//  Route::get('/test', function() {
//     return response()->json([
//        'donations' => Donation::count(),
//         'categories' => Category::count(),
//        'associations' => Association::count(),
//         'status' => 'OK'
//    ]);
// });
