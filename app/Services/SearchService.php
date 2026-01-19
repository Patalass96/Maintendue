<?php

namespace App\Services;

use App\Models\Donation;
use App\Models\Association;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchService
{
    /**
     * Rechercher les donations
     */
    public function searchDonations(
        ?string $query = null,
        ?int $categoryId = null,
        ?string $status = null,
        ?string $sortBy = 'latest',
        int $perPage = 15
    ): LengthAwarePaginator {
        $donations = Donation::with(['donator', 'category', 'images']);

        if ($query) {
            $donations->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        if ($categoryId) {
            $donations->where('category_id', $categoryId);
        }

        if ($status) {
            $donations->where('status', $status);
        }

        // Filtrer par donations visibles
        $donations->where('status', '!=', 'archived');

        // Tri
        switch ($sortBy) {
            case 'oldest':
                $donations->oldest();
                break;
            case 'popular':
                $donations->withCount('views')->orderByDesc('views_count');
                break;
            case 'nearest':
                // Tri par proximité (à implémenter avec géolocalisation)
                $donations->latest();
                break;
            default: // latest
                $donations->latest();
        }

        return $donations->paginate($perPage);
    }

    /**
     * Rechercher les associations
     */
    public function searchAssociations(
        ?string $query = null,
        ?string $sortBy = 'popular',
        int $perPage = 15
    ): LengthAwarePaginator {
        $associations = Association::where('is_verified', true);

        if ($query) {
            $associations->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        // Tri
        switch ($sortBy) {
            case 'newest':
                $associations->latest();
                break;
            case 'oldest':
                $associations->oldest();
                break;
            default: // popular
                $associations->withCount('donations')->orderByDesc('donations_count');
        }

        return $associations->paginate($perPage);
    }

    /**
     * Rechercher les catégories
     */
    public function searchCategories(
        ?string $query = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        $categories = Category::query();

        if ($query) {
            $categories->where('name', 'like', "%{$query}%");
        }

        return $categories->paginate($perPage);
    }

    /**
     * Recherche globale
     */
    public function globalSearch(string $query, int $limit = 5): array
    {
        return [
            'donations' => Donation::where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })->limit($limit)->get(),

            'associations' => Association::where('is_verified', true)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })->limit($limit)->get(),

            'categories' => Category::where('name', 'like', "%{$query}%")
                ->limit($limit)->get(),
        ];
    }

    /**
     * Obtenir les donations recommandées pour un utilisateur
     */
    public function getRecommendedDonations(int $userId, int $limit = 6): Collection
    {
        // Récupérer les catégories que l'utilisateur a consultées
        $userPreferredCategories = Donation::whereHas('reservedBy', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })->pluck('category_id')->unique();

        $recommendations = Donation::whereIn('category_id', $userPreferredCategories)
            ->where('status', 'available')
            ->where(function ($q) use ($userId) {
                // Exclure les donations de l'utilisateur
                $q->where('donator_id', '!=', $userId);
            })
            ->latest()
            ->limit($limit)
            ->get();

        // Si pas assez de recommandations, ajouter les plus récentes
        if ($recommendations->count() < $limit) {
            $additional = Donation::where('status', 'available')
                ->where('donator_id', '!=', $userId)
                ->whereNotIn('id', $recommendations->pluck('id'))
                ->latest()
                ->limit($limit - $recommendations->count())
                ->get();
            $recommendations = $recommendations->concat($additional);
        }

        return $recommendations;
    }

    /**
     * Filtrer les donations par distance (requiert géolocalisation)
     */
    public function filterByDistance(
        float $latitude,
        float $longitude,
        float $radiusKm = 50,
        int $perPage = 15
    ): LengthAwarePaginator {
        return Donation::where('status', '!=', 'archived')
            ->selectRaw('*,
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) *
                cos(radians(longitude) - radians(?)) +
                sin(radians(?)) * sin(radians(latitude)))) AS distance',
                [$latitude, $longitude, $latitude])
            ->having('distance', '<=', $radiusKm)
            ->orderBy('distance')
            ->paginate($perPage);
    }
}
