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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // 1. L'émetteur du signalement (FK)
            $table->foreignId('reporter_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('ID de l\'utilisateur qui a émis le signalement.');

            // 2. L'entité signalée (Polymorphisme)
            $table->string('reported_type')->comment('Type de l\'entité signalée (Donation, User, Association).');
            $table->unsignedBigInteger('reported_id')->comment('ID de l\'entité signalée.');

            // Clé Composite pour l'indexation rapide sur les entités signalées
            $table->index(['reported_type', 'reported_id']);

            // Contenu du Signalement
            $table->enum('reason', ['spam', 'inappropriate', 'fraud', 'other']);
            $table->text('description')->nullable();

            // Statut et Résolution
            $table->enum('status', ['pending', 'reviewed', 'resolved', 'dismissed'])->default('pending');
            $table->text('admin_notes')->nullable()->comment('Notes internes de l\'administrateur.');
            $table->timestamp('resolved_at')->nullable();
            
            // 3. L'administrateur qui a résolu le signalement (FK, Nullable)
            $table->foreignId('resolved_by')
                  ->nullable()
                  ->constrained('users'); // Contrainte sans onDelete('cascade') car l'admin ne doit pas dépendre des signalements.
                //   Time stamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
