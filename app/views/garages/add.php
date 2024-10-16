<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cochera</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 500px;
        }
        h1 {
            text-align: center;
        }
        input[type="text"],
        input[type="file"],
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Agregar Cochera</h1>

    <!-- Mensaje de error si existe -->
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="/addGarage" method="post" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Nombre de Cochera" required>
        <input type="text" name="espacio" placeholder="Espacio (m²)" required>
        <input type="text" name="tipo_vehiculo_aceptado" placeholder="Tipo de Vehículo Aceptado" required>
        <input type="text" name="ubicacion" placeholder="Ubicación" required>
        <input type="text" name="latitud" placeholder="Latitud" required>
        <input type="text" name="longitud" placeholder="Longitud" required>
        <input type="file" name="imagenes[]" multiple>
        <button type="submit">Agregar Cochera</button>
    </form>
</body>
</html>
