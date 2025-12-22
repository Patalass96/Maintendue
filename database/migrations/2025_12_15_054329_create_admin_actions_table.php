<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_actions', function (Blueprint $table) {
            $table->id();

            // 1. L'administrateur qui a effectué l'action (FK)
            $table->foreignId('admin_id')
                  ->constrained('users')
                  ->comment('ID de l\'administrateur qui a réalisé l\'action.');

            // 2. Le type et l'ID de l'action effectuée
            $table->string('action_type')->comment('Ex: user_suspended, donation_removed, association_verified.');
            
            // 3. L'entité cible (Polymorphisme)
            $table->string('target_type')->comment('Ex: User, Donation, Association, Report.');
            $table->unsignedBigInteger('target_id')->nullable()->comment('ID de l\'entité ciblée (Nullable si l\'action n\'a pas de cible spécifique, ex: "login admin").');
            
            // Clé Composite pour l'indexation rapide sur les cibles
            $table->index(['target_type', 'target_id']);

            // Détails de l'Action
            $table->text('description');
            $table->json('metadata')->nullable()->comment('Données supplémentaires sur l\'action (ex: ancienne valeur, nouvelle valeur).');

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_actions');
    }
};
