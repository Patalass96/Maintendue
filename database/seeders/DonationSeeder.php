<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\User;
use App\Models\Category;
use App\Models\DonationImage;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Récupération des données nécessaires
$donors = User::where('role', User::ROLE_DONATOR)->get();
        $categories = Category::all();

        // Sécurité : Vérifier que les tables parentes ne sont pas vides
        if ($donors->isEmpty()) {
            $this->command->warn("⚠️ Aucun donateur trouvé. Assurez-vous d'avoir lancé UserSeeder.");
            return;
        }

        if ($categories->isEmpty()) {
            $this->command->error("❌ Aucune catégorie trouvée. Lancez CategorySeeder d'abord !");
            return;
        }

        $this->command->info("🎁 Génération des dons pour " . $donors->count() . " donateurs...");

        // 2. Boucle sur chaque donateur
        foreach ($donors as $donor) {
            
            // On crée entre 3 et 7 dons par donateur pour un rendu riche sur l'interface
            Donation::factory(rand(3, 7))->create([
                'donor_id' => $donor->id,
                'category_id' => $categories->random()->id,
                'status' => Donation::STATUS_AVAILABLE,
            ])->each(function ($donation) {
                
                // 3. CRÉATION DE L'IMAGE PRINCIPALE (Grande : 1200x800)
                // Cette image sera celle récupérée par ton accesseur getThumbnailAttribute()
                DonationImage::factory()->create([
                    'donation_id' => $donation->id,
                    'is_primary' => true,
                    'order_index' => 0,
                    // Seed unique basé sur l'ID du don pour une image fixe
                    'path' => 'https://picsum.photos/seed/donation_main_' . $donation->id . '/1200/800',
                ]);

                // 4. CRÉATION DES IMAGES SECONDAIRES (Petites : 400x400)
                // On en crée entre 2 et 4 pour remplir la galerie sous l'image principale
                $nbSecondary = rand(2, 4);
                for ($i = 1; $i <= $nbSecondary; $i++) {
                    DonationImage::factory()->create([
                        'donation_id' => $donation->id,
                        'is_primary' => false,
                        'order_index' => $i,
                        // Seed unique pour chaque miniature
                        'path' => 'https://picsum.photos/seed/donation_thumb_' . $donation->id . '_' . $i . '/400/400',
                    ]);
                }
            });
        }

        $this->command->info("✅ DonationSeeder : Tous les dons et leurs galeries d'images ont été créés !");
    }
}