<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cochera</title>
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
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Editar Cochera</h1>

    <!-- Mensaje de error si existe -->
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="/editGarage" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($garage->id); ?>">
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($garage->nombre); ?>" placeholder="Nombre de Cochera" required>
        <input type="text" name="espacio" value="<?php echo htmlspecialchars($garage->espacio); ?>" placeholder="Espacio (m²)" required>
        <input type="text" name="tipo_vehiculo_aceptado" value="<?php echo htmlspecialchars($garage->tipo_vehiculo_aceptado); ?>" placeholder="Tipo de Vehículo Aceptado" required>
        <input type="text" name="ubicacion" value="<?php echo htmlspecialchars($garage->ubicacion); ?>" placeholder="Ubicación" required>
        <input type="text" name="latitud" value="<?php echo htmlspecialchars($garage->latitud); ?>" placeholder="Latitud" required>
        <input type="text" name="longitud" value="<?php echo htmlspecialchars($garage->longitud); ?>" placeholder="Longitud" required>

        <label for="imagenes">Imágenes (opcional):</label>
        <input type="file" name="imagenes[]" multiple>
        
        <button type="submit">Actualizar Cochera</button>
    </form>
    <a href="/garages">Volver a la lista de cocheras</a>
</body>
</html>
