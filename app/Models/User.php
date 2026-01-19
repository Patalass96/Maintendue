<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

// Modèles spécifiques de MainTendue (les classes référencées dans les relations)
use App\Models\Association;
use App\Models\AssociationDocument;
use App\Models\Donation; // Pour les dons émis
use App\Models\SocialAccount;
use App\Models\DonationRequest;
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
        'verified_at',
        'avatar',
        'phone',
        'description',
        'address',
        'city',
        'postal_code',
        'latitude',
        'longitude',
        'settings',

 // Nouveaux champs
        'association_name',
        'association_description',
        'association_website',
        'association_logo',
        'association_legal_number',
        'is_suspended',
        'suspended_until',
        'suspension_reason',
        'warning_count',
        'average_rating',
        'total_donations',
        'total_received',
        'successful_transactions',
        'positive_reviews',
        'negative_reviews',
        'push_token',
        'device_type',
        'push_notifications_enabled',
        'email_notifications_enabled',
        'language',
        'timezone',
        'last_login_at',
        'last_login_ip',


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
            'verified_at' => 'datetime',
            'settings' => 'array',
            'latitude' => 'float',
            'longitude' => 'float',
            // Nouveaux casts
            'is_suspended' => 'boolean',
            'suspended_until' => 'datetime',
            'push_notifications_enabled' => 'boolean',
            'email_notifications_enabled' => 'boolean',
            'average_rating' => 'decimal:2',
            'last_login_at' => 'datetime',
        ];

    }

    public function generateOtp()
    {
        $this->otp_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->otp_expires_at = now()->addMinutes(10);
        $this->save();

        return $this->otp_code;
    }

    /**

/**Clear the OTP after successful verification.*/
  public function resetOtp()
  {
    $this->otp_code = null;
    $this->otp_expires_at = null;
    $this->save();
    }

    // --- ACCESSORS ET MUTATORS ---

    /**
     * Get the user's avatar URL.
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->avatar) {
                    // Si c'est une URL externe
                    if (str_starts_with($this->avatar, 'http')) {
                        return $this->avatar;
                    }
                    // Si c'est un fichier stocké
                    return Storage::disk('public')->url($this->avatar);
                }

                // Avatar par défaut selon le rôle
                return match($this->role) {
                    self::ROLE_ADMIN => asset('assets/images/avatars/admin-default.png'),
                    self::ROLE_ASSOCIATION => asset('assets/images/avatars/association-default.png'),
                    default => asset('assets/images/avatars/donor-default.png')
                };
            }
        );
    }

/**
     * Get the association logo URL.
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->association_logo) {
                    if (str_starts_with($this->association_logo, 'http')) {
                        return $this->association_logo;
                    }
                    return Storage::disk('public')->url($this->association_logo);
                }
                return asset('assets/images/avatars/association-default.png');
            }
        );
    }


    /**
     * Check if user is currently suspended.
     */
    protected function isCurrentlySuspended(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->is_suspended) {
                    return false;
                }

                // Vérifier si la suspension a expiré
                if ($this->suspended_until && now()->greaterThan($this->suspended_until)) {
                    $this->update([
                        'is_suspended' => false,
                        'suspended_until' => null
                    ]);
                    return false;
                }

                return true;
            }
        );
    }

    /**
     * Get user's display name (association name or personal name).
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->isAssociation() && $this->association_name) {
                    return $this->association_name;
                }
                return $this->name;
            }
        );
    }

    /**
     * Get the full address.
     */
    protected function fullAddress(): Attribute
    {
        return Attribute::make(
            get: function () {
                $parts = [];
                if ($this->address) $parts[] = $this->address;
                if ($this->postal_code) $parts[] = $this->postal_code;
                if ($this->city) $parts[] = $this->city;

                return implode(', ', $parts);
            }
        );
    }

/**
     * Get user's rating as stars.
     */
    protected function ratingStars(): Attribute
    {
        return Attribute::make(
            get: function () {
                $rating = $this->average_rating ?? 0;
                $fullStars = floor($rating);
                $halfStar = ($rating - $fullStars) >= 0.5;
                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

                $stars = str_repeat('★', $fullStars);
                $stars .= $halfStar ? '½' : '';
                $stars .= str_repeat('☆', $emptyStars);

                return $stars;
            }
        );
    }

