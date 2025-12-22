<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;


class Notification extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
        'action_url',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'data' => 'array', // Crucial pour stocker/lire les données JSON
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // --- RELATIONS ELOQUENT ---

    /**
     * Récupère l'utilisateur qui doit recevoir cette notification.
     * Relation BelongsTo (N:1).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // --- PORTÉE UTILE (Scopes) ---

    /**
     * Scope pour récupérer uniquement les notifications non lues.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
