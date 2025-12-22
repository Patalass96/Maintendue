<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssociationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. On récupère les utilisateurs avec le rôle association
        // On utilise la constante pour éviter les erreurs de frappe
        $associationUsers = User::where('role', User::ROLE_ASSOCIATION)->get();

        foreach ($associationUsers as $user) {
            
            // 2. Configuration spécifique si c'est notre utilisateur de test principal
            // Vérifie bien si c'est .org ou .tg selon ton UserSeeder
            if ($user->email === 'association@test.org') {
                Association::factory()->create([
                    'user_id' => $user->id,
                    'legal_name' => 'Croix Rouge Togolaise',
                    'verification_status' => 'verified',
                    'is_featured' => true,
                ]);
            } else {
                // 3. Pour les autres, on génère des données aléatoires
                Association::factory()->create([
                    'user_id' => $user->id,
                    'legal_name' => 'ONG ' . $user->name,
                ]);
            }
        }
    }
}