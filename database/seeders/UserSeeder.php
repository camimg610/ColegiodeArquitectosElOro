<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            [
                'Cedula' => 123456789,
                'Nombre' => 'Admin',
                'Apellido' => 'Principal',
                'Direccion' => 'Oficina Central',
                'Email' => 'admin@demo.com',
                'Usuario' => 'admin',
                'Contraseña' => Hash::make('admin123'),
                'Activo' => true,
            ],
            [
                'Cedula' => 987654321,
                'Nombre' => 'Usuario',
                'Apellido' => 'Prueba',
                'Direccion' => 'Calle Test 456',
                'Email' => 'user@test.com',
                'Usuario' => 'user',
                'Contraseña' => Hash::make('user123'),
                'Activo' => true,
            ],
            [
                'Cedula' => 1102345678,
                'Nombre' => 'María',
                'Apellido' => 'Pérez',
                'Direccion' => 'Av. Siempre Viva 123',
                'Email' => 'maria.perez@example.com',
                'Usuario' => 'maria.perez',
                'Contraseña' => Hash::make('password123'),
                'Activo' => true,
            ],
            [
                'Cedula' => 1103456789,
                'Nombre' => 'José',
                'Apellido' => 'Ramírez',
                'Direccion' => 'Calle Los Pinos 456',
                'Email' => 'jose.ramirez@example.com',
                'Usuario' => 'jose.ramirez',
                'Contraseña' => Hash::make('password123'),
                'Activo' => true,
            ],
            [
                'Cedula' => 1104567890,
                'Nombre' => 'Ana',
                'Apellido' => 'Fernández',
                'Direccion' => 'Barrio La Pradera',
                'Email' => 'ana.fernandez@example.com',
                'Usuario' => 'ana.fernandez',
                'Contraseña' => Hash::make('password123'),
                'Activo' => false,
            ],
            [
                'Cedula' => 1105678901,
                'Nombre' => 'Pedro',
                'Apellido' => 'López',
                'Direccion' => 'Av. Quito 789',
                'Email' => 'pedro.lopez@example.com',
                'Usuario' => 'pedro.lopez',
                'Contraseña' => Hash::make('password123'),
                'Activo' => true,
            ],
            [
                'Cedula' => 1106789012,
                'Nombre' => 'Sofía',
                'Apellido' => 'Martínez',
                'Direccion' => 'Colinas del Sur',
                'Email' => 'sofia.martinez@example.com',
                'Usuario' => 'sofia.martinez',
                'Contraseña' => Hash::make('password123'),
                'Activo' => false,
            ],
            [
                'Cedula' => 1107890123,
                'Nombre' => 'Ricardo',
                'Apellido' => 'Díaz',
                'Direccion' => 'Ciudad Jardín 23',
                'Email' => 'ricardo.diaz@example.com',
                'Usuario' => 'ricardo.diaz',
                'Contraseña' => Hash::make('password123'),
                'Activo' => true,
            ],
            [
                'Cedula' => 1108901234,
                'Nombre' => 'Carla',
                'Apellido' => 'Mendoza',
                'Direccion' => 'Centro Histórico',
                'Email' => 'carla.mendoza@example.com',
                'Usuario' => 'carla.mendoza',
                'Contraseña' => Hash::make('password123'),
                'Activo' => false,
            ],
            [
                'Cedula' => 1109012345,
                'Nombre' => 'Diego',
                'Apellido' => 'Ortega',
                'Direccion' => 'Av. Las Palmeras',
                'Email' => 'diego.ortega@example.com',
                'Usuario' => 'diego.ortega',
                'Contraseña' => Hash::make('password123'),
                'Activo' => true,
            ],
            [
                'Cedula' => 1110123456,
                'Nombre' => 'Elena',
                'Apellido' => 'Vásquez',
                'Direccion' => 'Urbanización Santa Fe',
                'Email' => 'elena.vasquez@example.com',
                'Usuario' => 'elena.vasquez',
                'Contraseña' => Hash::make('password123'),
                'Activo' => false,
            ],
            [
                'Cedula' => 1111234567,
                'Nombre' => 'Fernando',
                'Apellido' => 'González',
                'Direccion' => 'Residencial La Fuente',
                'Email' => 'fernando.gonzalez@example.com',
                'Usuario' => 'fernando.gonzalez',
                'Contraseña' => Hash::make('password123'),
                'Activo' => true,
            ],
            [
                'Cedula' => 1112345678,
                'Nombre' => 'Gabriela',
                'Apellido' => 'Ríos',
                'Direccion' => 'Parque Industrial',
                'Email' => 'gabriela.rios@example.com',
                'Usuario' => 'gabriela.rios',
                'Contraseña' => Hash::make('password123'),
                'Activo' => false,
            ],
        ];

        foreach ($usuarios as $data) {
            User::updateOrCreate(
                ['Cedula' => $data['Cedula']],
                $data
            );
        }

        // Asignar roles a algunos usuarios
        $userRoles = [
            ['cedula_usuario' => 123456789, 'id_rol' => 1], // Admin - Administrador
            ['cedula_usuario' => 987654321, 'id_rol' => 2], // User - Usuario
            ['cedula_usuario' => 1102345678, 'id_rol' => 1], // María - Administrador
            ['cedula_usuario' => 1103456789, 'id_rol' => 2], // José - Usuario
            ['cedula_usuario' => 1105678901, 'id_rol' => 2], // Pedro - Usuario
            ['cedula_usuario' => 1107890123, 'id_rol' => 2], // Ricardo - Usuario
            ['cedula_usuario' => 1109012345, 'id_rol' => 2], // Diego - Usuario
            ['cedula_usuario' => 1111234567, 'id_rol' => 3], // Fernando - Invitado
        ];

        foreach ($userRoles as $userRole) {
            DB::table('USUARIO_ROLES')->insert([
                'cedula_usuario' => $userRole['cedula_usuario'],
                'id_rol' => $userRole['id_rol'],
                'fecha_asignacion' => now(),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
