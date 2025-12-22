<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Association;
use App\Models\DonationRequest;
use Illuminate\Database\Seeder;

class DonationRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $donations = Donation::all();
           $associations = Association::all();

        if ($donations->isEmpty() || $associations->isEmpty()) {
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $donation = $donations->random();
            $association = $associations->random();

           // On vérifie si cette demande n'existe pas déjà pour respecter la clé unique
             $exists = DonationRequest::where('donation_id', $donation->id)
                ->where('association_id', $association->id)
                ->exists();
            if (!$exists) {
                DonationRequest::factory()->create([
                'donation_id' => $donation->id,
                'association_id' => $associations->id,
            ]);
        }
    }
}

}