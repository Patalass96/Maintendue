<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

// Modèles spécifiques de MainTendue (les classes référencées dans les relations)
use App\Models\Association;
use App\Models\Donation; // Pour les dons émis
use App\Models\SocialAccount;
use App\Models\Review; // Pour les avis donnés et reçus
use App\Models\Notification;
use App\Models\UserNotificationSetting; // Pour les préférences de notification
use App\Models\Report; // Pour les signalements émis et reçus
use App\Models\AdminAction; // Pour les actions effectuées par l'administrateur

class User extends Authenticatable 
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    // --- CONSTANTES DE RÔLES ---
    const ROLE_ADMIN = 'admin';
    const ROLE_ASSOCIATION = 'association';
    const ROLE_DONATOR = 'donateur';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'is_active', 
        'is_verified',
        'avatar', 
        'phone', 
        'address', 
        'latitude', 
        'longitude', 
        'settings',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean', 
            'is_verified' => 'boolean',
            'settings' => 'array', 
            'latitude' => 'float',
            'longitude' => 'float',
        ];

    }

    /**
     * Vérifie si l'association est validée par l'admin.
     */
    public function isVerifiedAssociation(): bool
    {
        return $this->isAssociation() && $this->is_verified === true;
    }
    
    // --- RELATIONS ELOQUENT ---

    /**
     * L'utilisateur peut être le manager d'une seule association.
     * Relation HasOne (1:1).
     */
    public function association(): HasOne
    {
        return $this->hasOne(Association::class);
    }

    /**
     * L'utilisateur peut avoir plusieurs dons actifs ou passés.
     * Relation HasMany (1:N).
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class, 'donor_id');
    }

    /**
     * L'utilisateur a plusieurs comptes sociaux liés.
     * Relation HasMany (1:N).
     */
    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }
    
    /**
     * L'utilisateur a émis plusieurs avis (Reviewer).
     * Relation HasMany (1:N).
     */
    public function reviewsGiven(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    /**
     * L'utilisateur a reçu plusieurs avis (Reviewed).
     * Relation HasMany (1:N).
     */
    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewed_id');
    }
    /**
     * L'utilisateur peut avoir plusieurs notifications.
     * Relation HasMany (1:N).
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * L'utilisateur a un jeu de préférences de notification.
     */
    public function notificationSettings(): HasOne
    {
        return $this->hasOne(UserNotificationSetting::class);
    }

    /**
     * L'utilisateur a émis plusieurs signalements (Reports).
     * Relation HasMany (1:N).
     */
    public function reportsMade(): HasMany
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    /**
     * L'utilisateur a reçu plusieurs signalements (Polymorphique).
     * Relation MorphMany.
     */
    public function reportsReceived(): MorphMany
    {
        return $this->morphMany(Report::class, 'reported');
    }

//     public function reports(): MorphMany
// {
//     return $this->morphMany(Report::class, 'reported');
// }

public function adminActions(): MorphMany
{
    return $this->morphMany(AdminAction::class, 'target');
}

    // --- LOGIQUE MÉTIER DES RÔLES ---

    /**
     * Vérifie si l'utilisateur est un administrateur.
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Vérifie si l'utilisateur est un donateur.
     */
    public function isDonator(): bool
    {
        return $this->role === self::ROLE_DONATOR;
    }

    /**
     * Vérifie si l'utilisateur est un manager d'association.
     */
    public function isAssociation(): bool
    {
        return $this->role === self::ROLE_ASSOCIATION;
    }

    public function getAvatarUrlAttribute(): string
{
    // Si c'est une URL externe (pravatar des tests)
    if (str_starts_with($this->avatar, 'http')) {
        return $this->avatar;
    }

    // Si c'est ton logo ou un fichier uploadé
    return $this->avatar 
        ? asset($this->avatar) 
        : asset('assets/images/default-avatar.png');
}

}

    

