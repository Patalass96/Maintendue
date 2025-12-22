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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // Clé Étrangère (FK)
            // L'utilisateur destinataire de la notification
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade') // Si l'utilisateur est supprimé, ses notifications le sont aussi.
                  ->comment('ID de l\'utilisateur destinataire.');

                  // Contenu et Type
            $table->string('type')->comment('Type de notification (ex: request_received, message_received).');
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable()->comment('Données structurées supplémentaires (ex: ID du don, ID de la conversation).');
            $table->string('action_url')->nullable()->comment('URL vers laquelle la notification doit diriger l\'utilisateur.');

            // Statut de Lecture
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
