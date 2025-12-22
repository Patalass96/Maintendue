<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\DonationImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationImage>
 */
class DonationImageFactory extends Factory
{
protected $model = DonationImage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'donation_id' => Donation::factory(),
            // On utilise une image aléatoire haute résolution
            'path' => 'https://picsum.photos/seed/' . $this->faker->uuid . '/800/600',
            'filename' => 'image_' . $this->faker->unixTime . '.jpg',
            'is_primary' => false,
            'order_index' => 0,
        ];
    }
}
