<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inscripciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #D7A643;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #D7A643;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section h3 {
            color: #D7A643;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #D7A643;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-active {
            color: #28a745;
            font-weight: bold;
        }
        .status-inactive {
            color: #dc3545;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .summary h4 {
            color: #D7A643;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Inscripciones</h1>
        <p>Sistema de Gestión de Eventos y Alquileres</p>
        <p>Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <h4>Resumen del Reporte</h4>
        <p><strong>Total de inscripciones:</strong> {{ $inscripciones->count() }}</p>
        <p><strong>Inscripciones activas:</strong> {{ $inscripciones->where('activo', true)->count() }}</p>
        <p><strong>Inscripciones inactivas:</strong> {{ $inscripciones->where('activo', false)->count() }}</p>
        <p><strong>Total de participantes:</strong> {{ $inscripciones->sum('cantidad_participantes') }}</p>
    </div>

    <div class="info-section">
        <h3>Lista de Inscripciones</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Evento</th>
                    <th>Participante</th>
                    <th>Cantidad</th>
                    <th>Fecha Inscripción</th>
                    <th>Estado</th>
                    <th>Fecha Creación</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscripciones as $index => $inscripcion)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $inscripcion->id_inscripcion }}</td>
                    <td>{{ $inscripcion->evento ? $inscripcion->evento->nombre_evento : 'N/A' }}</td>
                    <td>{{ $inscripcion->usuario ? $inscripcion->usuario->Nombre . ' ' . $inscripcion->usuario->Apellido : 'N/A' }}</td>
                    <td>{{ $inscripcion->cantidad_participantes ?: 'N/A' }}</td>
                    <td>{{ $inscripcion->fecha_inscripcion ? \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y') : 'N/A' }}</td>
                    <td class="{{ $inscripcion->activo ? 'status-active' : 'status-inactive' }}">
                        {{ $inscripcion->activo ? 'Activo' : 'Inactivo' }}
                    </td>
                    <td>{{ $inscripcion->created_at ? $inscripcion->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No hay inscripciones registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Este reporte fue generado automáticamente por el sistema</p>
        <p>Página 1 de 1</p>
    </div>
</body>
</html>
