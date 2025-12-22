<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\CollectionPoint;
use Illuminate\Database\Seeder;

class CollectionPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $associations = Association::all();

        foreach ($associations as $association) {
            // On crée entre 1 et 2 points de collecte par association
            CollectionPoint::factory(rand(1, 2))->create([
                'association_id' => $association->id,
            ]);
        }
    }
}
