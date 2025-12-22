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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade'); // conversation_id (FK vers conversations)
            $table->foreignId('sender_id')->constrained('users'); // sender_id (FK vers users)

            // Contenu et Suivi
            $table->text('content'); // content (text)
            $table->timestamp('read_at')->nullable(); // read_at (timestamp, nullable)

            // Messages système
            $table->boolean('is_system_message')->default(false); // is_system_message (boolean)
            $table->json('metadata')->nullable(); // metadata (json, nullable) -> pour messages automatiques

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
