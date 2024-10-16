<?php

class UserController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Capturar datos del formulario
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email = $_POST['email'] ?? '';
            $clave = $_POST['clave'] ?? '';
            $vehiculo = $_POST['vehiculo'] ?? '';
            $tipo_vehiculo = $_POST['tipo_vehiculo'] ?? '';
            $patente = $_POST['patente'] ?? '';
    
            // Validación de datos
            $errors = [];
    
            // Verificación de campos obligatorios
            if (empty($nombre) || empty($apellido) || empty($email) || empty($clave) || empty($vehiculo) || empty($patente)) {
                $errors[] = "Todos los campos son obligatorios, excepto 'Tipo de Vehículo'.";
            }
    
            // Validación del email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "El email no es válido.";
            }
    
            // Validación de la contraseña
            if (strlen($clave) < 6) {
                $errors[] = "La contraseña debe tener al menos 6 caracteres.";
            }
    
            // Si hay errores, almacenarlos en la sesión y mostrar la vista de registro
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                include 'register.php?error=1'; // Muestra el formulario con errores
                return; // Termina la ejecución del método
            }
    
            // Hashear la contraseña
            $hashedPassword = password_hash($clave, PASSWORD_BCRYPT);
    
            // Guardar en la base de datos
            if ($this->saveUser($nombre, $apellido, $email, $hashedPassword, $vehiculo, $tipo_vehiculo, $patente)) {
                // Redirigir o mostrar mensaje de éxito
                header('Location: login.php'); // Cambia según tu ruta
                exit;
            } else {
                // Manejar error al guardar
                $_SESSION['errors'] = ["Error al registrar el usuario."];
                include 'register.php?error=1'; // Muestra el formulario con el error
            }
        } else {
            // Mostrar vista de registro
            include 'register.php';
        }
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $clave = $_POST['clave'] ?? '';

            // Lógica para verificar credenciales
            if ($this->verifyCredentials($email, $clave)) {
                // Iniciar sesión y redirigir al usuario
                header('Location: profile.php'); // Cambia según tu ruta
                exit;
            } else {
                 // Redirigir con mensaje de error
                header('Location:login.php?error=1'); // Cambia según tu ruta
                exit;
            }
        } else {
            // Mostrar vista de inicio de sesión
            include 'login.php';
        }
    }
    
    private function verifyCredentials($email, $clave) {
        $stmt = $this->pdo->prepare("SELECT id, clave FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($clave, $user['clave'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }
    

    public function activateUser($userId) {
        // Lógica para activar o desactivar un usuario
        $this->toggleUserStatus($userId);
    }
    public function getUserProfile($id) {
        $stmt = $this->pdo->prepare("SELECT nombre, apellido, email FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para actualizar el perfil del usuario
            $id = $_POST['id'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email = $_POST['email'] ?? '';
    
            // Validación básica
            if (empty($id) || empty($nombre) || empty($apellido) || empty($email)) {
                header('Location: profile.php?error=missing_fields');
                exit;
            }
    
            // Actualizar en la base de datos
            if ($this->updateUser($id, $nombre, $apellido, $email)) {
                // Redirigir o mostrar mensaje de éxito
                header('Location: profile.php?success=1'); // Cambia según tu ruta
                exit;
            } else {
                // Manejar error al actualizar
                header('Location: profile.php?error=update_failed');
                exit;
            }
        } else {
            // Mostrar vista de perfil
            include 'profile.php';
        }
    }
    

    private function saveUser($nombre, $apellido, $email, $clave, $vehiculo, $tipo_vehiculo, $patente) {
        $stmt = $this->pdo->prepare("INSERT INTO users (nombre, apellido, email, clave, vehiculo, tipo_vehiculo, patente) VALUES (:nombre, :apellido, :email, :clave, :vehiculo, :tipo_vehiculo, :patente)");
        return $stmt->execute([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'clave' => $clave,
            'vehiculo' => $vehiculo,
            'tipo_vehiculo' => $tipo_vehiculo,
            'patente' => $patente
        ]);
    }

   
    private function toggleUserStatus($userId) {
        // Alternar el estado del usuario
        $stmt = $this->pdo->prepare("UPDATE users SET activo = NOT activo WHERE id = :id");
        $stmt->execute(['id' => $userId]);
    }

    private function updateUser($id, $nombre, $apellido, $email) {
        $stmt = $this->pdo->prepare("UPDATE users SET nombre = :nombre, apellido = :apellido, email = :email WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email
        ]);
    }
    public function logout() {
        // Destruir la sesión
        session_start();
        $_SESSION = []; // Limpiar todas las variables de sesión
        session_destroy(); // Destruir la sesión
    
        // Redirigir al usuario al login
        header('Location: login.php');
        exit;
    }
    
}
