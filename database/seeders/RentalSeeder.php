<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rentals = [
            [
                'fecha' => '2024-02-15',
                'hora_inicio' => '09:00',
                'hora_fin' => '12:00',
                'costo' => 150000, // $150
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2024-02-20',
                'hora_inicio' => '14:00',
                'hora_fin' => '18:00',
                'costo' => 200000, // $200
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2024-02-25',
                'hora_inicio' => '10:00',
                'hora_fin' => '12:00',
                'costo' => 100000, // $100
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('ALQUILER')->insert($rentals);

        // Crear detalles de alquileres
        $rentalDetails = [
            [
                'id_alquiler' => 1,
                'cedula_usuario' => 1102345678,
                'id_salon' => 1,
                'fecha_registro' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alquiler' => 2,
                'cedula_usuario' => 1103456789,
                'id_salon' => 2,
                'fecha_registro' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alquiler' => 3,
                'cedula_usuario' => 1105678901,
                'id_salon' => 3,
                'fecha_registro' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('ALQUILER_DETALLE')->insert($rentalDetails);
    }
}
