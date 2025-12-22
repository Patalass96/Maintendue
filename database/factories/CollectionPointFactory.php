<?php

namespace Database\Factories;

use App\Models\Association;
use App\Models\CollectionPoint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CollectionPoint>
 */
class CollectionPointFactory extends Factory
{

    protected $model = CollectionPoint::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            // L'association sera liée dans le seeder
            'association_id' => Association::factory(),
            'name' => $this->faker->randomElement(['Relais', 'Dépôt', 'Point']) . ' ' . $this->faker->streetName(),
            'address' => $this->faker->address(),
            // Coordonnées ciblées sur Lomé
            'latitude' => $this->faker->latitude(6.12, 6.22),
            'longitude' => $this->faker->longitude(1.15, 1.30),
            'opening_hours' => 'Lun-Sam: 09h-18h',
            'instructions' => 'Demander le responsable de l\'ONG à l\'accueil.',
            'contact_phone' => $this->faker->phoneNumber(),
            'is_active' => true,
            'max_capacity' => $this->faker->randomElement([50, 100, 200, null]),
            'current_usage' => 0,

        ];
    }
}
