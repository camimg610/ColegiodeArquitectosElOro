<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'tipo_rol' => 'Administrador',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_rol' => 'Usuario',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_rol' => 'Invitado',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('ROLES')->insert($roles);
    }
}
