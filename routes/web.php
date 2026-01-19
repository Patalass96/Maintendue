<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DonatorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Shared\ReviewController;
use App\Http\Controllers\Admin\CollectionPointController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\AssociationNeedsController;
use App\Http\Controllers\SocialAccountController;

// --- PAGES PUBLIQUES ---
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/mentions-legales', [PageController::class, 'mentions'])->name('mentions');

// Route publique pour afficher la liste des associations
Route::get('/associations', [AssociationController::class, 'indexPublic'])->name('associations.index');
// Route publique pour afficher le profil d'une association
Route::get('/associations/{association}', [AssociationController::class, 'show'])->name('associations.show');

// Remplace ton bloc notifications par celui-ci, tout seul :
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

// --- AUTHENTIFICATION ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// --- RÉINITIALISATION MOT DE PASSE ---
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


// --- AUTH SOCIALE ---
Route::get('auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.login');
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);

// --- 2FA ---
Route::middleware(['auth'])->group(function () {
    Route::get('2fa/verify', [TwoFactorController::class, 'index'])->name('2fa.index');
    Route::post('2fa/verify', [TwoFactorController::class, 'store'])->name('2fa.store');
    Route::post('2fa/resend', [TwoFactorController::class, 'resend'])->name('2fa.resend');
});

Route::middleware(['auth'])->group(function () {
    // Assurez-vous que le ->name() correspond exactement à ce que vous mettez dans le href
    Route::get('/mes-dons', [DonationController::class, 'my-donations'])->name('my-donations');


});

// --- PROFIL UTILISATEUR UNIFIÉ ---
Route::middleware(['auth', '2fa'])->group(function () {
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
});

// --- ROUTES ADMIN ---
// J'ai corrigé le name('admin.') qui créait des noms comme admin.admin.users
Route::middleware(['auth', '2fa', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/associations', [AdminController::class, 'associations'])->name('associations');
    Route::get('/moderation', [AdminController::class, 'moderation'])->name('moderation');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/statistique', [AdminController::class, 'statistique'])->name('statistique');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');

    // Validation
    Route::get('/validate-associations', [AdminController::class, 'validateAssociations'])->name('validateAssociations');
    Route::post('/validate-association/{id}', [AdminController::class, 'validateAssociation'])->name('validateAssociation');
    Route::post('/reject-association/{id}', [AdminController::class, 'rejectUser'])->name('reject');

    // Gestion des utilisateurs (Nettoyé)
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{user}/suspend', [AdminController::class, 'suspend'])->name('users.suspend');
    Route::put('/users/{user}/activate', [AdminController::class, 'activate'])->name('users.activate');
    Route::put('/users/{user}/promote', [AdminController::class, 'promote'])->name('users.promote');

    // Catégories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Collection Points
    Route::get('/collection-points', [CollectionPointController::class, 'index'])->name('collection-points.index');
    Route::get('/collection-points/create', [CollectionPointController::class, 'create'])->name('collection-points.create');
    Route::post('/collection-points', [CollectionPointController::class, 'store'])->name('collection-points.store');
    Route::get('/collection-points/{collectionPoint}', [CollectionPointController::class, 'show'])->name('collection-points.show');
    Route::get('/collection-points/{collectionPoint}/edit', [CollectionPointController::class, 'edit'])->name('collection-points.edit');
    Route::put('/collection-points/{collectionPoint}', [CollectionPointController::class, 'update'])->name('collection-points.update');
    Route::delete('/collection-points/{collectionPoint}', [CollectionPointController::class, 'destroy'])->name('collection-points.destroy');
    Route::put('/collection-points/{collectionPoint}/toggle', [CollectionPointController::class, 'toggle'])->name('collection-points.toggle');

    // FAQs
    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
    Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
    Route::get('/faqs/{faq}', [FaqController::class, 'show'])->name('faqs.show');
    Route::get('/faqs/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
    Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');
    Route::put('/faqs/{faq}/toggle', [FaqController::class, 'toggle'])->name('faqs.toggle');
    Route::post('/faqs/reorder', [FaqController::class, 'reorder'])->name('faqs.reorder');
    Route::get('/faqs/filter/category', [FaqController::class, 'filterByCategory'])->name('faqs.filter-category');

    // Modération - Signalements
    Route::prefix('moderation')->name('moderation.')->group(function () {
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/{report}', [ReportController::class, 'show'])->name('show');
            Route::put('/{report}/mark-reviewed', [ReportController::class, 'markAsReviewed'])->name('mark-reviewed');
            Route::post('/{report}/resolve', [ReportController::class, 'resolve'])->name('resolve');
            Route::post('/{report}/dismiss', [ReportController::class, 'dismiss'])->name('dismiss');
            Route::delete('/{report}', [ReportController::class, 'destroy'])->name('destroy');
            Route::get('/filter', [ReportController::class, 'filter'])->name('filter');
        });
    });
});

// --- ROUTES ASSOCIATION ---
Route::middleware(['auth', 'role:association'])->prefix('associations')->name('associations.')->group(function () {
    Route::get('/complete-profile', [AssociationController::class, 'showCompleteProfile'])->name('complete-profile');
    Route::post('/complete-profile', [AssociationController::class, 'completeProfile'])->name('complete-profile.submit');
    Route::get('/pending', [AssociationController::class, 'pending'])->name('pending');
});

