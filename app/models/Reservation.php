<?php

class Reservation {
    private $pdo;

    public $id;
    public $cliente_id;
    public $cochera_id;
    public $fecha_reserva;
    public $duracion;

    public function __construct($pdo, $cliente_id, $cochera_id, $fecha_reserva, $duracion) {
        $this->pdo = $pdo;
        $this->cliente_id = $cliente_id;
        $this->cochera_id = $cochera_id;
        $this->fecha_reserva = $fecha_reserva;
        $this->duracion = $duracion;
    }

    public function save() {
        $stmt = $this->pdo->prepare("INSERT INTO reservations (cliente_id, cochera_id, fecha_reserva, duracion) VALUES (:cliente_id, :cochera_id, :fecha_reserva, :duracion)");
        return $stmt->execute([
            'cliente_id' => $this->cliente_id,
            'cochera_id' => $this->cochera_id,
            'fecha_reserva' => $this->fecha_reserva,
            'duracion' => $this->duracion
        ]);
    }

    public function update() {
        $stmt = $this->pdo->prepare("UPDATE reservations SET cliente_id = :cliente_id, cochera_id = :cochera_id, fecha_reserva = :fecha_reserva, duracion = :duracion WHERE id = :id");
        return $stmt->execute([
            'id' => $this->id,
            'cliente_id' => $this->cliente_id,
            'cochera_id' => $this->cochera_id,
            'fecha_reserva' => $this->fecha_reserva,
            'duracion' => $this->duracion
        ]);
    }

    public function delete() {
        $stmt = $this->pdo->prepare("DELETE FROM reservations WHERE id = :id");
        return $stmt->execute(['id' => $this->id]);
    }

    public static function findById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(self::class, [$pdo]);
    }

    public static function findByUserId($pdo, $userId) {
        $stmt = $pdo->prepare("SELECT * FROM reservations WHERE cliente_id = :cliente_id");
        $stmt->execute(['cliente_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class, [$pdo]);
    }

    public static function all($pdo) {
        $stmt = $pdo->query("SELECT * FROM reservations");
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class, [$pdo]);
    }

    public function validate() {
        return !empty($this->cliente_id) && !empty($this->cochera_id) && !empty($this->fecha_reserva) && !empty($this->duracion);
    }
}
