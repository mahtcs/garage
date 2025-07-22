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
        Schema::create('cars', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('brand'); // Marca
        $table->string('model'); // Modelo
        $table->string('year'); // Ano
        $table->enum('body_type', ['hatch', 'sedan', 'suv', 'pickup', 'moto']); // Carroceria
        $table->string('plate')->unique(); // Placa
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
