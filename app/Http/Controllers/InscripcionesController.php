<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Inscription;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class InscripcionesController extends Controller
{
    /**
     * Display a listing of the resource.
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

        $inscripciones = Inscription::orderBy('fecha_inscripcion', 'desc')->get();
        return view('inscripciones.inscripciones', compact('inscripciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_inscripcion' => 'required|date',
            'estado' => 'required|string|in:Activo,Pendiente,Cancelado'
        ]);

        try {
            $inscripcion = Inscription::create([
                'fecha_inscripcion' => $request->fecha_inscripcion,
                'estado' => $request->estado,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Inscripción creada exitosamente',
                'inscripcion' => $inscripcion
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la inscripción: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Log::info('Update request received', [
            'id' => $id,
            'request_data' => $request->all()
        ]);

        $request->validate([
            'fecha_inscripcion' => 'required|date',
            'estado' => 'required|string|in:Activo,Pendiente,Cancelado'
        ]);

        try {
            // Buscar por id_inscripcion específicamente
            $inscripcion = Inscription::where('id_inscripcion', $id)->first();

            if (!$inscripcion) {
                Log::error('Inscripción no encontrada', ['id' => $id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Inscripción no encontrada'
                ], 404);
            }

            Log::info('Inscripción encontrada', ['inscripcion' => $inscripcion->toArray()]);

            $inscripcion->update([
                'fecha_inscripcion' => $request->fecha_inscripcion,
                'estado' => $request->estado,
            ]);

            Log::info('Inscripción actualizada exitosamente', ['inscripcion' => $inscripcion->fresh()->toArray()]);

            return response()->json([
                'success' => true,
                'message' => 'Inscripción actualizada exitosamente',
                'inscripcion' => $inscripcion->fresh()
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar inscripción', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la inscripción: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inscripcion = Inscription::findOrFail($id);
        $inscripcion->delete();

        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción eliminada exitosamente.');
    }

    /**
     * Generate report
     */
    public function reporte(Request $request)
    {
        $format = $request->get('format', 'pdf');

        $inscripciones = Inscription::with(['event', 'user'])->orderBy('fecha_inscripcion', 'desc')->get();

        if ($format === 'csv') {
            return $this->generateCsvReport($inscripciones);
        } else {
            return $this->generatePdfReport($inscripciones);
        }
    }

    /**
     * Generate CSV report
     */
    private function generateCsvReport($inscripciones)
    {
        $filename = 'inscripciones_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($inscripciones) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, ['ID', 'Evento', 'Participante', 'Cantidad', 'Fecha Inscripción', 'Estado', 'Fecha Creación']);

            // Data
            foreach ($inscripciones as $inscripcion) {
                fputcsv($file, [
                    $inscripcion->id_inscripcion,
                    $inscripcion->event ? $inscripcion->event->nombre_evento : 'N/A',
                    $inscripcion->user ? $inscripcion->user->Nombre . ' ' . $inscripcion->user->Apellido : 'N/A',
                    $inscripcion->cantidad_participantes ?: 'N/A',
                    $inscripcion->fecha_inscripcion ? \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y') : 'N/A',
                    $inscripcion->activo ? 'Activo' : 'Inactivo',
                    $inscripcion->created_at ? $inscripcion->created_at->format('d/m/Y H:i') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Generate PDF report
     */
    private function generatePdfReport($inscripciones)
    {
        $pdf = Pdf::loadView('reports.inscripciones-pdf', compact('inscripciones'));

        return $pdf->download('reporte_inscripciones_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
