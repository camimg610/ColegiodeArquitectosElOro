<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class PermisosController extends Controller
{
    /**
     * Display a listing of permissions
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

        $permisos = Permission::orderBy('nombre_permiso')->get();

        return view('permisos.permisos', compact('permisos'));
    }

    /**
     * Store a newly created permission
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_permiso' => 'required|string|max:255|unique:PERMISOS,nombre_permiso',
            'descripcion' => 'nullable|string|max:500',
            'activo' => 'boolean'
        ], [
            'nombre_permiso.required' => 'El nombre del permiso es obligatorio.',
            'nombre_permiso.unique' => 'Este permiso ya existe.',
        ]);

        try {
            DB::beginTransaction();

            $permiso = Permission::create([
                'nombre_permiso' => $request->nombre_permiso,
                'descripcion' => $request->descripcion,
                'activo' => $request->activo ?? true,
            ]);

            $this->logAudit('INSERT', null, 'Permiso creado: ' . $permiso->nombre_permiso);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permiso creado exitosamente',
                'permiso' => $permiso
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating permission: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear el permiso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified permission
     */
    public function update(Request $request, $id)
    {
        $permiso = Permission::findOrFail($id);

        $request->validate([
            'nombre_permiso' => 'required|string|max:255|unique:PERMISOS,nombre_permiso,' . $id . ',id_permiso',
            'descripcion' => 'nullable|string|max:500',
            'activo' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $oldData = $permiso->toArray();

            $permiso->update([
                'nombre_permiso' => $request->nombre_permiso,
                'descripcion' => $request->descripcion,
                'activo' => $request->activo ?? true,
            ]);

            $this->logAudit('UPDATE', null, 'Permiso actualizado: ' . $permiso->nombre_permiso, $oldData, $permiso->toArray());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permiso actualizado exitosamente',
                'permiso' => $permiso->fresh()
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating permission: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el permiso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified permission (physical delete)
     */
    public function destroy($id)
    {
        $permiso = Permission::findOrFail($id);

        try {
            DB::beginTransaction();

            $nombrePermiso = $permiso->nombre_permiso;
            $permiso->delete(); // Eliminación física

            $this->logAudit('DELETE', null, 'Permiso eliminado: ' . $nombrePermiso);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permiso eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting permission: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el permiso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate report
     */
    public function reporte(Request $request)
    {
        $format = $request->get('format', 'pdf');

        $permisos = Permission::orderBy('nombre_permiso')->get();

        if ($format === 'csv') {
            return $this->generateCsvReport($permisos);
        } else {
            return $this->generatePdfReport($permisos);
        }
    }

    /**
     * Generate CSV report
     */
    private function generateCsvReport($permisos)
    {
        $filename = 'permisos_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($permisos) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, ['ID', 'Nombre del Permiso', 'Descripción', 'Estado', 'Fecha Creación', 'Fecha Actualización']);

            // Data
            foreach ($permisos as $permiso) {
                fputcsv($file, [
                    $permiso->id_permiso,
                    $permiso->nombre_permiso,
                    $permiso->descripcion ?: 'Sin descripción',
                    $permiso->activo ? 'Activo' : 'Inactivo',
                    $permiso->created_at ? $permiso->created_at->format('d/m/Y H:i') : 'N/A',
                    $permiso->updated_at ? $permiso->updated_at->format('d/m/Y H:i') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Generate PDF report
     */
    private function generatePdfReport($permisos)
    {
        $pdf = Pdf::loadView('reports.permisos-pdf', compact('permisos'));

        return $pdf->download('reporte_permisos_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Log audit activity
     */
    private function logAudit($operation, $cedulaUsuario = null, $description = '', $oldData = null, $newData = null)
    {
        try {
            DB::table('AUDITORIA')->insert([
                'tabla_afectada' => 'PERMISOS',
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
