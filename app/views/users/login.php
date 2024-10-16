<?php
require_once '../../../config/database.php'; // Incluye el archivo de conexión a la base de datos
require_once '../../controllers/UserController.php'; // Incluye el controladors
// Inicia la sesión
session_start();

// Incluye el archivo de conexión a la base de datos
require_once '../../../config/database.php'; 

// Incluye el controlador
require_once '../../controllers/UserController.php'; 

// Crear una nueva instancia de la clase Database
$database = new Database();
$pdo = $database->getConnection(); // Obtener la conexión

// Verificar si la conexión fue exitosa
if (!$pdo) {
    die("No se pudo establecer la conexión a la base de datos.");
}

// Instanciar el controlador con la conexión PDO
$userController = new UserController($pdo);

// Llama al método login solo si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController->login();
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h1 {
            color: #333;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inicio de Sesión</h1>
        <?php if (isset($_GET['error'])): ?>
            <p class="error">Error: Las credenciales son incorrectas.</p>
        <?php endif; ?>
        <form action="" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="clave" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
