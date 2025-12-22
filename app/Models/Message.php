<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Conversation;
use App\Models\User;

class Message extends Model
{
    use HasFactory;
/**
    * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'read_at',
        'is_system_message',
        'metadata',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'read_at' => 'datetime',
        'is_system_message' => 'boolean',
        'metadata' => 'array', // Pour les données structurées des messages système
    ];

    // --- RELATIONS ELOQUENT ---

    /**
     * Le message appartient à une conversation.
     * Relation BelongsTo (N:1).
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Le message a été envoyé par cet utilisateur.
     * Relation BelongsTo (N:1).
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
