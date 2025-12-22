<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\Association;
use App\Models\User;
use App\Models\DonationRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationRequest>
 */
class DonationRequestFactory extends Factory
{
    protected $model = DonationRequest::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['pending', 'accepted', 'rejected', 'completed']);
        return [
            'donation_id' => Donation::factory(),
            'association_id' => Association::factory(),
            'status' => $status,
            'message' => $this->faker->sentence(15),
            'proposed_date' => $this->faker->dateTimeBetween('now', '+2 weeks'),
            'refusal_reason' => $status === 'rejected' ? $this->faker->sentence() : null,
            'admin_notes' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            // On peut lier un admin si le statut n'est plus "pending"
            'admin_id' => $status !== 'pending' ? User::where('role', 'admin')->first()?->id : null,
        ];
    }
}
