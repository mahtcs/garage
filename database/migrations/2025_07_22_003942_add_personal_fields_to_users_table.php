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
        Schema::table('users', function (Blueprint $table) {
        $table->string('phone')->nullable()->after('email');
        $table->string('cpf')->unique()->nullable()->after('phone');
        $table->date('birth_date')->nullable()->after('cpf');
        $table->string('street')->nullable()->after('birth_date');
        $table->string('number')->nullable()->after('street');
        $table->string('complement')->nullable()->after('number');
        $table->string('district')->nullable()->after('complement');
        $table->string('city')->nullable()->after('district');
        $table->string('state')->nullable()->after('city');
        $table->string('zip_code')->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
