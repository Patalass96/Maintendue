<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Donation;
use App\Models\User;
use App\Models\Message;

class Conversation extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'donation_id',
        'initiator_id',
        'recipient_id',
        'status',
        'last_message_at',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    // --- RELATIONS ELOQUENT ---

    /**
     * La conversation concerne un seul don.
     * Relation BelongsTo (N:1).
     */
    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }

    /**
     * La conversation a été initiée par cet utilisateur.
     * Relation BelongsTo (N:1).
     */
    public function initiator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    /**
     * La conversation est échangée avec ce destinataire.
     * Relation BelongsTo (N:1).
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * La conversation contient plusieurs messages.
     * Relation HasMany (1:N).
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Récupère tous les participants à la conversation (pour simplification).
     * NOTE: Cette méthode n'est pas une relation standard Eloquent.
     */
    public function participants()
    {
        return collect([$this->initiator, $this->recipient]);
    }
}
