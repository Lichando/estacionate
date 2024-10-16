<?php

class Garage {
    private $pdo;

    public $id;
    public $nombre;
    public $espacio;
    public $tipo_vehiculo_aceptado;
    public $ubicacion;
    public $latitud;
    public $longitud;
    public $imagenes;
    public $activo;  // Este campo indicará si la cochera está activa o no
    public $dueño_id;

    public function __construct($pdo, $nombre, $espacio, $tipo_vehiculo_aceptado, $ubicacion, $latitud, $longitud, $imagenes, $dueño_id, $activo = true) {
        $this->pdo = $pdo;
        $this->nombre = $nombre;
        $this->espacio = $espacio;
        $this->tipo_vehiculo_aceptado = $tipo_vehiculo_aceptado;
        $this->ubicacion = $ubicacion;
        $this->latitud = $latitud;
        $this->longitud = $longitud;
        $this->imagenes = $imagenes;
        $this->dueño_id = $dueño_id;
        $this->activo = $activo;
    }

    public function save() {
        $stmt = $this->pdo->prepare("INSERT INTO garages (nombre, espacio, tipo_vehiculo_aceptado, ubicacion, latitud, longitud, imagenes, dueño_id, activo) VALUES (:nombre, :espacio, :tipo_vehiculo_aceptado, :ubicacion, :latitud, :longitud, :imagenes, :dueño_id, :activo)");
        return $stmt->execute([
            'nombre' => $this->nombre,
            'espacio' => $this->espacio,
            'tipo_vehiculo_aceptado' => $this->tipo_vehiculo_aceptado,
            'ubicacion' => $this->ubicacion,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'imagenes' => $this->imagenes,
            'dueño_id' => $this->dueño_id,
            'activo' => $this->activo
        ]);
    }

    public function update() {
        $stmt = $this->pdo->prepare("UPDATE garages SET nombre = :nombre, espacio = :espacio, tipo_vehiculo_aceptado = :tipo_vehiculo_aceptado, ubicacion = :ubicacion, latitud = :latitud, longitud = :longitud, imagenes = :imagenes, activo = :activo WHERE id = :id");
        return $stmt->execute([
            'id' => $this->id,
            'nombre' => $this->nombre,
            'espacio' => $this->espacio,
            'tipo_vehiculo_aceptado' => $this->tipo_vehiculo_aceptado,
            'ubicacion' => $this->ubicacion,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'imagenes' => $this->imagenes,
            'activo' => $this->activo
        ]);
    }

    public function deactivate() {
        $this->activo = false;
        $this->update(); // Actualiza el registro en la base de datos
    }

    public function validate() {
        return !empty($this->nombre) && !empty($this->espacio) && !empty($this->ubicacion);
    }

    public static function findById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM garages WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(self::class, [$pdo]);
    }

    public static function all($pdo) {
        $stmt = $pdo->query("SELECT * FROM garages WHERE activo = 1"); // Solo las cocheras activas
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class, [$pdo]);
    }
}
