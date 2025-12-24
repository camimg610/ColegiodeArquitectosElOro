<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Borrar todos los permisos existentes
        DB::table('PERMISOS')->delete();

        $permissions = [
            [
                'nombre_permiso' => 'ver_usuarios',
                'descripcion' => 'Ver lista de usuarios',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_permiso' => 'crear_usuarios',
                'descripcion' => 'Crear nuevos usuarios',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_permiso' => 'editar_usuarios',
                'descripcion' => 'Editar usuarios existentes',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_permiso' => 'eliminar_usuarios',
                'descripcion' => 'Eliminar usuarios',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('PERMISOS')->insert($permissions);
    }
}
