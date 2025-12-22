<?php

namespace Database\Factories;

use App\Models\Association;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssociationFactory extends Factory
{
    protected $model = Association::class;

    public function definition(): array
    {
        return [
            // Le user_id sera passé lors de la création dans le Seeder
            'user_id' => User::factory()->create(['role' => 'association'])->id,
            'legal_name' => $this->faker->company() . ' Togo',
            'description' => 'Association dédiée à '. $this-> faker->sentence(10),
            'registration_number' => $this->faker->unique()->numerify('#########'), 
            'legal_address' => $this->faker->address(),
            'contact_person' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'website' => 'https://www.' . $this->faker->domainName(),
            'logo' => "https://ui-avatars.com/api/?name=" . urlencode(fake()->company()) . "&background=random&size=128",
            'verification_status' =>  'verified',
            'verification_document' => null,
            'needs_description' => 'Nous avons actuellement besoin de ' . fake()->words(3, true),
            'opening_hours' => 'Lun-Ven: 08h-17h',
            'delivery_radius' => $this->faker->numberBetween(5, 50),
            'accepts_direct_delivery' => true,
            'accepts_collection_points' => $this->faker->boolean(),
            'is_featured' => $this->faker->boolean(20), // 20% de chances d'être mis en avant
            'stats_total_donations' => $this->faker->numberBetween(0, 100),
            'stats_satisfaction_rate' => $this->faker->randomFloat(2, 3.5, 5), // Note entre 3.5 et 5
        ];
    }
}