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
        Schema::create('user_notification_settings', function (Blueprint $table) {
            $table->id();

            // Clé Étrangère (FK) vers l'utilisateur
            // L'ajout de unique() garantit qu'un utilisateur n'a qu'un seul jeu de préférences.
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained('users')
                  ->onDelete('cascade');

            // Préférences Email
            $table->boolean('email_new_donations')->default(true)->comment('Recevoir des emails pour les nouveaux dons dans le secteur.');
            $table->boolean('email_messages')->default(true)->comment('Recevoir des emails pour les nouveaux messages privés.');
            $table->boolean('email_requests')->default(true)->comment('Recevoir des emails pour les nouvelles demandes de dons.');
            
            // Préférences Push (pour les applications mobiles/PWA)
            $table->boolean('push_new_donations')->default(true)->comment('Recevoir des notifications push pour les nouveaux dons.');
            $table->boolean('push_messages')->default(true)->comment('Recevoir des notifications push pour les nouveaux messages.');
            
            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notification_settings');
    }
};
