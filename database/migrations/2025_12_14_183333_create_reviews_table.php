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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // Clés Étrangères (FK)
            //  1. Celui qui donne la note (Donateur ou Association)
            $table->foreignId('reviewer_id')
                  ->constrained('users')->onDelete('cascade')
                  ->comment('ID de l\'utilisateur qui a posté l\'avis.');
            // 2. Celui qui reçoit la note (Donateur ou Association)
            $table->foreignId('reviewed_id')
                  ->constrained('users')->onDelete('cascade')
                  ->comment('ID de l\'utilisateur qui est noté.');

                  // 3. Le don qui a généré l'avis (Nullable car un avis peut être sur le profil général)
            $table->foreignId('donation_id')->onDelete('cascade')
                  ->nullable()
                  ->constrained('donations');

            // Contenu de l'Avis
            // Contenu de l'Avis
            $table->unsignedSmallInteger('rating')->comment('Note de 1 à 5.');
            $table->text('comment')->nullable();
            $table->text('response')->nullable()->comment('Réponse de l\'utilisateur noté (ex: Association).');
            $table->boolean('is_visible')->default(true)->comment('Visibilité publique de l\'avis.');

// Contrainte d'unicité : Un utilisateur ne peut évaluer un autre utilisateur qu'une seule fois par donation.
        // CETTE LIGNE DOIT ÊTRE APRÈS LA DÉFINITION DE TOUTES LES COLONNES CI-DESSUS.
        $table->unique(['reviewer_id', 'reviewed_id', 'donation_id'], 'reviews_unique_key');

            $table->timestamps();

            // // Un utilisateur ne peut laisser qu'un seul avis par don à un autre utilisateur
            
            // // Contrainte : Un seul avis par transaction (reviewer/reviewed/donation)
            // $table->unique(['reviewer_id', 'reviewed_id', 'donation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
