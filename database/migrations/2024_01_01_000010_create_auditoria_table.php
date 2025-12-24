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
        Schema::create('AUDITORIA', function (Blueprint $table) {
            $table->id('id_auditoria');
            $table->string('tabla_afectada');
            $table->string('operacion'); // INSERT, UPDATE, DELETE
            $table->bigInteger('cedula_usuario')->nullable();
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->timestamp('fecha_operacion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('AUDITORIA');
    }
};
