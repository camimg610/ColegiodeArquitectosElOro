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
        Schema::table('INSCRIPCIONES', function (Blueprint $table) {
            // Si necesitas convertir a boolean, usa SQL directo para PostgreSQL
            DB::statement('ALTER TABLE "INSCRIPCIONES" ALTER COLUMN "estado" TYPE boolean USING estado::boolean');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('INSCRIPCIONES', function (Blueprint $table) {
            DB::statement('ALTER TABLE "INSCRIPCIONES" ALTER COLUMN "estado" TYPE varchar(255) USING estado::varchar');
        });
    }
};
