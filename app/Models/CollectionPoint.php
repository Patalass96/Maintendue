<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Association;
use App\Models\Donation;

class CollectionPoint extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'association_id',
        'name',
        'address',
        'latitude',
        'longitude',
        'opening_hours',
        'instructions',
        'contact_phone',
        'is_active',
        'max_capacity',
        'current_usage',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
        'max_capacity' => 'integer',
        'current_usage' => 'integer',
    ];

public function getIsFullAttribute(): bool
{
    if (!$this->max_capacity) return false;
    return $this->current_usage >= $this->max_capacity;
}


    // --- RELATIONS ELOQUENT ---

    /**
     * Un point de collecte appartient à une seule association.
     * Relation BelongsTo (N:1).
     */
    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class);
    }

    /**
     * Le point de collecte peut être désigné pour plusieurs dons.
     * Relation HasMany (1:N).
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }
}




