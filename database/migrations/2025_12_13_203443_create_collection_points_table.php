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
        Schema::create('collection_points', function (Blueprint $table) {
            $table->id();
            // Relation
            $table->foreignId('association_id')->constrained('associations')->onDelete('cascade'); // association_id (FK vers associations)

            // Localisation
            $table->string('name'); // name (string)
            $table->text('address'); // address (text)
            $table->decimal('latitude', 10, 7); // latitude (decimal)
            $table->decimal('longitude', 10, 7); // longitude (decimal)

            // Opérationnel
            $table->text('opening_hours'); // opening_hours (text)
            $table->text('instructions')->nullable(); // instructions (text, nullable)
            $table->string('contact_phone')->nullable(); // contact_phone (string, nullable)
            $table->boolean('is_active')->default(true); // is_active (boolean)

            // Capacité et Usage
            $table->integer('max_capacity')->nullable(); // max_capacity (integer, nullable)
            $table->integer('current_usage')->default(0); // current_usage (integer)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_points');
    }
};
