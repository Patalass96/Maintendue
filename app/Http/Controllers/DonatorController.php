<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DonatorController extends Controller
{
    /**
     * Display the donor dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $donations = Donation::where('donor_id', $user->id)
            ->with(['category', 'primaryImage'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total_donations' => Donation::where('donor_id', $user->id)->count(),
            'delivered_donations' => Donation::where('donor_id', $user->id)->where('status', 'delivered')->count(),
            'pending_donations' => Donation::where('donor_id', $user->id)->where('status', 'available')->count(),
        ];

        return view('donator.dashboard', compact('donations', 'stats'));
    }

    /**
     * Show the profile of the donor.
     */
    public function profile()
    {
        return view('donator.profile', ['user' => Auth::user()]);
    }
}
