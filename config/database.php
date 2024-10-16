<?php

class Database {
    private $host = 'localhost'; // Cambia esto según tu configuración
    private $db_name = 'garagemanagement'; // Nombre de tu base de datos
    private $username = 'root'; // Tu usuario de base de datos
    private $password = ''; // Tu contraseña de base de datos
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
    
}
