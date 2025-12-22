<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use App\Models\User;

class AdminAction extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'admin_id',
        'action_type',
        'target_type',
        'target_id',
        'description',
        'metadata',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'metadata' => 'array', // Convertit le champ JSON en tableau PHP
    ];

    // --- RELATIONS ELOQUENT ---

    /**
     * Récupère l'administrateur qui a effectué cette action.
     * Relation BelongsTo (N:1).
     */
    public function administrator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Récupère l'entité (User, Donation, Association, etc.) qui a été ciblée par l'action.
     * Relation Polymorphique (MorphTo).
     */
    public function target(): MorphTo
    {
        return $this->morphTo();
    }
}
