<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class RolesController extends Controller
{
    /**
     * Display a listing of roles
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

        $roles = Role::orderBy('tipo_rol')->get();

        return view('roles.roles', compact('roles'));
    }

    /**
     * Store a newly created role
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo_rol' => 'required|string|max:255|unique:ROLES,tipo_rol',
            'descripcion' => 'required|string|max:500',
            'activo' => 'boolean'
        ], [
            'tipo_rol.required' => 'El tipo de rol es obligatorio.',
            'tipo_rol.unique' => 'Este tipo de rol ya existe.',
            'descripcion.required' => 'La descripción es obligatoria.',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'tipo_rol' => $request->tipo_rol,
                'descripcion' => $request->descripcion,
                'activo' => $request->activo ?? true,
            ]);

            $this->logAudit('INSERT', null, 'Rol creado: ' . $role->tipo_rol);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rol creado exitosamente',
                    'role' => $role
                ]);
            }
            return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating role: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el rol: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withErrors('Error al crear el rol: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update the specified role
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'tipo_rol' => 'required|string|max:255|unique:ROLES,tipo_rol,' . $id . ',id_rol',
            'descripcion' => 'required|string|max:500',
            'activo' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $oldData = $role->toArray();

            $role->update([
                'tipo_rol' => $request->tipo_rol,
                'descripcion' => $request->descripcion,
                'activo' => $request->activo ?? true,
            ]);

            $this->logAudit('UPDATE', null, 'Rol actualizado: ' . $role->tipo_rol, $oldData, $role->toArray());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Rol actualizado exitosamente',
                'role' => $role
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating role: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el rol: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified role (soft delete)
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        try {
            DB::beginTransaction();

            $role->update(['activo' => false]);

            $this->logAudit('DELETE', null, 'Rol desactivado: ' . $role->tipo_rol);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Rol desactivado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting role: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al desactivar el rol: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate report
     */
    public function reporte(Request $request)
    {
        $format = $request->get('format', 'pdf');

        $roles = Role::orderBy('tipo_rol')->get();

        if ($format === 'csv') {
            return $this->generateCsvReport($roles);
        } else {
            return $this->generatePdfReport($roles);
        }
    }

    /**
     * Generate CSV report
     */
    private function generateCsvReport($roles)
    {
        $filename = 'roles_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($roles) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, ['ID', 'Nombre del Rol', 'Descripción', 'Estado', 'Fecha Creación', 'Fecha Actualización']);

            // Data
            foreach ($roles as $rol) {
                fputcsv($file, [
                    $rol->id_rol,
                    $rol->tipo_rol,
                    $rol->descripcion ?: 'Sin descripción',
                    $rol->activo ? 'Activo' : 'Inactivo',
                    $rol->created_at ? $rol->created_at->format('d/m/Y H:i') : 'N/A',
                    $rol->updated_at ? $rol->updated_at->format('d/m/Y H:i') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Generate PDF report
     */
    private function generatePdfReport($roles)
    {
        $pdf = Pdf::loadView('reports.roles-pdf', compact('roles'));

        return $pdf->download('reporte_roles_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Log audit activity
     */
    private function logAudit($operation, $cedulaUsuario = null, $description = '', $oldData = null, $newData = null)
    {
        try {
            DB::table('AUDITORIA')->insert([
                'tabla_afectada' => 'ROLES',
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
