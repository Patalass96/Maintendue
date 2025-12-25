<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Donation;
use App\Models\Association;
use App\Models\User;
use App\Models\CollectionPoint;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->orderBy('order_index')->get();
        $recentDonations = Donation::with(['category', 'primaryImage'])
            ->available()
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        
        $stats = [
            'total_users' => User::where('is_active', true)->count(),
            'total_donations' => Donation::count(),
            'total_associations' => Association::where('verification_status', 'verified')->count(),
            'total_collection_points' => CollectionPoint::where('is_active', true)->count(),
        ];
        
        return view('home', compact('categories', 'recentDonations', 'stats'));
    }
    
    // Autres méthodes...
}