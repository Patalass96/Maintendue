<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    // On hache le mot de passe une seule fois pour gagner du temps
    protected static ?string $password;

    public function definition(): array
{
        $randomAvatarId = $this->faker->numberBetween(1, 70);

    
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'), // Mot de passe par défaut pour tous
            'role' => User::ROLE_DONATOR, // Rôle par défaut
            'is_active' => true,
            'avatar' => "https://i.pravatar.cc/150?u=" . $randomAvatarId,

            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),


            // COORDONNÉES RÉELLES POUR LOMÉ/TOGO
            'latitude' => $this->faker->latitude(6.12, 6.22), 
            'longitude' => $this->faker->longitude(1.15, 1.30),

            'settings' => ['notifications' => true, 'theme' => 'light'],
            'remember_token' => Str::random(10),
        ];
    }

    // État pour un Admin
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => User::ROLE_ADMIN,
        ]);
    }

    // État pour une Association
    public function association(): static
    {
        return $this->state(fn (array $attributes) => [
      'role' => User::ROLE_ASSOCIATION,
        ]);
    }
}