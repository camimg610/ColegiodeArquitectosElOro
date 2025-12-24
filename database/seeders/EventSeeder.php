<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'nombre' => 'Conferencia de Arquitectura',
                'descripcion' => 'Conferencia sobre tendencias modernas en arquitectura',
                'fecha' => '2024-02-15',
                'hora_inicio' => 900, // 9:00 AM
                'hora_fin' => 1200,   // 12:00 PM
                'id_salon' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Taller de Diseño',
                'descripcion' => 'Taller práctico de diseño arquitectónico',
                'fecha' => '2024-02-20',
                'hora_inicio' => 1400, // 2:00 PM
                'hora_fin' => 1800,    // 6:00 PM
                'id_salon' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Reunión de Colegiados',
                'descripcion' => 'Reunión mensual de colegiados',
                'fecha' => '2024-02-25',
                'hora_inicio' => 1000, // 10:00 AM
                'hora_fin' => 1200,    // 12:00 PM
                'id_salon' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Presentación de Proyectos',
                'descripcion' => 'Presentación de proyectos estudiantiles',
                'fecha' => '2024-03-01',
                'hora_inicio' => 1500, // 3:00 PM
                'hora_fin' => 1900,    // 7:00 PM
                'id_salon' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('EVENTOS')->insert($events);
    }
}
