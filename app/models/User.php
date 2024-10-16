<?php

class User {
    private $pdo;

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $clave;
    public $vehiculo;
    public $tipo_vehiculo;
    public $patente;
    public $activo;

    public function __construct($pdo, $nombre, $apellido, $email, $clave, $vehiculo, $tipo_vehiculo, $patente, $activo = true) {
        $this->pdo = $pdo;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->clave = password_hash($clave, PASSWORD_BCRYPT);
        $this->vehiculo = $vehiculo;
        $this->tipo_vehiculo = $tipo_vehiculo;
        $this->patente = $patente;
        $this->activo = $activo;
    }

    public function save() {
        $stmt = $this->pdo->prepare("INSERT INTO users (nombre, apellido, email, clave, vehiculo, tipo_vehiculo, patente, activo) VALUES (:nombre, :apellido, :email, :clave, :vehiculo, :tipo_vehiculo, :patente, :activo)");
        return $stmt->execute([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'email' => $this->email,
            'clave' => $this->clave,
            'vehiculo' => $this->vehiculo,
            'tipo_vehiculo' => $this->tipo_vehiculo,
            'patente' => $this->patente,
            'activo' => $this->activo
        ]);
    }

    public function update() {
        $stmt = $this->pdo->prepare("UPDATE users SET nombre = :nombre, apellido = :apellido, email = :email, vehiculo = :vehiculo, tipo_vehiculo = :tipo_vehiculo, patente = :patente, activo = :activo WHERE id = :id");
        return $stmt->execute([
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'email' => $this->email,
            'vehiculo' => $this->vehiculo,
            'tipo_vehiculo' => $this->tipo_vehiculo,
            'patente' => $this->patente,
            'activo' => $this->activo
        ]);
    }

    public function deactivate() {
        $this->activo = false;
        $this->update(); // Actualiza el estado en la base de datos
    }

    public static function findById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(self::class, [$pdo]);
    }

    public static function findByEmail($pdo, $email) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchObject(self::class, [$pdo]);
    }

    public static function all($pdo) {
        $stmt = $pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class, [$pdo]);
    }

    public function validate() {
        return !empty($this->nombre) && !empty($this->apellido) && !empty($this->email) && !empty($this->clave);
    }
}
