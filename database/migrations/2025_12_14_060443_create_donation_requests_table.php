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
        Schema::create('donation_requests', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('donation_id')->constrained('donations')->onDelete('cascade'); // donation_id (FK vers donations)
            $table->foreignId('association_id')->constrained('associations')->onDelete('cascade'); // association_id (FK vers associations)
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');

            // Statut et Communication
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled', 'completed'])->default('pending'); // status (enum)
            $table->text('message')->nullable(); // message (text, nullable) -> message de l'association
            $table->dateTime('proposed_date')->nullable(); // proposed_date (datetime, nullable) -> date de rencontre proposée

// Pour que l'association puisse expliquer pourquoi elle refuse
    $table->text('refusal_reason')->nullable();

            // Administration
            $table->text('admin_notes')->nullable(); // admin_notes (text, nullable)

            // Timestamps
            $table->timestamps();

            // Une association ne peut faire qu'une demande par don (ou gérer le cycle de vie de la demande existante)
            $table->unique(['donation_id', 'association_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_requests');
    }
};
