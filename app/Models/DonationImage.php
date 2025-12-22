<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\Donation;

/**
 * @property-read string $url
 */

class DonationImage extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'donation_id',
        'path',
        'filename',
        'is_primary',
        'order_index',
    ];




    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'is_primary' => 'boolean',
        'order_index' => 'integer',
    ];

  /**
     * Génère l'URL complète pour afficher l'image.
     * Utilisation dans Blade : <img src="{{ $image->url }}">
     */
   protected function url(): Attribute
    {
        return Attribute::get(function () {
            if (filter_var($this->path, FILTER_VALIDATE_URL)) {
                return $this->path;
            }
            return Storage::disk('public')->url($this->path);
        });
    }


    // --- RELATIONS ELOQUENT ---

    /**
     * Une image appartient à un seul don.
     * Relation BelongsTo (N:1).
     */
    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }


    
    // --- SCOPES ---

    /**
     * Permet de récupérer uniquement l'image principale.
     * Utilisation : $donation->images()->primary()->first();
     */
    public function scopePrimary($query)
{
        return $query->where('is_primary', true);
    }

    /**
     * Trie les images par leur index d'ordre.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index', 'asc');
    }
}
