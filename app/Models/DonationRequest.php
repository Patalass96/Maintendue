<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Donation;
use App\Models\Association;
use App\Models\User;

class DonationRequest extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'donation_id',
        'association_id',
        'admin_id',
        'status',
        'message',
        'proposed_date',
        'admin_notes',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'proposed_date' => 'datetime',
    ];

    // --- RELATIONS ELOQUENT ---

    /**
     * La demande concerne un seul don.
     * Relation BelongsTo (N:1).
     */
    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }

    /**
     * La demande a été faite par cette association.
     * Relation BelongsTo (N:1).
     */

    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class);
    }

    /**
 * L'administrateur qui a traité cette demande (acceptation/rejet).
 * Relation BelongsTo (N:1).
 */
public function handledBy(): BelongsTo
{
    // Laravel cherchera la colonne 'admin_id' par défaut, car le nom de la fonction est 'handledBy'
    return $this->belongsTo(User::class, 'admin_id');
}

}