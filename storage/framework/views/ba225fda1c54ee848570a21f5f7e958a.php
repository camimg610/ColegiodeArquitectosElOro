<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Alquileres</title>
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
        <h1>Reporte de Alquileres</h1>
        <p>Sistema de Gestión de Eventos y Alquileres</p>
        <p>Generado el: <?php echo e(now()->format('d/m/Y H:i:s')); ?></p>
    </div>

    <div class="summary">
        <h4>Resumen del Reporte</h4>
        <p><strong>Total de alquileres:</strong> <?php echo e($alquileres->count()); ?></p>
        <p><strong>Alquileres activos:</strong> <?php echo e($alquileres->where('activo', true)->count()); ?></p>
        <p><strong>Alquileres inactivos:</strong> <?php echo e($alquileres->where('activo', false)->count()); ?></p>
        <p><strong>Total de salones alquilados:</strong> <?php echo e($alquileres->sum('cantidad_salones')); ?></p>
    </div>

    <div class="info-section">
        <h3>Lista de Alquileres</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Salón</th>
                    <th>Cantidad</th>
                    <th>Fecha Alquiler</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Estado</th>
                    <th>Fecha Creación</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $alquileres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $alquiler): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($alquiler->id_alquiler); ?></td>
                    <td>
                        <?php if(isset($alquiler->user) && $alquiler->user): ?>
                            <?php echo e($alquiler->user->Nombre ?? ''); ?> <?php echo e($alquiler->user->Apellido ?? ''); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(isset($alquiler->salon_detalle) && $alquiler->salon_detalle): ?>
                            <?php echo e($alquiler->salon_detalle->nombre ?? ''); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td><?php echo e(isset($alquiler->cantidad_salones) && $alquiler->cantidad_salones ? $alquiler->cantidad_salones : 'N/A'); ?></td>
                    <td><?php echo e(isset($alquiler->fecha) && $alquiler->fecha ? \Carbon\Carbon::parse($alquiler->fecha)->format('d/m/Y') : 'N/A'); ?></td>
                    <td><?php echo e(isset($alquiler->hora_inicio) && $alquiler->hora_inicio ? $alquiler->hora_inicio : 'N/A'); ?></td>
                    <td><?php echo e(isset($alquiler->hora_fin) && $alquiler->hora_fin ? $alquiler->hora_fin : 'N/A'); ?></td>
                    <td class="<?php echo e(isset($alquiler->activo) && $alquiler->activo ? 'status-active' : 'status-inactive'); ?>">
                        <?php echo e(isset($alquiler->activo) && $alquiler->activo ? 'Activo' : 'Inactivo'); ?>

                    </td>
                    <td><?php echo e(isset($alquiler->created_at) && $alquiler->created_at ? $alquiler->created_at->format('d/m/Y H:i') : 'N/A'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="10" style="text-align: center;">No hay alquileres registrados</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Este reporte fue generado automáticamente por el sistema</p>
        <p>Página 1 de 1</p>
    </div>
</body>
</html>
<?php /**PATH E:\SEmestre pasado\Disco-cami\Proj_ppi_02\Proj_ppi_01\resources\views/reports/alquileres-pdf.blade.php ENDPATH**/ ?>