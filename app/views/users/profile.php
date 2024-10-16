<?php
session_start();
require_once '../../../config/database.php';
require_once '../../controllers/UserController.php';
require_once '../../controllers/ReservationController.php';

$database = new Database();
$pdo = $database->getConnection();

$userController = new UserController($pdo);
$reservationController = new ReservationController($pdo);

$userId = $_SESSION['user_id'] ?? null;

if ($userId) {
    $user = $userController->getUserProfile($userId);
    if (!$user) {
        header('Location: error.php');
        exit;
    }

    $reservations = $reservationController->listReservations($userId);
} else {
    header('Location: login.php');
    exit;
}

$currentDate = date('l, j \d\e F \d\e Y');
$currentTime = date('H:i');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { background: #f2f2f2; padding: 10px; text-align: center; }
        .sidebar { width: 200px; float: left; padding: 10px; background: #e7e7e7; }
        .content { margin-left: 220px; padding: 10px; }
        .button { margin-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo htmlspecialchars($user['nombre']); ?></h1>
        <p><?php echo $currentDate; ?> - <?php echo $currentTime; ?></p>
        <a href="../reservations/reserve.php" class="button">Solicitar Nueva Reserva</a>
    </div>

    <div class="sidebar">
        <h3>Menu</h3>
        <ul>
            <li><a href="reservas.php">Mis Reservas</a></li>
            <li><a href="datos.php">Mis Datos</a></li>
        </ul>
        <button onclick="location.href='logout.php'">Salir</button>
    </div>

    <div class="content">
        <h2>Mis Reservas</h2>
        <?php if (!empty($reservations)): ?>
            <ul>
                <?php foreach ($reservations as $reservation): ?>
                    <li>
                        Reserva ID: <?php echo htmlspecialchars($reservation['id']); ?> - 
                        Fecha: <?php echo htmlspecialchars($reservation['fecha_reserva']); ?> - 
                        Duración: <?php echo htmlspecialchars($reservation['duracion']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No tienes reservas realizadas.</p>
        <?php endif; ?>
    </div>
</body>
</html>
