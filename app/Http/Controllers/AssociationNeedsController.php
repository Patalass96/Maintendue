<?php

namespace App\Http\Controllers;

use App\Models\AssociationNeed;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssociationNeedsController extends Controller
{
    /**
     * Affiche la liste des besoins de l'association
     */
    public function index()
    {
        $association = Auth::user()->association;

        if (!$association) {
            return redirect()->route('associations.complete-profile');
        }

        $this->authorize('view', $association);

        $needs = $association->associationNeeds()
            ->latest()
            ->paginate(10);

        return view('association-needs.index', compact('needs'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $association = Auth::user()->association;

        if (!$association) {
            return redirect()->route('associations.complete-profile');
        }

        $this->authorize('create', AssociationNeed::class);

        return view('association-needs.create');
    }

    /**
     * Stocke un nouveau besoin
     */
    public function store(Request $request)
    {
        $association = Auth::user()->association;

        if (!$association) {
            return redirect()->route('associations.complete-profile');
        }

        $this->authorize('create', AssociationNeed::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'item_type' => 'required|in:clothing,shoes,food,school,furniture,other',
            'school_level' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'condition' => 'nullable|in:new,very_good,good,used',
            'urgency' => 'required|in:low,medium,high,urgent',
            'is_active' => 'boolean',
        ]);

        $need = $association->associationNeeds()->create($validated);

        return redirect()->route('association-needs.show', $need)
            ->with('success', 'Besoin créé avec succès.');
    }

    /**
     * Affiche les détails d'un besoin
     */
    public function show(AssociationNeed $need)
    {
        $this->authorize('view', $need);

        return view('association-needs.show', compact('need'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(AssociationNeed $need)
    {
        $this->authorize('update', $need);

        return view('association-needs.edit', compact('need'));
    }

    /**
     * Met à jour un besoin
     */
    public function update(Request $request, AssociationNeed $need)
    {
        $this->authorize('update', $need);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'item_type' => 'required|in:clothing,shoes,food,school,furniture,other',
            'school_level' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'condition' => 'nullable|in:new,very_good,good,used',
            'urgency' => 'required|in:low,medium,high,urgent',
            'is_active' => 'boolean',
        ]);

        $need->update($validated);

        return redirect()->route('association-needs.show', $need)
            ->with('success', 'Besoin mis à jour avec succès.');
    }

    /**
     * Supprime un besoin
     */
    public function destroy(AssociationNeed $need)
    {
        $this->authorize('delete', $need);

        $need->delete();

        return redirect()->route('association-needs.index')
            ->with('success', 'Besoin supprimé.');
    }

    /**
     * Active ou désactive un besoin
     */
    public function toggle(AssociationNeed $need)
    {
        $this->authorize('update', $need);

        $need->update([
            'is_active' => !$need->is_active,
        ]);

        $message = $need->is_active ? 'activé' : 'désactivé';

        return back()->with('success', "Besoin $message.");
    }
}
