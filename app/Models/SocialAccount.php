<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Modèles spécifiques de MainTendue
use App\Models\User; // Le modèle auquel ce compte est lié

class SocialAccount extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'access_token',
        'refresh_token',
    ];

    /**
     * Un compte social appartient à un seul utilisateur.
     * Relation BelongsTo (N:1).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

