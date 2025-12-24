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
        Schema::create('ROLES_PERMISOS', function (Blueprint $table) {
            $table->id('id_rol_permiso');
            $table->unsignedBigInteger('id_rol');
            $table->unsignedBigInteger('id_permiso');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('id_rol')->references('id_rol')->on('ROLES');
            $table->foreign('id_permiso')->references('id_permiso')->on('PERMISOS');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ROLES_PERMISOS');
    }
};
