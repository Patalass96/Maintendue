<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'question',
        'answer',
        'category',
        'order_index',
        'is_active',
       
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];

    // --- LOGIQUE UTILE (Scopes) ---

    /**
     * Scope pour récupérer uniquement les FAQs actives.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope pour trier par ordre d'affichage.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }

    /**
     * Scope pour filtrer par catégorie spécifique.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $category
     */
    public function scopeForCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