Route::middleware(['auth', '2fa', 'verify.association'])->prefix('association')->name('associations.')->group(function () {
    Route::get('/dashboard', [AssociationController::class, 'index'])->name('dashboard');
    Route::get('associations/profile.show', [AssociationController::class, 'profile'])->name('profile');
    Route::get('associations/profile.edit', [AssociationController::class, 'editProfile'])->name('profile.edit');
    Route::put('associations/profile.update', [AssociationController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [AssociationController::class, 'settings'])->name('settings');
    Route::get('/donation/available', [AssociationController::class, 'availableDonations'])->name('donation.available');
    Route::get('/donation/received', [AssociationController::class, 'receivedDonations'])->name('donation.received');
    Route::get('/messages', [AssociationController::class, 'messages'])->name('messages');
    Route::get('/requests', [AssociationController::class, 'myRequests'])->name('requests');
    Route::get('/requests/create', [AssociationController::class, 'createRequestForm'])->name('requests.create');
    Route::post('/requests', [AssociationController::class, 'createDonationRequest'])->name('requests.store');

    // Gestion des dons
    Route::post('/donations/{donation}/accept', [AssociationController::class, 'acceptDonation'])->name('donations.accept');
    Route::post('/donations/{donation}/deliver', [AssociationController::class, 'markAsDelivered'])->name('donations.deliver');
    Route::put('/donations/{donation}/status', [AssociationController::class, 'updateStatus'])->name('donations.update-status');

    // Gestion des besoins spécifiques
    Route::get('/needs', [AssociationNeedsController::class, 'index'])->name('needs.index');
    Route::get('/needs/create', [AssociationNeedsController::class, 'create'])->name('needs.create');
    Route::post('/needs', [AssociationNeedsController::class, 'store'])->name('needs.store');
    Route::get('/needs/{need}', [AssociationNeedsController::class, 'show'])->name('needs.show');
    Route::get('/needs/{need}/edit', [AssociationNeedsController::class, 'edit'])->name('needs.edit');
    Route::put('/needs/{need}', [AssociationNeedsController::class, 'update'])->name('needs.update');
    Route::delete('/needs/{need}', [AssociationNeedsController::class, 'destroy'])->name('needs.destroy');
    Route::post('/needs/{need}/toggle', [AssociationNeedsController::class, 'toggle'])->name('needs.toggle');
});

// --- ROUTES DONATEUR ---
Route::middleware(['auth', '2fa', 'role:donateur'])->prefix('donator')->name('donator.')->group(function () {
    Route::get('/dashboard', [DonatorController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DonatorController::class, 'profile'])->name('profile');
});

// --- GESTION DES CONVERSATIONS ---
Route::middleware(['auth', '2fa'])->prefix('conversations')->name('conversations.')->group(function () {
    Route::get('/', [ConversationController::class, 'index'])->name('index');
    Route::get('/{conversation}', [ConversationController::class, 'show'])->name('show');
    Route::post('/{conversation}/messages', [ConversationController::class, 'store'])->name('messages.store');
    Route::post('/start/{donation}', [ConversationController::class, 'start'])->name('start');
});

// --- GESTION DES AVIS (REVIEWS) ---
Route::middleware(['auth', '2fa'])->prefix('reviews')->name('reviews.')->group(function () {
    Route::get('/user/{user}', [ReviewController::class, 'index'])->name('index');
    Route::get('/{review}', [ReviewController::class, 'show'])->name('show');
    Route::get('/donation/{donation}/create', [ReviewController::class, 'create'])->name('create');
    Route::post('/donation/{donation}', [ReviewController::class, 'store'])->name('store');
    Route::post('/{review}/reply', [ReviewController::class, 'reply'])->name('reply');
    Route::post('/{review}/report', [ReviewController::class, 'report'])->name('report');
});

// --- GESTION DES DONS ---
Route::prefix('donations')->name('donations.')->group(function () {
    Route::get('/', [DonationController::class, 'index'])->name('index');
    Route::middleware(['auth', '2fa'])->group(function () {
        Route::get('/create', [DonationController::class, 'create'])->name('create');
        Route::post('/', [DonationController::class, 'store'])->name('store');
        Route::get('/{donation}/edit', [DonationController::class, 'edit'])->name('edit');
        Route::put('/{donation}', [DonationController::class, 'update'])->name('update');
        Route::delete('/{donation}', [DonationController::class, 'destroy'])->name('destroy');
        Route::post('/{donation}/reserve', [DonationController::class, 'reserve'])->name('reserve');
        Route::post('/{donation}/mark-delivered', [DonationController::class, 'markAsDelivered'])->name('mark-delivered');
    });
    Route::get('/{donation}', [DonationController::class, 'show'])->name('show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

    // Gestion des comptes sociaux
    Route::prefix('social-accounts')->name('social-accounts.')->group(function () {
        Route::get('/', [SocialAccountController::class, 'index'])->name('index');
        Route::get('/connect/{provider}', [SocialAccountController::class, 'connect'])->name('connect');
        Route::get('/callback/{provider}', [SocialAccountController::class, 'callback'])->name('callback');
        Route::delete('/{socialAccount}', [SocialAccountController::class, 'disconnect'])->name('disconnect');
    });
});
