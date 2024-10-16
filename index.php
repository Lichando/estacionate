<?php

session_start(); // Iniciar sesión

require_once 'config/database.php';
require_once 'config/routes.php';
require_once 'config/config.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Manejar las rutas
routes();
