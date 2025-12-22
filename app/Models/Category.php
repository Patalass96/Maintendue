<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Donation;

class Category extends Model
{
    use HasFactory;
    
    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'is_active',
        'order_index',
    ];
    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];
    /**
     * Une catégorie peut avoir plusieurs dons.
     * Relation HasMany (1:N).
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
}

/**
     * SCOPES (C'est ici que tu ajoutes le code !)
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->orderBy('order_index', 'asc')
                     ->orderBy('name', 'asc');
    }

}