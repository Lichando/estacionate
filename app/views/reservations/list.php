<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Reservas</title>
</head>
<body>
    <h1>Lista de Reservas</h1>
    <table>
        <thead>
            <tr>
                <th>Cochera</th>
                <th>Fecha Reserva</th>
                <th>Duración (horas)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo $reservation->cochera_id; ?></td>
                    <td><?php echo $reservation->fecha_reserva; ?></td>
                    <td><?php echo $reservation->duracion; ?></td>
                    <td>
                        <a href="/cancelReservation/<?php echo $reservation->id; ?>">Cancelar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
