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
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();

            // Clé Unique pour le paramètre
            $table->string('key')->unique()->comment('Nom unique du paramètre (ex: maintenance_mode, donation_limit).');
            
            // Valeur du paramètre (texte pour la flexibilité)
            $table->text('value')->comment('Valeur du paramètre (peut être une chaîne, un JSON, ou un nombre).');
            
            // Métadonnées
            $table->text('description')->nullable()->comment('Description pour l\'administrateur.');
            $table->boolean('is_public')->default(false)->comment('Indique si le paramètre peut être lu par les utilisateurs non connectés (ex: conditions générales).');
            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
