<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar Cochera</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        form { max-width: 400px; margin: auto; }
        select, input, button { width: 100%; margin: 10px 0; padding: 10px; }
        button { background-color: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>
    <h1>Reservar Cochera</h1>
    <form action="/reserveGarage" method="post">
        <label for="cochera_id">Selecciona Cochera:</label>
        <select name="cochera_id" id="cochera_id" required>
            <!-- Aquí irían las opciones de cocheras disponibles -->
            <?php foreach ($garages as $garage): ?>
                <option value="<?php echo htmlspecialchars($garage['id']); ?>">
                    <?php echo htmlspecialchars($garage['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="fecha_reserva">Fecha y Hora de Reserva:</label>
        <input type="datetime-local" name="fecha_reserva" id="fecha_reserva" required>

        <label for="duracion">Duración (horas):</label>
        <input type="number" name="duracion" id="duracion" placeholder="Duración (horas)" required>

        <button type="submit">Reservar</button>
    </form>
</body>
</html>
