<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Association;

class VerifyAssociations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'associations:verify {--user-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifier une ou toutes les associations en attente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('user-id')) {
            $userId = $this->option('user-id');
            $association = Association::where('user_id', $userId)->first();

            if (!$association) {
                $this->error("Aucune association trouvée pour l'utilisateur ID: {$userId}");
                return;
            }

            $this->line("Association trouvée: {$association->legal_name}");
            $this->line("Status actuel: {$association->verification_status}");

            $association->update(['verification_status' => 'verified']);
            $this->info("✓ Association vérifiée avec succès!");
        } else {
            $pending = Association::where('verification_status', '!=', 'verified')->get();

            if ($pending->isEmpty()) {
                $this->info("Toutes les associations sont vérifiées!");
                return;
            }

            $this->line("Associations en attente de vérification:");
            $this->table(
                ['ID', 'Nom', 'User ID', 'Status'],
                $pending->map(fn($a) => [$a->id, $a->legal_name, $a->user_id, $a->verification_status])->toArray()
            );
        }
    }
}
