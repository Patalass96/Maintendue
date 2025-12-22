<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // --- COMPTES DE TEST (Pour le développement) ---

       // 1. Créer l'Administrateur
        User::factory()->admin()->create([
            'name' => 'Admin MainTendue',
            'email' => 'admin@maintendue.tg',
            'password' => Hash::make('admin123'),
            'avatar'=> 'assets/images/MainTendue.png',
        
        ]);

        // 2. Une Association de test
        User::factory()->association()->create([
            'name' => 'Croix Rouge Test',
            'email' => 'association@test.org',
            // 'password' => Hash::make('password'),
            // 'role' => 'association',
            // 'is_active' => true,
        ]);

        // 3. Un Donateur de test
        User::factory()->create([
            'name' => 'Jean Donateur',
            'email' => 'donateur@test.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DONATOR,
            
        ]);

        // --- GÉNÉRATION DE MASSE (Pour tester le design/pagination) ---

        // Créer 10 managers d'associations aléatoires
        User::factory(10)->association()->create();

        // Créer 30 donateurs aléatoires
        User::factory(30)->create();
    }
}