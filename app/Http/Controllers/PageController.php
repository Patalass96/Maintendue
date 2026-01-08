<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Donation;
use App\Models\Association;
use App\Models\User;
use App\Models\CollectionPoint;
use App\Models\Faq; 
use Illuminate\Http\Request;

class PageController extends Controller
{
    // Ta route : Route::get('/', [PageController::class, 'home'])
    public function home()
    {
        $categories = Category::where('is_active', true)->orderBy('order_index')->get();
        
        $recentDonations = Donation::with(['category'])
            ->where('status', 'available')
            ->latest()
            ->take(8)
            ->get();
        
        $stats = [
            'total_users' => User::count(),
            'total_donations' => Donation::count(),
            'total_associations' => Association::where('verification_status', 'verified')->count(),
            'total_collection_points' => CollectionPoint::where('is_active', true)->count(),
        ];

        return view('pages.home', compact('categories', 'recentDonations', 'stats'));
    }

    // Ta route : Route::get('/faq', [PageController::class, 'faq'])
    public function faq()
    {
        $faqs = Faq::where('is_active', true)
            ->orderBy('order_index')
            ->get()
            ->groupBy('category');

        return view('pages.faq', compact('faqs'));
    }

    // Ta route : Route::get('/about', [PageController::class, 'about'])
    public function about()
    {
        return view('pages.about');
    }

    // Ta route : Route::get('/privacy', [PageController::class, 'privacy'])
    public function privacy()
   {
    return view('pages.privacy');

}

    // Ta route : Route::get('/terms', [PageController::class, 'terms'])
    public function terms()
   {
    return view('pages.terms');
}

public function mentions()
{
    return view('pages.mentions-legales');
}


}