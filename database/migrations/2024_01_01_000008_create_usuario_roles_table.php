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
        Schema::create('USUARIO_ROLES', function (Blueprint $table) {
            $table->id('id_usuario_rol');
            $table->bigInteger('cedula_usuario');
            $table->unsignedBigInteger('id_rol');
            $table->date('fecha_asignacion')->default(DB::raw('CURRENT_DATE'));
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('cedula_usuario')->references('Cedula')->on('USUARIO');
            $table->foreign('id_rol')->references('id_rol')->on('ROLES');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('USUARIO_ROLES');
    }
};
