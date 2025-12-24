<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inscriptions = [
            [
                'fecha_inscripcion' => '2024-02-10',
                'estado' => 'Activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha_inscripcion' => '2024-02-12',
                'estado' => 'Pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha_inscripcion' => '2024-02-14',
                'estado' => 'Cancelado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('INSCRIPCIONES')->insert($inscriptions);

        // Crear detalles de inscripciones
        $inscriptionDetails = [
            [
                'id_inscripcion' => 1,
                'cedula_usuario' => 1102345678,
                'id_evento' => 1,
                'fecha_registro' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_inscripcion' => 1,
                'cedula_usuario' => 1103456789,
                'id_evento' => 1,
                'fecha_registro' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_inscripcion' => 2,
                'cedula_usuario' => 1105678901,
                'id_evento' => 2,
                'fecha_registro' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_inscripcion' => 2,
                'cedula_usuario' => 1107890123,
                'id_evento' => 2,
                'fecha_registro' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_inscripcion' => 3,
                'cedula_usuario' => 1109012345,
                'id_evento' => 3,
                'fecha_registro' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('INSCRIPCIONES_DETALLE')->insert($inscriptionDetails);
    }
}
