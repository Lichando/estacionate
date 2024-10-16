<?php
require_once '../../../config/database.php';
require_once '../../controllers/UserController.php';

$database = new Database();
$pdo = $database->getConnection();
$userController = new UserController($pdo);

// Llama al método de logout
$userController->logout();
?>
