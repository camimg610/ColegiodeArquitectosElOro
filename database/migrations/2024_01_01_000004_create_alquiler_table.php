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
        Schema::create('ALQUILER', function (Blueprint $table) {
            $table->id('id_alquiler');
            $table->string('fecha');
            $table->string('hora_inicio');
            $table->string('hora_fin');
            $table->bigInteger('costo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ALQUILER');
    }
};
