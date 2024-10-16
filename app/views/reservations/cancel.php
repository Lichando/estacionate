<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cancelar Reserva</title>
</head>
<body>
    <h1>Cancelar Reserva</h1>
    <p>¿Estás seguro de que deseas cancelar esta reserva?</p>
    <form action="/cancelReservation" method="post">
        <input type="hidden" name="reservation_id" value="<?php echo $reservation->id; ?>">
        <button type="submit">Confirmar Cancelación</button>
    </form>
    <a href="/reservations">Volver a la lista de reservas</a>
</body>
</html>
