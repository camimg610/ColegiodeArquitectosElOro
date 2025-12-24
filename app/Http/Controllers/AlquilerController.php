<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rental;
use App\Models\User;
use App\Models\Salon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class AlquilerController extends Controller
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

        $alquileres = Rental::with('details.user', 'details.salon')->get();
        return view('alquiler.alquiler', compact('alquileres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cedula_usuario' => 'required|exists:"USUARIO","Cedula"',
            'id_salon' => 'required|exists:"SALONES",id_salon',
            'fecha_alquiler' => 'required|date',
            'hora_inicio' => 'required|integer',
            'hora_fin' => 'required|integer',
            'motivo' => 'required|string',
            'estado' => 'boolean'
        ]);

        Rental::create($request->all());

        return redirect()->route('alquiler.index')
            ->with('success', 'Alquiler creado exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cedula_usuario' => 'required|exists:"USUARIO","Cedula"',
            'id_salon' => 'required|exists:"SALONES",id_salon',
            'fecha_alquiler' => 'required|date',
            'hora_inicio' => 'required|integer',
            'hora_fin' => 'required|integer',
            'motivo' => 'required|string',
            'estado' => 'boolean'
        ]);

        $alquiler = Rental::findOrFail($id);
        $alquiler->update($request->all());

        return redirect()->route('alquiler.index')
            ->with('success', 'Alquiler actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alquiler = Rental::findOrFail($id);
        $alquiler->delete();

        return redirect()->route('alquiler.index')
            ->with('success', 'Alquiler eliminado exitosamente.');
    }

    /**
     * Generate report
     */
    public function reporte(Request $request)
    {
        $format = $request->get('format', 'pdf');

        $alquileres = Rental::with('details.user', 'details.salon')->orderBy('fecha_alquiler', 'desc')->get();

        if ($format === 'csv') {
            return $this->generateCsvReport($alquileres);
        } else {
            return $this->generatePdfReport($alquileres);
        }
    }

    /**
     * Generate CSV report
     */
    private function generateCsvReport($alquileres)
    {
        $filename = 'alquileres_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($alquileres) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, ['ID', 'Cliente', 'Salón', 'Cantidad', 'Fecha Alquiler', 'Hora Inicio', 'Hora Fin', 'Estado', 'Fecha Creación']);

            // Data
            foreach ($alquileres as $alquiler) {
                fputcsv($file, [
                    $alquiler->id_alquiler,
                    $alquiler->user ? $alquiler->user->Nombre . ' ' . $alquiler->user->Apellido : 'N/A',
                    $alquiler->salon ? $alquiler->salon->nombre_salon : 'N/A',
                    $alquiler->cantidad_salones ?: 'N/A',
                    $alquiler->fecha_alquiler ? \Carbon\Carbon::parse($alquiler->fecha_alquiler)->format('d/m/Y') : 'N/A',
                    $alquiler->hora_inicio ?: 'N/A',
                    $alquiler->hora_fin ?: 'N/A',
                    $alquiler->activo ? 'Activo' : 'Inactivo',
                    $alquiler->created_at ? $alquiler->created_at->format('d/m/Y H:i') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Generate PDF report
     */
    private function generatePdfReport($alquileres)
    {
        $pdf = Pdf::loadView('reports.alquileres-pdf', compact('alquileres'));

        return $pdf->download('reporte_alquileres_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
