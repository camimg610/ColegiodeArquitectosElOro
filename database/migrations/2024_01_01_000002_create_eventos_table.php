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
        Schema::create('EVENTOS', function (Blueprint $table) {
            $table->id('id_evento');
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('fecha');
            $table->bigInteger('hora_inicio');
            $table->bigInteger('hora_fin');
            $table->unsignedBigInteger('id_salon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('EVENTOS');
    }
};
