<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Association;

class CheckAssociations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:associations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifier les associations validées et leurs utilisateurs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Vérification des associations ===');

        $associations = Association::with('manager')
            ->where('verification_status', 'verified')
            ->get();

        if ($associations->isEmpty()) {
            $this->warn('Aucune association vérifiée trouvée.');
            return;
        }

        $this->line("\nAssociations vérifiées:");
        $this->table(
            ['ID Assoc', 'Nom', 'User ID', 'Nom Utilisateur', 'Rôle', 'Actif', 'Status'],
            $associations->map(function ($assoc) {
                return [
                    $assoc->id,
                    $assoc->legal_name ?? 'N/A',
                    $assoc->user_id,
                    $assoc->manager?->name ?? 'N/A',
                    $assoc->manager?->role ?? 'N/A',
                    $assoc->manager?->is_active ? 'Oui' : 'Non',
                    $assoc->verification_status,
                ];
            })->toArray()
        );

        // Vérifier s'il y a une relation manquante
        $this->line("\n=== Vérification des relations User->Association ===");

        $users = User::where('role', 'association')->get();

        $this->line("Utilisateurs avec rôle 'association':");
        $this->table(
            ['ID User', 'Nom', 'Actif', 'Association attachée?'],
            $users->map(function ($user) {
                return [
                    $user->id,
                    $user->name,
                    $user->is_active ? 'Oui' : 'Non',
                    $user->association ? 'Oui' : 'Non',
                ];
            })->toArray()
        );

        // Vérifier le middleware
        $this->line("\n=== Test du middleware ===");

        foreach ($users as $user) {
            $this->line("\nUtilisateur: {$user->name} (ID: {$user->id})");

            $checks = [
                'Connecté' => true,
                'Rôle = association' => $user->role === 'association',
                'Compte actif' => $user->is_active,
                'Association liée' => $user->association !== null,
            ];

            if ($user->association) {
                $checks['Association vérifiée'] = $user->association->verification_status === 'verified';
            }

            foreach ($checks as $check => $result) {
                $status = $result ? '✓' : '✗';
                $color = $result ? 'info' : 'error';
                $this->line("  $status $check");
            }
        }
    }
}
