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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            
            $table->string('name')->unique(); // name (string)
            $table->string('slug')->unique(); // slug (string)
            $table->string('icon')->nullable(); // icon (string)
            $table->text('description')->nullable(); // description (text, nullable)
            
            $table->boolean('is_active')->default(true); // is_active (boolean)
            $table->integer('order_index')->default(0); // order_index (integer)
            
            $table->timestamps(); // created_at & updated_at
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
