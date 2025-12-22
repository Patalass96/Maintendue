<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Category;
use App\Models\Association;
use App\Models\CollectionPoint;
use App\Models\DonationImage;
use App\Models\DonationRequest;
use App\Models\Conversation;
use App\Models\Review;
use App\Models\Report;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne; 
use Illuminate\Database\Eloquent\Relations\MorphMany; 



class Donation extends Model
{
    use HasFactory;

    // CONSTANTES DE STATUT (Plus propre pour le code) ---
    const STATUS_PENDING = 'pending';
    const STATUS_AVAILABLE = 'available'; 
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_REJECTED = 'rejected';
    
    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
       'donor_id',
        'association_id',
        'assigned_association_id',
        'category_id',
        'title',
        'description',
        'city',
        'urgency',
        'size',
        'quantity',
        'status',
        'condition',
        'condition_detail',
        'gender',
        'expiration_date',
        'school_level',
        'item_type',
        'delivery_method',
        'collection_point_id',
        'meeting_date',
        'address',
        'latitude',
        'longitude',
        'view_count',
        'reserved_at',
        'delivered_at',
        'expires_at',
    ];

    /**
     * Les attributs qui doivent être castés en types natifs.
     */
    protected $casts = [
        
        'expiration_date' => 'date',
        'meeting_date' => 'datetime',
        'reserved_at' => 'datetime',
        'delivered_at' => 'datetime',
        'expires_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
        'quantity' => 'integer',
        'view_count' => 'integer'
    ];

     // --- ACCESSEURS UTILES ---

    /**
     * Récupère l'image principale du don (ou une image par défaut)
     */
    public function getThumbnailAttribute()
    {
       // On vérifie si la relation primaryImage existe et si le fichier existe
           return $this->primaryImage ?->path ?? 'assets/images/placeholder-don.png';
    }


    // --- RELATIONS ELOQUENT ---

    /**
     * Le don appartient à un Donateur.
     * Relation BelongsTo (N:1).
     */
    public function donor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    /**
     * Le don est classé dans une catégorie.
     * Relation BelongsTo (N:1).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
 * L'association ciblée par le donateur lors de la création.
 */
public function targetedAssociation(): BelongsTo
{
    return $this->belongsTo(Association::class, 'association_id');
}

    /**
     * Le don est (ou a été) assigné à une association.
     * Relation BelongsTo (N:1, Nullable).
     */
    public function assignedAssociation(): BelongsTo
    {
        // Utilise assigned_association_id comme FK pour éviter le conflit avec association_id
        return $this->belongsTo(Association::class, 'assigned_association_id'); 
    }

    /**
     * Le don a été désigné pour un point de collecte spécifique.
     * Relation BelongsTo (N:1, Nullable).
     */
    public function collectionPoint(): BelongsTo
    {
        return $this->belongsTo(CollectionPoint::class);
    }

/**
     * Relation vers l'image principale uniquement.
     * Très utile pour les listes de dons (Eager Loading).
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(DonationImage::class)->where('is_primary', true);
    }


    /**
     * Le don possède plusieurs images.
     * Relation HasMany (1:N).
     */
    public function images(): HasMany
    {
        return $this->hasMany(DonationImage::class);
    }

    /**
     * Le don peut être l'objet de plusieurs demandes par les associations.
     * Relation HasMany (1:N).
     */
    public function requests(): HasMany
    {
        return $this->hasMany(DonationRequest::class);
    }

    /**
     * Le don est l'objet d'une conversation (unique).
     * Relation HasOne (1:1).
     */
    public function conversation(): HasOne
    {
        return $this->hasOne(Conversation::class);
    }
    
    /**
     * Le don peut avoir reçu plusieurs avis (reviews).
     * Relation HasMany (1:N).
     */
    public function reviews(): HasMany
    {
        // Un avis est généralement sur le Donateur ou l'Association, mais si vous voulez lier
        // des avis directement à la transaction du don:
        return $this->hasMany(Review::class);
    }

    /**
     * Le don peut être l'objet de signalements (Polymorphisme).
     * Relation MorphMany.
     */
          
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reported');
    }

 // --- SCOPES DE RECHERCHE (Pour ton interface de filtres Figma) ---

    public function scopeInCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeByUrgency($query, $urgency)
    {
        return $query->where('urgency', $urgency);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

}