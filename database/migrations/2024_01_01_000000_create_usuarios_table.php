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
        Schema::create('USUARIO', function (Blueprint $table) {
            $table->bigInteger('Cedula')->primary();
            $table->string('Nombre');
            $table->string('Apellido');
            $table->string('Direccion');
            $table->string('Email');
            $table->string('Usuario');
            $table->string('Contraseña');
            $table->boolean('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('USUARIO');
    }
};
