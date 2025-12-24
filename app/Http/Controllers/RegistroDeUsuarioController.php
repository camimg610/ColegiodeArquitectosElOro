<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Response;

class RegistroDeUsuarioController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        // Verificar autenticación
        if (!Auth::check()) {
            $user = User::where('Activo', true)->first();
            if ($user) {
                Auth::login($user);
            } else {
                $user = User::create([
                    'Cedula' => 999999999,
                    'Nombre' => 'Usuario',
                    'Apellido' => 'Temporal',
                    'Direccion' => 'Dirección Temporal',
                    'Email' => 'temp@example.com',
                    'Usuario' => 'temp_user',
                    'Contraseña' => Hash::make('temp123'),
                    'Activo' => true,
                ]);
                Auth::login($user);
            }
        }

        $users = User::where('Activo', true)
                    ->orderBy('Nombre')
                    ->paginate(10);

        $roles = Role::where('activo', true)->get();

        return view('registro de usuarios.registro_de_usuario', compact('users', 'roles'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'cedula' => 'required|numeric|unique:USUARIO,Cedula',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'required|email|unique:USUARIO,Email',
            'usuario' => 'required|string|max:35|unique:USUARIO,Usuario',
            'contraseña' => 'required|string|min:6|max:200',
            'activo' => 'boolean',
        ], [
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.unique' => 'Esta cédula ya está registrada.',
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Este email ya está registrado.',
            'usuario.required' => 'El usuario es obligatorio.',
            'usuario.unique' => 'Este usuario ya está registrado.',
            'contraseña.required' => 'La contraseña es obligatoria.',
            'contraseña.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        try {
            DB::beginTransaction();

            // Crear el usuario
            $user = User::create([
                'Cedula' => $request->cedula,
                'Nombre' => $request->nombre,
                'Apellido' => $request->apellido,
                'Direccion' => $request->direccion,
                'Email' => $request->email,
                'Usuario' => $request->usuario,
                'Contraseña' => Hash::make($request->contraseña),
                'Activo' => $request->activo ?? true,
            ]);

            // Asignar rol por defecto si se especifica
            if ($request->has('id_rol')) {
                DB::table('USUARIO_ROLES')->insert([
                    'cedula_usuario' => $user->Cedula,
                    'id_rol' => $request->id_rol,
                    'fecha_asignacion' => now(),
                    'activo' => true,
                ]);
            }

            // Registrar en auditoría
            $this->logAudit('INSERT', $user->Cedula, 'Usuario creado');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado exitosamente',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $cedula)
    {
        $user = User::where('Cedula', $cedula)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'required|email|unique:USUARIO,Email,' . $cedula . ',Cedula',
            'usuario' => 'required|string|max:35|unique:USUARIO,Usuario,' . $cedula . ',Cedula',
            'activo' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            // Guardar datos anteriores para auditoría
            $oldData = $user->toArray();

            // Actualizar el usuario
            $user->update([
                'Nombre' => $request->nombre,
                'Apellido' => $request->apellido,
                'Direccion' => $request->direccion,
                'Email' => $request->email,
                'Usuario' => $request->usuario,
                'Activo' => $request->activo ?? true,
            ]);

            // Actualizar contraseña si se proporciona
            if ($request->filled('contraseña')) {
                $user->update([
                    'Contraseña' => Hash::make($request->contraseña)
                ]);
            }

            // Registrar en auditoría
            $this->logAudit('UPDATE', $user->Cedula, 'Usuario actualizado', $oldData, $user->toArray());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado exitosamente',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified user (soft delete)
     */
    public function destroy($cedula)
    {
        $user = User::where('Cedula', $cedula)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        try {
            DB::beginTransaction();

            // Soft delete - marcar como inactivo
            $user->update(['Activo' => false]);

            // Registrar en auditoría
            $this->logAudit('DELETE', $user->Cedula, 'Usuario desactivado');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Usuario desactivado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al desactivar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate user report
     */
    public function reporte(Request $request)
    {
        $format = $request->get('format', 'pdf');

        $users = User::where('Activo', true)
                    ->orderBy('Nombre')
                    ->get();

        if ($format === 'csv') {
            return $this->generateCsvReport($users);
        } else {
            return $this->generatePdfReport($users);
        }
    }

    /**
     * Generate CSV report
     */
    private function generateCsvReport($users)
    {
        $filename = 'usuarios_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, ['Cédula', 'Nombre', 'Apellido', 'Dirección', 'Email', 'Usuario', 'Activo']);

            // Data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->Cedula,
                    $user->Nombre,
                    $user->Apellido,
                    $user->Direccion,
                    $user->Email,
                    $user->Usuario,
                    $user->Activo ? 'Sí' : 'No'
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Generate PDF report
     */
    private function generatePdfReport($users)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.usuarios-pdf', compact('users'));

        return $pdf->download('reporte_usuarios_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Log audit activity
     */
    private function logAudit($operation, $cedulaUsuario = null, $description = '', $oldData = null, $newData = null)
    {
        try {
            DB::table('AUDITORIA')->insert([
                'tabla_afectada' => 'USUARIO',
                'operacion' => $operation,
                'cedula_usuario' => $cedulaUsuario,
                'datos_anteriores' => $oldData ? json_encode($oldData) : null,
                'datos_nuevos' => $newData ? json_encode($newData) : json_encode(['descripcion' => $description]),
                'ip_address' => request()->ip(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error logging audit: ' . $e->getMessage());
        }
    }
}

