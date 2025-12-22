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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            // Role : Définit si l'utilisateur est un admin, une association ou un donateur.
            $table->enum('role', ['admin', 'association', 'donateur'])->default('donateur');

            // Statut : Permet de désactiver ou de suspendre un utilisateur (modération).
            $table->boolean('is_active')->default(true);


            // Informations de contact et géolocalisation
            $table->string('avatar')->nullable(); // avatar (, nullable)
            $table->string('phone')->nullable(); // phone (string, nullable)

            $table->string('address')->nullable(); // address (text, nullable)
            $table->decimal('latitude', 10, 7)->nullable(); // latitude (decimal, nullable)
            $table->decimal('longitude', 10, 7)->nullable(); // longitude (decimal, nullable)

            // Préférences
            $table->json('settings')->nullable(); // settings (json, nullable)

            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
