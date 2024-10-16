<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Cocheras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 800px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <h1>Lista de Cocheras</h1>
    
    <?php if (isset($message)): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Espacio</th>
                <th>Tipo de Vehículo Aceptado</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($garages as $garage): ?>
                <tr>
                    <td><?php echo htmlspecialchars($garage->nombre); ?></td>
                    <td><?php echo htmlspecialchars($garage->espacio); ?> m²</td>
                    <td><?php echo htmlspecialchars($garage->tipo_vehiculo_aceptado); ?></td>
                    <td><?php echo htmlspecialchars($garage->ubicacion); ?></td>
                    <td class="action-buttons">
                        <a href="/editGarage/<?php echo htmlspecialchars($garage->id); ?>">Editar</a>
                        <a href="/activateGarage/<?php echo htmlspecialchars($garage->id); ?>"><?php echo $garage->activo ? 'Desactivar' : 'Activar'; ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="text-align: center; margin-top: 20px;">
        <a href="/addGarage">Agregar Nueva Cochera</a>
    </div>
</body>
</html>
