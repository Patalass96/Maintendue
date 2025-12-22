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
        Schema::create('associations', function (Blueprint $table) {
            $table->id(); // id (PK, AI)

            // Relation au manager (l'utilisateur qui gère ce compte d'association)
            // L'utilisateur (manager) doit exister pour que l'association existe.
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('Manager utilisateur de l’association.'); 

            // Informations Légales et Contact
            $table->string('legal_name'); // Nom légal de l'association
            $table->text('description'); 
            $table->string('registration_number')->nullable()->unique(); // Numéro d'enregistrement officiel (nullable, unique)
            $table->text('legal_address'); // Adresse complète
            $table->string('contact_person'); // Nom du contact principal
            $table->string('phone'); 
            $table->string('website')->nullable(); 
            $table->string('logo')->nullable(); 

            // Vérification et Statut
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->string('verification_document')->nullable()->comment('Chemin vers le justificatif légal');
            
            // Logistique et Besoins
            $table->text('needs_description')->nullable()->comment('Description textuelle des besoins actuels.');
            $table->text('opening_hours')->nullable()->comment('Horaires pour la collecte ou la livraison.');
            $table->integer('delivery_radius')->nullable()->comment('Rayon d’acceptation des dons en km.');
            $table->boolean('accepts_direct_delivery')->default(true);
            $table->boolean('accepts_collection_points')->default(false);
            
            // Mise en Avant
            $table->boolean('is_featured')->default(false);

            // Statistiques (maintenues par l'application)
            $table->integer('stats_total_donations')->default(0);
            $table->decimal('stats_satisfaction_rate', 3, 2)->nullable()->comment('Note moyenne sur 5'); // 3 chiffres au total, 2 après la virgule (ex: 4.85)

            // Timestamps
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};