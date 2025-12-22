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
        Schema::create('donation_images', function (Blueprint $table) {
            $table->id();

            // Relation
            $table->foreignId('donation_id')->constrained('donations')->onDelete('cascade'); // donation_id (FK vers donations)

            // Fichier et Chemins
            $table->string('path'); // path (string) -> 'donations/uuid-filename.jpg'
            $table->string('filename'); // filename (string)

            // Affichage
            $table->boolean('is_primary')->default(false); // is_primary (boolean)
            $table->integer('order_index')->default(0); // order_index (integer)

            // Timestamps
             $table->timestamps(); 

             // Clé unique pour l'ordre des images d'un même don
            $table->unique(['donation_id', 'order_index']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_images');
    }
};
