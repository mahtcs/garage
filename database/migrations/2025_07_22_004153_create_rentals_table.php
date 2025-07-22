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
        Schema::create('rentals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('spot_id')->constrained();
        $table->foreignId('car_id')->constrained();
        $table->foreignId('client_id')->references('id')->on('users'); // O usuário que aluga
        $table->foreignId('owner_id')->references('id')->on('users'); // O dono da garagem
        $table->date('start_date'); // Valido de
        $table->date('end_date'); // Valido ate
        $table->enum('status', ['pending', 'active', 'finished', 'canceled'])->default('pending');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
