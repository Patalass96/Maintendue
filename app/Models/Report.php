<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use App\Models\User;

class Report extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'reporter_id',
        'reported_type',
        'reported_id',
        'reason',
        'description',
        'status',
        'admin_notes',
        'resolved_at',
        'resolved_by',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    // --- RELATIONS ELOQUENT ---

    /**
     * Récupère l'utilisateur qui a émis le signalement.
     * Relation BelongsTo (N:1).
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Récupère l'administrateur qui a traité et résolu le signalement.
     * Relation BelongsTo (N:1).
     */
    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Récupère le modèle (Donation, User, Association) qui a été signalé.
     * Relation Polymorphique (MorphTo).
     */
    public function reported(): MorphTo
    {
        return $this->morphTo();
    }
}
