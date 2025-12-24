<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('INSCRIPCIONES_DETALLE', function (Blueprint $table) {
            $table->id('id_inscripcion_detalle');
            $table->unsignedBigInteger('id_inscripcion');
            $table->bigInteger('cedula_usuario');
            $table->unsignedBigInteger('id_evento');
            $table->timestamp('fecha_registro')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            $table->foreign('id_inscripcion')->references('id_inscripcion')->on('INSCRIPCIONES');
            $table->foreign('cedula_usuario')->references('Cedula')->on('USUARIO');
            $table->foreign('id_evento')->references('id_evento')->on('EVENTOS');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('INSCRIPCIONES_DETALLE');
    }
};
