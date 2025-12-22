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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('donation_id')->constrained('donations')->onDelete('cascade'); // donation_id (FK vers donations)

            // Participants
            $table->foreignId('initiator_id')->constrained('users'); // initiator_id (FK vers users)
            $table->foreignId('recipient_id')->constrained('users'); // recipient_id (FK vers users)

            // Statut et Suivi
            $table->enum('status', ['active', 'closed', 'archived'])->default('active'); // status (enum)
            $table->timestamp('last_message_at')->nullable(); // last_message_at (timestamp, nullable)

            // Timestamps
            $table->timestamps();

            // Assurer qu'il n'y ait pas deux conversations identiques pour un même don
            $table->unique(['donation_id', 'initiator_id', 'recipient_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
