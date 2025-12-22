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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();

// // Relation à l'utilisateur
//  $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // user_id (FK vers users)

// Informations du fournisseur social

//  $table->string('provider'); // provider (string) -> 'google', 'facebook', etc.

//  $table->string('provider_id')->unique(); // provider_id (string, unique) -> ID unique chez le fournisseur

// Jetons d'accès (optionnel, mais utile si vous avez besoin d'interagir avec l'API sociale)

//  $table->text('access_token')->nullable();

// $table->text('refresh_token')->nullable();

            $table->morphs('tokenable');
            $table->text('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamps();

            // Assure qu'un utilisateur n'a qu'un seul compte par fournisseur
            // $table->unique(['user_id', 'provider']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
