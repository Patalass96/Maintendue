<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Category;
use App\Models\CollectionPoint;
use App\Models\Association;
use App\Models\DonationRequest;
use App\Models\DonationImage;
use App\Events\NewDonationPublished;
use App\Events\DonationReserved;
use App\Events\DonationDelivered;
use App\Events\DonationRequestCreated;
use App\Events\DonationPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DonationReservedNotification;

class DonationController extends Controller
{
    /**
     * Afficher la liste des dons avec filtres
     */
    public function index(Request $request)
    {
        $query = Donation::query()->with(['donor', 'category', 'primaryImage']);

        // Filtres
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->filled('urgency')) {
            $query->where('urgency', $request->urgency);
        }

        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'available');
        }

        $donations = $query->orderBy('created_at', 'desc')->paginate(12);

        $categories = Category::all();
        $cities = Donation::distinct('city')->pluck('city');

        return view('donations.index', compact('donations', 'categories', 'cities'));
    }

    /**
     * Afficher le formulaire de création de don
     */
    public function create()
    {
        $categories = Category::all();
        $collectionPoints = CollectionPoint::all();
        $associations = Association::all();

        return view('donations.create', compact('categories', 'collectionPoints', 'associations'));
    }

    /**
     * Enregistrer un nouveau don
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'association_id' => 'nullable|exists:associations,id',
            'condition' => 'required|in:new,excellent,good,fair',
            'condition_detail' => 'nullable|string',
            'urgency' => 'required|in:low,medium,high',
            'quantity' => 'required|integer|min:1',
            'city' => 'required|string',
            'size' => 'nullable|string',
            'gender' => 'nullable|in:men,women,unisex,kids',
            'school_level' => 'nullable|in:maternelle,primaire,college,lycee,superieur',
            'item_type' => 'nullable|string',
            'delivery_method' => 'required|in:direct,collection_point,both',
            'collection_point_id' => 'nullable|exists:collection_points,id',
            'meeting_date' => 'nullable|date',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'expiration_date' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'image|max:5120',
        ]);

        $validated['donor_id'] = Auth::id();
        $validated['status'] = 'available';

        if ($request->has('expires_at')) {
            $validated['expires_at'] = now()->addDays(30);
        }

        $donation = Donation::create($validated);

        // Gestion des images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $this->storeImage($donation, $image, $index === 0);
            }
        }

        // Déclencher l'événement de nouveau don
        event(new NewDonationPublished($donation));

        return redirect()->route('donations.show', $donation)
            ->with('success', 'Don publié avec succès!');
    }

    /**
     * Afficher un don spécifique
     */
    public function show(Donation $donation)
    {
        $donation->increment('view_count');
        $donation->load(['donor', 'category', 'images', 'collectionPoint', 'targetedAssociation']);

        $similarDonations = Donation::where('category_id', $donation->category_id)
            ->where('id', '!=', $donation->id)
            ->where('status', 'available')
            ->with('primaryImage')
            ->limit(4)
            ->get();

        return view('donations.show', compact('donation', 'similarDonations'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Donation $donation)
    {
        $this->authorize('update', $donation);

        $categories = Category::all();
        $collectionPoints = CollectionPoint::all();
        $associations = Association::all();

        return view('donations.edit', compact('donation', 'categories', 'collectionPoints', 'associations'));
    }

    /**
     * Mettre à jour un don
     */
    public function update(Request $request, Donation $donation)
    {
        $this->authorize('update', $donation);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|in:new,excellent,good,fair',
            'condition_detail' => 'nullable|string',
            'urgency' => 'required|in:low,medium,high',
            'quantity' => 'required|integer|min:1',
            'city' => 'required|string',
            'size' => 'nullable|string',
            'gender' => 'nullable|in:men,women,unisex,kids',
            'school_level' => 'nullable|in:maternelle,primaire,college,lycee,superieur',
            'item_type' => 'nullable|string',
            'delivery_method' => 'required|in:direct,collection_point,both',
            'collection_point_id' => 'nullable|exists:collection_points,id',
            'meeting_date' => 'nullable|date',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'expiration_date' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'image|max:5120',
            'remove_images' => 'nullable|array',
        ]);

        $donation->update($validated);

        // Supprimer les images demandées
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $image = DonationImage::find($imageId);
                if ($image && $image->donation_id === $donation->id) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }

        // Ajouter de nouvelles images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->storeImage($donation, $image);
            }
        }

        return redirect()->route('donations.show', $donation)
            ->with('success', 'Don mis à jour avec succès!');
    }

    /**
     * Supprimer un don
     */
    public function destroy(Donation $donation)
    {
        $this->authorize('delete', $donation);

        // Supprimer les images
        foreach ($donation->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $donation->delete();

        return redirect()->route('donations.index')
            ->with('success', 'Don supprimé avec succès!');
    }

    /**
     * Gérer la réservation d'un don
     */
    public function reserve(Donation $donation)
    {
        // Vérifier que le don est disponible
        if ($donation->status !== 'available') {
            return back()->with('error', 'Ce don n\'est plus disponible.');
        }

        $donation->update([
            'status' => 'reserved',
            'reserved_at' => now(),
            'assigned_association_id' => Auth::id(),
        ]);

        // Déclencher l'événement de diffusion
        event(new DonationReserved($donation));

        return back()->with('success', 'Don réservé avec succès!');
    }

    /**
     * Marquer un don comme livré
     */
    public function markAsDelivered(Donation $donation)
    {
        $this->authorize('update', $donation);

        $donation->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        return back()->with('success', 'Don marqué comme livré!');
    }

    /**
     * Stocker une image
     */
    private function storeImage(Donation $donation, $file, $isPrimary = false)
    {
        $path = $file->store('donations/' . date('Y/m'), 'public');
        $filename = $file->getClientOriginalName();

        $image = new DonationImage([
            'path' => $path,
            'filename' => $filename,
            'is_primary' => $isPrimary,
            'order_index' => $donation->images()->count(),
        ]);

        $donation->images()->save($image);

        return $image;
    }
}
