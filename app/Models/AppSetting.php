<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être massivement assignés.
     */
    protected $fillable = [
        'key',
        'value',
        'description',
        'is_public',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'is_public' => 'boolean',
    ];

    // --- LOGIQUE UTILE (Scopes et Helpers) ---

    /**
     * Scope pour récupérer les paramètres publics.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Récupère la valeur d'un paramètre par sa clé.
     * @param string $key
     * @return mixed|null
     */
    public static function getValue(string $key): mixed
    {
        $setting = self::where('key', $key)->first();
        
        // Tentative de décoder la valeur comme JSON pour plus de flexibilité
        if ($setting) {
            $decodedValue = json_decode($setting->value, true);
            // Si le décodage a réussi et n'est pas null/false de manière accidentelle, retourne l'array/objet
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decodedValue;
            }
            return $setting->value; // Sinon, retourne la chaîne de texte brute
        }
        return null;
    }
}
