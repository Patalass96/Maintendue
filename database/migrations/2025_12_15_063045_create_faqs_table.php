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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();

            $table->text('question');
            $table->text('answer');

            // Catégorie pour le filtrage côté front-end
            $table->string('category')->comment('Ex: donor, association, general.'); 
            
            // Ordre d'affichage
            $table->unsignedSmallInteger('order_index')->default(0)->comment('Ordre d\'affichage au sein d\'une catégorie.');
            
            // Statut de visibilité
            $table->boolean('is_active')->default(true);
            // Timestamps
            $table->timestamps();

        });

        // Ajout d'un index pour optimiser le tri par catégorie et ordre
        Schema::table('faqs', function (Blueprint $table) {
            $table->index(['category', 'order_index']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
