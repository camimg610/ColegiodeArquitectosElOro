<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Usuarios</title>
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
        <h1>Reporte de Usuarios</h1>
        <p>Sistema de Gestión de Eventos y Alquileres</p>
        <p>Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <h4>Resumen del Reporte</h4>
        <p><strong>Total de usuarios:</strong> {{ $users->count() }}</p>
        <p><strong>Usuarios activos:</strong> {{ $users->where('Activo', true)->count() }}</p>
        <p><strong>Usuarios inactivos:</strong> {{ $users->where('Activo', false)->count() }}</p>
    </div>

    <div class="info-section">
        <h3>Lista de Usuarios</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->Cedula }}</td>
                    <td>{{ $user->Nombre }}</td>
                    <td>{{ $user->Apellido }}</td>
                    <td>{{ $user->Email }}</td>
                    <td>{{ $user->Usuario }}</td>
                    <td class="{{ $user->Activo ? 'status-active' : 'status-inactive' }}">
                        {{ $user->Activo ? 'Activo' : 'Inactivo' }}
                    </td>
                    <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No hay usuarios registrados</td>
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
