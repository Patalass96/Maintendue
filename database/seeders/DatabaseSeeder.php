<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🛑 1. Désactiver la vérification des clés étrangères (CRUCIAL pour migrate:fresh)
        $this->command->info(' Début du peuplement de la base de données...');

        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); 

        $this->call([
        CategorySeeder::class,
        UserSeeder::class,
        AssociationSeeder::class,
        CollectionPointSeeder::class,
        DonationSeeder::class, // Les images sont créées ICI à l'intérieur
        // DonationImageSeeder::class, <--- SUPPRIME CETTE LIGNE
        FaqSeeder::class,
        AppSettingSeeder::class,
    ]);

        

        // 🟢 2. Réactiver la vérification des clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS = 1'); 

        $this->command->info(' Peuplement de la base de données terminé avec succès !');
    }
}