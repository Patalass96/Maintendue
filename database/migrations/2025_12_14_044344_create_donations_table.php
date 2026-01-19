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
    {Schema::create('donations', function (Blueprint $table) {
    // --- IDENTIFIANTS ET RELATIONS PRINCIPALES ---
    $table->id();

    // Le donateur : si le compte est supprimé, ses dons disparaissent
    $table->foreignId('donor_id')
          ->constrained('users')
          ->onDelete('cascade');

    // Association qui a fait une demande (optionnel au début)
    $table->foreignId('association_id')
          ->nullable()
          ->constrained('users')
          ->onDelete('set null');

    // Association à qui le don a été officiellement attribué
    $table->foreignId('assigned_association_id')
          ->nullable()
          ->constrained('users')
          ->onDelete('set null');

    // Catégorie du don : si la catégorie est supprimée, on supprime le don
    $table->foreignId('category_id')
          ->constrained()
          ->onDelete('cascade');

    // --- INFORMATIONS GÉNÉRALES ---
    $table->string('title');
    $table->text('description');
    $table->string('city')->default('Lomé');
    $table->enum('urgency', ['low', 'medium', 'high'])->default('low');
    $table->integer('quantity')->default(1);
    $table->enum('status', ['available', 'pending', 'accepted', 'rejected', 'reserved'])->default('available');

    // --- ÉTAT ET DÉTAILS ---
    $table->enum('condition', ['new', 'excellent', 'good', 'fair']);
    $table->string('condition_detail')->nullable()->comment('Ex: Légères égratignures, complet');

    // --- CHAMPS SPÉCIFIQUES (Vêtements, École, Nourriture) ---
    $table->string('size')->nullable(); // Taille (Vêtements/Chaussures)
    $table->enum('gender', ['men', 'women', 'unisex', 'kids'])->nullable();
    $table->date('expiration_date')->nullable(); // Pour les dons alimentaires
    $table->enum('school_level', ['maternelle', 'primaire', 'college', 'lycee', 'superieur'])->nullable();
    $table->string('item_type')->nullable(); // Précision (ex: Cahiers, Stylos, Pantalon)

    // --- LOGISTIQUE ET LOCALISATION ---
    $table->enum('delivery_method', ['direct', 'collection_point', 'both']);

    // Point de collecte : si le point est supprimé, on garde le don mais on met l'ID à null
    $table->foreignId('collection_point_id')
          ->nullable()
          ->constrained()
          ->onDelete('set null');

    $table->datetime('meeting_date')->nullable(); // Pour fixer un RDV
    $table->text('address')->nullable();
    $table->decimal('latitude', 10, 7)->nullable();
    $table->decimal('longitude', 10, 7)->nullable();

    // --- STATISTIQUES ET DATES CLÉS ---
    $table->integer('view_count')->default(0);
    $table->timestamp('reserved_at')->nullable();  // Date de mise en réservation
    $table->timestamp('delivered_at')->nullable(); // Date de remise effective
    $table->timestamp('expires_at')->nullable();   // Date d'expiration de l'annonce
    $table->timestamps();
});
 }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
