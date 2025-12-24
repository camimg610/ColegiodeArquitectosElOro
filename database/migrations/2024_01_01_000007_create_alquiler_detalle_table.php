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
        Schema::create('ALQUILER_DETALLE', function (Blueprint $table) {
            $table->id('id_alquiler_detalle');
            $table->unsignedBigInteger('id_alquiler');
            $table->bigInteger('cedula_usuario');
            $table->unsignedBigInteger('id_salon');
            $table->timestamp('fecha_registro')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            $table->foreign('id_alquiler')->references('id_alquiler')->on('ALQUILER');
            $table->foreign('cedula_usuario')->references('Cedula')->on('USUARIO');
            $table->foreign('id_salon')->references('id_salon')->on('SALONES');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ALQUILER_DETALLE');
    }
};
