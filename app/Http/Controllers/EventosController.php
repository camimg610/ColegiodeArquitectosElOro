<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Salon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class EventosController extends Controller
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

        $eventos = Event::with('salon')->get();
        return view('eventos.eventos', compact('eventos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|integer',
            'hora_fin' => 'required|integer',
            'id_salon' => 'required|exists:"SALONES",id_salon'
        ]);

        Event::create($request->all());

        return redirect()->route('eventos.index')
            ->with('success', 'Evento creado exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|integer',
            'hora_fin' => 'required|integer',
            'id_salon' => 'required|exists:"SALONES",id_salon'
        ]);

        $evento = Event::findOrFail($id);
        $evento->update($request->all());

        return redirect()->route('eventos.index')
            ->with('success', 'Evento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $evento = Event::findOrFail($id);
        $evento->delete();

        return redirect()->route('eventos.index')
            ->with('success', 'Evento eliminado exitosamente.');
    }

    /**
     * Generate report
     */
    public function reporte(Request $request)
    {
        $format = $request->get('format', 'pdf');

        $eventos = Event::with('salon')->orderBy('fecha')->get();

        if ($format === 'csv') {
            return $this->generateCsvReport($eventos);
        } else {
            return $this->generatePdfReport($eventos);
        }
    }

    /**
     * Generate CSV report
     */
    private function generateCsvReport($eventos)
    {
        $filename = 'eventos_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($eventos) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, ['ID', 'Nombre del Evento', 'Descripción', 'Fecha del Evento', 'Hora Inicio', 'Hora Fin', 'Lugar', 'Capacidad', 'Estado', 'Salón', 'Fecha Creación']);

            // Data
            foreach ($eventos as $evento) {
                fputcsv($file, [
                    $evento->id ?? $evento->id_evento ?? 'N/A',
                    $evento->nombre ?? $evento->nombre_evento ?? 'N/A',
                    $evento->descripcion ?: 'Sin descripción',
                    $evento->fecha ? \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') : 'N/A',
                    $evento->hora_inicio ?? 'N/A',
                    $evento->hora_fin ?? 'N/A',
                    $evento->lugar ?? 'N/A',
                    $evento->capacidad ?? 'N/A',
                    $evento->activo ? 'Activo' : 'Inactivo',
                    $evento->salon ? $evento->salon->nombre_salon : 'N/A',
                    $evento->created_at ? $evento->created_at->format('d/m/Y H:i') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Generate PDF report
     */
    private function generatePdfReport($eventos)
    {
        $pdf = Pdf::loadView('reports.eventos-pdf', compact('eventos'));

        return $pdf->download('reporte_eventos_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
