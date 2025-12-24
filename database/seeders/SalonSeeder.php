<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salons = [
            [
                'nombre' => 'Salón Principal',
                'capacidad' => 100,
                'ubicacion' => 'Primer piso',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Salón de Conferencias',
                'capacidad' => 50,
                'ubicacion' => 'Segundo piso',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Sala de Reuniones',
                'capacidad' => 20,
                'ubicacion' => 'Tercer piso',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Auditorio',
                'capacidad' => 200,
                'ubicacion' => 'Sótano',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('SALONES')->insert($salons);
    }
}