/**
     * Get the total review count.
     */
    protected function totalReviews(): Attribute
    {
        return Attribute::make(
            get: function () {
                return ($this->positive_reviews ?? 0) + ($this->negative_reviews ?? 0);
            }
        );
    }

// --- HELPER METHODS ---

    /**
     * Vérifie si l'association est validée par l'admin.
     */
    public function isVerifiedAssociation(): bool
    {
        return $this->isAssociation() && $this->is_verified === true;
    }

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

/**
     * Vérifie si l'utilisateur peut modérer.
     */
    public function canModerate(): bool
    {
        return $this->isAdmin() || $this->role === 'moderator';
    }

/**
     * Vérifie si l'utilisateur est actif et non suspendu.
     */
    public function isActive(): bool
    {
        return $this->is_active && !$this->isCurrentlySuspended;
    }

    /**
     * Marquer la dernière connexion.
     */
    public function markLastLogin($ip = null)
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip ?? request()->ip()
        ]);
    }

    /**
     * Suspendre l'utilisateur.
     */
    public function suspend($durationDays = 7, $reason = null)
    {
        $this->update([
            'is_suspended' => true,
            'suspended_until' => now()->addDays($durationDays),
            'suspension_reason' => $reason,
            'warning_count' => $this->warning_count + 1
        ]);
    }

/**
     * Lever la suspension.
     */
    public function unsuspend()
    {
        $this->update([
            'is_suspended' => false,
            'suspended_until' => null,
            'suspension_reason' => null
        ]);
    }

/**
     * Mettre à jour la note moyenne.
     */
    public function updateRating()
    {
        $average = $this->receivedReviews()->avg('rating') ?? 0;
        $positive = $this->receivedReviews()->where('rating', '>=', 4)->count();
        $negative = $this->receivedReviews()->where('rating', '<', 4)->count();

        $this->update([
            'average_rating' => round($average, 2),
            'positive_reviews' => $positive,
            'negative_reviews' => $negative
        ]);
    }


/**
     * Obtenir le pourcentage de satisfaction.
     */
    public function getSatisfactionPercentage(): float
    {
        $total = $this->total_reviews;
        if ($total === 0) return 0;

        return round(($this->positive_reviews / $total) * 100, 2);
    }


public function getStatutsPathAttribute()
{
    return $this->settings['document_statuts'] ?? null;
}

public function getRibPathAttribute()
{
    return $this->settings['document_rib'] ?? null;
}

    // --- RELATIONS ELOQUENT ---

    /**
     * L'utilisateur peut être le manager d'une seule association.
     * Relation HasOne (1:1).
     */
    public function association(): HasOne
    {
        return $this->hasOne(Association::class, 'user_id', 'id');
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

/**
     * RELATION MANQUANTE : Documents de l'association (Statuts, RIB)
     * Indispensable pour votre contrôleur et votre vue.
     */
    public function association_documents(): HasOne
    {
        return $this->hasOne(AssociationDocument::class);
    }

public function adminActions(): MorphMany
{
    return $this->morphMany(AdminAction::class, 'target');
}

public function requests(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    // Assurez-vous que le nom du modèle est bien 'DonationRequest' ou 'Request'
    return $this->hasMany(DonationRequest::class, 'requester_id');
}

/**
     * Les conversations initiées par l'utilisateur.
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'initiator_id');
    }

    /**
     * Scope pour les associations vérifiées.
     */
    public function scopeVerifiedAssociations($query)
    {
        return $query->where('role', self::ROLE_ASSOCIATION)
                     ->where('is_verified', true)
                     ->active();
    }

   /**
     * Scope pour les utilisateurs actifs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where(function($q) {
                         $q->where('is_suspended', false)
                           ->orWhereNull('suspended_until')
                           ->orWhere('suspended_until', '<', now());
                     });
    }

   /**
     * Scope pour les utilisateurs par ville.
     */
    public function scopeInCity($query, $city)
    {
        return $query->where('city', $city);
    }

    /**
     * Scope pour les utilisateurs avec une note minimale.
     */
    public function scopeMinRating($query, $rating)
    {
        return $query->where('average_rating', '>=', $rating);

    }
}



