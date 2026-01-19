<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Afficher le formulaire d'édition du profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Mettre à jour le profil utilisateur
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 
                       Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        // Mettre à jour les informations de base
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $user->phone,
            'address' => $validated['address'] ?? $user->address,
            'city' => $validated['city'] ?? $user->city,
            'postal_code' => $validated['postal_code'] ?? $user->postal_code,
            'description' => $validated['description'] ?? $user->description,
        ]);

        // Mettre à jour le mot de passe si fourni
        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        // Gérer l'avatar
        if ($request->hasFile('avatar')) {
            $this->updateAvatar($user, $request->file('avatar'));
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Profil mis à jour avec succès!');
    }

    /**
     * Afficher le tableau de bord utilisateur
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_donations' => $user->donations()->count(),
            'active_donations' => $user->donations()->where('status', 'available')->count(),
            'reserved_donations' => $user->donations()->where('status', 'reserved')->count(),
            'delivered_donations' => $user->donations()->where('status', 'delivered')->count(),
            'requests_made' => $user->requests()->count(),
            'requests_accepted' => $user->requests()->where('status', 'accepted')->count(),
        ];

        $recentDonations = $user->donations()
            ->with('category')
            ->latest()
            ->limit(5)
            ->get();

        $recentRequests = $user->requests()
            ->with('donation')
            ->latest()
            ->limit(5)
            ->get();

        return view('profile.dashboard', compact('user', 'stats', 'recentDonations', 'recentRequests'));
    }

    /**
     * Mettre à jour l'avatar
     */
    private function updateAvatar(User $user, $file)
    {
        // Supprimer l'ancien avatar s'il existe
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Sauvegarder le nouvel avatar
        $path = $file->store('avatars/' . date('Y/m'), 'public');
        $user->update(['avatar' => $path]);
    }

    /**
     * Supprimer le compte utilisateur
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Votre compte a été supprimé avec succès.');
    }
}