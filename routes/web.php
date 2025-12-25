 <?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\RegisterController; 
use App\Http\Controllers\PageController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AssociationController;


// --- PAGES PUBLIQUES ---
 Route::get('/', [PageController::class, 'home'])->name('home');
 Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');

// --- AUTHENTIFICATION CLASSIQUE ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

Route::post('/register', [RegisterController::class, 'register']);

// --- AUTHENTIFICATION SOCIALE (Google/Facebook) ---
Route::get('auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.login');
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);


// --- GESTION DES DONS (MVC) ---
// Route::group(['prefix' => 'donations', 'as' => 'donations.'], function() {
//     Route::get('/', [DonationController::class, 'index'])->name('index');
//     Route::get('/create', [DonationController::class, 'create'])->name('create')->middleware('auth');
//     Route::get('/{id}', [DonationController::class, 'show'])->name('show');
// });

// --- GESTION DES ASSOCIATIONS ---
// Route::group(['prefix' => 'associations', 'as' => 'associations.'], function() {
//     Route::get('/', [AssociationController::class, 'index'])->name('index');
//     Route::get('/register', [AssociationController::class, 'create'])->name('register');
// });

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
// Route::get('/test', function() {
//     return response()->json([
//         'donations' => Donation::count(),
//         'categories' => Category::count(),
//         'associations' => Association::count(),
//         'status' => 'OK'
//     ]);
// }); -->