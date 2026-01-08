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
        Schema::create('association_needs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('association_id')->constrained()->onDelete('cascade');

            // Informations sur le besoin
            $table->string('title');
            $table->text('description');
            $table->enum('item_type', ['clothing', 'shoes', 'food', 'school', 'furniture', 'other']);
            $table->string('school_level')->nullable();
            $table->integer('quantity')->default(1);
            $table->enum('condition', ['new', 'very_good', 'good', 'used'])->nullable();
            $table->string('urgency')->default('medium'); // low, medium, high, urgent


            // Statut

            $table->enum('status', ['active', 'pending', 'fulfilled', 'cancelled'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('association_needs');
    }
};
