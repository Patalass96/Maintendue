<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

 use App\Models\User;             //  Pour la relation manager()
 use App\Models\CollectionPoint;  //  Pour la relation collectionPoints()
 use App\Models\DonationRequest;  //  Pour la relation requests()
 use App\Models\Donation;         //  Pour la relation acceptedDonations()
use App\Models\AssociationNeed;
class Association extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'user_id',
        'legal_name',
        'description',
        'registration_number',
        'legal_address',
        'contact_person',
        'phone',
        'website',
        'logo',
        'verification_status',
        'verification_document',
        'needs_description',
        'opening_hours',
        'delivery_radius',
        'accepts_direct_delivery',
        'accepts_collection_points',
        'is_featured',
        'stats_total_donations',
        'stats_satisfaction_rate',
    ];
/**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'accepts_direct_delivery' => 'boolean',
        'accepts_collection_points' => 'boolean',
        'is_featured' => 'boolean',
        'stats_satisfaction_rate' => 'float', // Pour s'assurer que c'est bien un nombre décimal
        'stats_total_donations' => 'integer',
        'delivery_radius' => 'integer',
    ];
  
    // --- RELATIONS ELOQUENT ---

    /**
     * L'association appartient à un seul utilisateur (le manager/responsable).
     * Relation BelongsTo (1:1 inverse).
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
      public function needs()
    {
        return $this->hasMany(AssociationNeed::class);
    }

    /**
     * L'association peut avoir plusieurs points de collecte.
     * Relation HasMany (1:N).
     */
    public function collectionPoints(): HasMany
    {
        return $this->hasMany(CollectionPoint::class);
    }

    /**
     * L'association peut avoir fait plusieurs demandes de dons.
     * Relation HasMany (1:N).
     */
    public function requests(): HasMany
    {
        return $this->hasMany(DonationRequest::class);
    }
    
    /**
     * L'association peut être attribuée à plusieurs dons (si elle a été choisie pour les récupérer).
     * Relation HasMany (1:N).
     */
    public function acceptedDonations(): HasMany
    {
        // Une association est l'entité qui reçoit le don
        return $this->hasMany(Donation::class, 'assigned_association_id');
    }

  
}