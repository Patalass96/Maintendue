<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Affiche le formulaire d'édition
     */
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * 1. Informations personnelles (Inclut Avatar et Intérêts)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone'      => ['nullable', 'string', 'max:20'],
            'city'       => ['nullable', 'string', 'max:100'],
            'address'    => ['nullable', 'string', 'max:255'],
            'bio'        => ['nullable', 'string', 'max:500'],
            'interests'  => ['nullable', 'array'],
            'avatar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Gestion de l'avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Encodage des intérêts en JSON
        $validated['interests'] = json_encode($request->interests ?? []);

        $user->update($validated);

        return back()->with('success', 'Informations personnelles mises à jour.');
    }

    /**
     * 2. Sécurité (Mot de passe)
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password'     => ['required', 'confirmed', 'min:8'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }

    /**
     * 3. Préférences (Notifications & Confidentialité)
     */
    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        // On stocke les tableaux directement en JSON dans la base
        $user->update([
            'notifications' => json_encode($request->notifications ?? []),
            'privacy'       => json_encode($request->privacy ?? []),
            'language'      => $request->language,
            'timezone'      => $request->timezone,
        ]);

        return back()->with('success', 'Préférences enregistrées.');
    }

    /**
     * 4. Informations Association (Documents & Catégories)
     */
    public function updateAssociation(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'association') {
            abort(403);
        }

        $validated = $request->validate([
            'association_name'        => ['required', 'string', 'max:255'],
            'association_acronym'     => ['nullable', 'string', 'max:50'],
            'association_description' => ['required', 'string'],
            'association_categories'  => ['nullable', 'array'],
            'recepisse'               => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:4096'],
        ]);

        // Gestion du document (Récépissé)
        if ($request->hasFile('recepisse')) {
            // Logique pour stocker le chemin du document
            $path = $request->file('recepisse')->store('documents', 'public');

            // On suppose ici une colonne JSON ou une relation pour les docs
            $documents = json_decode($user->association_documents ?? '{}', true);
            $documents['recepisse'] = $path;
            $user->association_documents = json_encode($documents);
        }

        $user->association_name = $validated['association_name'];
        $user->association_acronym = $validated['association_acronym'];
        $user->association_description = $validated['association_description'];
        $user->association_categories = json_encode($request->association_categories ?? []);

        $user->save();

        return back()->with('success', 'Informations de l\'association mises à jour.');
    }
}
