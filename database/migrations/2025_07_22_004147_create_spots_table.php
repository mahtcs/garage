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
       Schema::create('spots', function (Blueprint $table) {
        $table->id();
        $table->foreignId('garage_id')->constrained()->onDelete('cascade');
        $table->string('identification'); // Ex: "Vaga 01", "G2"
        $table->enum('supported_body_types', ['hatch', 'sedan', 'suv', 'pickup', 'moto', 'all']); // Para quais tipos de carro a vaga serve
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spots');
    }
};
