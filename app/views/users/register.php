<?php
require_once '../../../config/database.php'; // Incluye el archivo de conexión a la base de datos
require_once '../../controllers/UserController.php'; // Incluye el controlador

// Crear una nueva instancia de la clase Database
$database = new Database();
$pdo = $database->getConnection(); // Obtener la conexión

// Verificar si la conexión fue exitosa
if (!$pdo) {
    die("No se pudo establecer la conexión a la base de datos.");
}

// Instanciar el controlador con la conexión PDO
$userController = new UserController($pdo);

// Inicializar variable para errores
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Llama al método register del controlador
    $userController->register();
}

// Manejo de errores almacenados en la sesión
if (!empty($_SESSION['errors'])) {
    $error = implode('<br>', $_SESSION['errors']);
    unset($_SESSION['errors']); // Limpiar errores después de mostrarlos
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Azul claro de fondo */
            color: #003366; /* Azul oscuro para el texto */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            background-color: #e6f7ff; /* Azul suave para el formulario */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Ancho fijo para el formulario */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #b3d1ff; /* Azul claro para bordes */
            border-radius: 4px;
        }

        button {
            background-color: #007bff; /* Azul botón */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3; /* Azul más oscuro en hover */
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div>
        <h1>Registro de Usuario</h1>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="clave" placeholder="Contraseña" required>
            <input type="text" name="vehiculo" placeholder="Vehículo" required>
            <select name="tipo_vehiculo">
                <option value="">Seleccione el tipo de vehículo</option>
                <option value="auto">Auto</option>
                <option value="moto">Moto</option>
                <option value="camioneta">Camioneta</option>
                <option value="camion">Camión</option>
                <option value="bici">Bicicleta</option>
            </select>
            <input type="text" name="patente" placeholder="Patente" required>
            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>
