<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

class UserNotificationSetting extends Model
{
    use HasFactory;

    /**
     * Le nom de la table si différent de la convention de nommage Laravel.
     */
    protected $table = 'user_notification_settings';

    /**
     * Les attributs qui peuvent être massivement assignés.
     */

protected $fillable = [
        'user_id',
        'email_new_donations',
        'email_messages',
        'email_requests',
        'push_new_donations',
        'push_messages',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'email_new_donations' => 'boolean',
        'email_messages' => 'boolean',
        'email_requests' => 'boolean',
        'push_new_donations' => 'boolean',
        'push_messages' => 'boolean',
    ];

   // --- RELATIONS ELOQUENT ---

/**
     * Récupère l'utilisateur auquel ces préférences appartiennent.
     * Relation BelongsTo (N:1).
     *
     */ 

      public function user(): BelongsTo
       {
             return $this->belongsTo(User::class);
 } 

}

