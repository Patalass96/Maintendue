<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

 use App\Models\User;
 use App\Models\Donation;

class Review extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'reviewer_id',
        'reviewed_id',
        'donation_id',
        'rating',
        'comment',
        'response',
        'is_visible',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'is_visible' => 'boolean',
        'rating' => 'integer',
    ];

    // --- RELATIONS ELOQUENT ---

    /**
     * Récupère l'utilisateur qui a écrit cet avis.
     * Relation BelongsTo (N:1).
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Récupère l'utilisateur qui est l'objet de cet avis.
     * Relation BelongsTo (N:1).
     */
    public function reviewed(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_id');
    }

    /**
     * Récupère le don spécifique associé à cet avis.
     * Relation BelongsTo (N:1).
     */
    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }
}


