<?php

namespace App\Http\Controllers\Admin;

use App\Models\CollectionPoint;
use App\Models\Association;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectionPointController extends Controller
{
    /**
     * Affiche la liste des points de collecte
     */
    public function index()
    {
        $this->authorize('viewAny', CollectionPoint::class);

        $collectionPoints = CollectionPoint::with('association')
            ->latest()
            ->paginate(15);

        // Statistiques
        $stats = [
            'total' => CollectionPoint::count(),
            'active' => CollectionPoint::where('is_active', true)->count(),
            'by_association' => CollectionPoint::groupBy('association_id')
                ->selectRaw('association_id, COUNT(*) as count')
                ->get()
                ->pluck('count', 'association_id'),
        ];

        return view('admin.collection-points.index', compact('collectionPoints', 'stats'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $this->authorize('create', CollectionPoint::class);

        $associations = Association::with('manager')
            ->where('verification_status', 'verified')
            ->orderBy('legal_name')
            ->get();

        return view('admin.collection-points.create', compact('associations'));
    }

    /**
     * Stocke un nouveau point de collecte
     */
    public function store(Request $request)
    {
        $this->authorize('create', CollectionPoint::class);

        $validated = $request->validate([
            'association_id' => 'required|exists:associations,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'opening_hours' => 'required|string|max:500',
            'instructions' => 'nullable|string|max:1000',
            'contact_phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $collectionPoint = CollectionPoint::create($validated);

        return redirect()->route('admin.collection-points.show', $collectionPoint)
            ->with('success', 'Point de collecte créé avec succès.');
    }

    /**
     * Affiche les détails d'un point de collecte
     */
    public function show(CollectionPoint $collectionPoint)
    {
        $this->authorize('view', $collectionPoint);

        $collectionPoint->load('association.manager');

        return view('admin.collection-points.show', compact('collectionPoint'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(CollectionPoint $collectionPoint)
    {
        $this->authorize('update', $collectionPoint);

        $associations = Association::with('manager')
            ->where('verification_status', 'verified')
            ->orderBy('legal_name')
            ->get();

        return view('admin.collection-points.edit', compact('collectionPoint', 'associations'));
    }

    /**
     * Met à jour un point de collecte
     */
    public function update(Request $request, CollectionPoint $collectionPoint)
    {
        $this->authorize('update', $collectionPoint);

        $validated = $request->validate([
            'association_id' => 'required|exists:associations,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'opening_hours' => 'required|string|max:500',
            'instructions' => 'nullable|string|max:1000',
            'contact_phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $collectionPoint->update($validated);

        return redirect()->route('admin.collection-points.show', $collectionPoint)
            ->with('success', 'Point de collecte mis à jour avec succès.');
    }

    /**
     * Supprime un point de collecte
     */
    public function destroy(CollectionPoint $collectionPoint)
    {
        $this->authorize('delete', $collectionPoint);

        $collectionPoint->delete();

        return redirect()->route('admin.collection-points.index')
            ->with('success', 'Point de collecte supprimé.');
    }

    /**
     * Active ou désactive un point de collecte
     */
    public function toggle(CollectionPoint $collectionPoint)
    {
        $this->authorize('update', $collectionPoint);

        $collectionPoint->update([
            'is_active' => !$collectionPoint->is_active,
        ]);

        $message = $collectionPoint->is_active ? 'activé' : 'désactivé';

        return back()->with('success', "Point de collecte $message.");
    }
}
