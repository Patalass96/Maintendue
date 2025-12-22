<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\User;
use App\Models\Category;
use App\Models\CollectionPoint; 
use Illuminate\Database\Eloquent\Factories\Factory;

class DonationFactory extends Factory
{
    protected $model = Donation::class;

    public function definition(): array
    {
        // On définit la méthode de livraison en premier pour l'utiliser après
        $deliveryMethod = $this->faker->randomElement(['pickup', 'delivery', 'collection_point']);

        return [
'donor_id' => User::factory()->state(['role' => User::ROLE_DONATOR])->create()->id,
            'category_id' => Category::all()->random()->id,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'city' => $this->faker->randomElement(['Lomé', 'Aného', 'Kpalimé', 'Tsévié', 'Atakpamé', 'Sokodé', 'Kara']),
            'urgency' => $this->faker->randomElement(['low', 'medium', 'high']),
            'status' => Donation::STATUS_AVAILABLE,
            'condition' => $this->faker->randomElement(['new', 'excellent', 'good', 'fair']),
            'condition_detail' => $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(1, 10),

            // Logistique
            'delivery_method' => $this->faker->randomElement([
    'direct',           // Remplace 'delivery' ou 'pickup' par 'direct'
    'collection_point', 
    'both'
]),
            // LOGIQUE ICI : Si c'est un point de collecte, on va en chercher un
            'collection_point_id' => $deliveryMethod === 'collection_point' 
                ? CollectionPoint::all()->random()->id 
                : null,
            
            'address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(6.12, 6.20),
            'longitude' => $this->faker->longitude(1.15, 1.30),
            
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL', '38', '40', '42']),
            'gender' => $this->faker->randomElement(['men', 'women', 'kids', 'unisex']),
          // Dans DonationFactory.php, remplace la ligne school_level par celle-ci :

'school_level' => $this->faker->randomElement([
    'maternelle', 
    'primaire', 
    'college', 
    'lycee', 
    'superieur'
]),
            'item_type' => $this->faker->word(),
            
            'view_count' => $this->faker->numberBetween(0, 100),
            'expires_at' => now()->addDays(30),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function food(): static
    {
        return $this->state(fn (array $attributes) => [
            'expiration_date' => $this->faker->dateTimeBetween('+1 week', '+6 months'),
        ]);
    }
}