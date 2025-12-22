<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\DonationImage;
use Illuminate\Database\Seeder;

class DonationImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $donations = Donation::all();

        foreach ($donations as $donation) {
            // 1. On crée l'image principale
            DonationImage::factory()->create([
                'donation_id' => $donation->id,
                'is_primary' => true,
                'order_index' => 0,
            ]);

            // 2. On ajoute 1 ou 2 images secondaires
            DonationImage::factory(rand(1, 2))->create([
                'donation_id' => $donation->id,
                'is_primary' => false,
                'order_index' => function (array $attributes) {
                    static $index = 1;
                    return $index++;
                },
            ]);
        }
    }
    }

