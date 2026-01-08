<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssociationNeed extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'association_id',
        'title',
        'description',
        'item_type',
        'school_level',
        'quantity',
        'condition',
        'urgency',
        'status'
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'quantity' => 'integer',
    ];

    // --- RELATIONS ELOQUENT ---

    /**
     * Le besoin appartient à une association.
     */
    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class);
    }
}
