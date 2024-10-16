<?php

class GarageController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addGarage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validación de datos
            $nombre = $_POST['nombre'] ?? '';
            $espacio = $_POST['espacio'] ?? '';
            $tipo_vehiculo_aceptado = $_POST['tipo_vehiculo_aceptado'] ?? '';
            $ubicacion = $_POST['ubicacion'] ?? '';
            $latitud = $_POST['latitud'] ?? '';
            $longitud = $_POST['longitud'] ?? '';
            $imagenes = $_FILES['imagenes'] ?? null;

            // Validaciones simples
            if (empty($nombre) || empty($espacio) || empty($tipo_vehiculo_aceptado) || empty($ubicacion)) {
                echo "Todos los campos son obligatorios.";
                return;
            }

            // Guardar en la base de datos
            $this->saveGarage($nombre, $espacio, $tipo_vehiculo_aceptado, $ubicacion, $latitud, $longitud, $imagenes);

            // Redirigir o mostrar mensaje de éxito
            header('Location: /garages');
            exit;
        } else {
            // Mostrar vista para agregar cochera
            include 'views/garages/add.php';
        }
    }

    public function editGarage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validación de datos
            $id = $_POST['id'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $espacio = $_POST['espacio'] ?? '';
            $tipo_vehiculo_aceptado = $_POST['tipo_vehiculo_aceptado'] ?? '';
            $ubicacion = $_POST['ubicacion'] ?? '';
            $latitud = $_POST['latitud'] ?? '';
            $longitud = $_POST['longitud'] ?? '';
            $imagenes = $_FILES['imagenes'] ?? null;

            // Actualizar en la base de datos
            $this->updateGarage($id, $nombre, $espacio, $tipo_vehiculo_aceptado, $ubicacion, $latitud, $longitud, $imagenes);

            // Redirigir o mostrar mensaje de éxito
            header('Location: /garages');
            exit;
        } else {
            // Cargar la cochera desde la base de datos
            $garageId = $_GET['id'] ?? '';
            $garage = $this->getGarageById($garageId);

            // Incluir la vista de edición
            include 'views/garages/edit.php';
        }
    }

    public function listGarages() {
        // Lógica para listar las cocheras disponibles
        $garages = $this->getAllGarages();
        include 'views/garages/list.php';
    }

    public function activateGarage($garageId) {
        // Lógica para activar o desactivar una cochera
        $this->toggleGarageStatus($garageId);
        header('Location: /garages');
        exit;
    }

    private function getGarageById($garageId): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM garages WHERE id = :id");
        $stmt->execute(['id' => $garageId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function getAllGarages(): array {
        $stmt = $this->pdo->query("SELECT * FROM garages");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function saveGarage($nombre, $espacio, $tipo_vehiculo_aceptado, $ubicacion, $latitud, $longitud, $imagenes) {
        $stmt = $this->pdo->prepare("INSERT INTO garages (nombre, espacio, tipo_vehiculo_aceptado, ubicacion, latitud, longitud) VALUES (:nombre, :espacio, :tipo_vehiculo_aceptado, :ubicacion, :latitud, :longitud)");
        $stmt->execute([
            'nombre' => $nombre,
            'espacio' => $espacio,
            'tipo_vehiculo_aceptado' => $tipo_vehiculo_aceptado,
            'ubicacion' => $ubicacion,
            'latitud' => $latitud,
            'longitud' => $longitud
        ]);

        // Manejo de imágenes (si es necesario)
        if ($imagenes && $imagenes['error'] == 0) {
            // Implementa el manejo de las imágenes
        }
    }

    private function updateGarage($id, $nombre, $espacio, $tipo_vehiculo_aceptado, $ubicacion, $latitud, $longitud, $imagenes) {
        $stmt = $this->pdo->prepare("UPDATE garages SET nombre = :nombre, espacio = :espacio, tipo_vehiculo_aceptado = :tipo_vehiculo_aceptado, ubicacion = :ubicacion, latitud = :latitud, longitud = :longitud WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'espacio' => $espacio,
            'tipo_vehiculo_aceptado' => $tipo_vehiculo_aceptado,
            'ubicacion' => $ubicacion,
            'latitud' => $latitud,
            'longitud' => $longitud
        ]);

        // Manejo de imágenes (si es necesario)
        if ($imagenes && $imagenes['error'] == 0) {
            // Implementa el manejo de las imágenes
        }
    }

    private function toggleGarageStatus($garageId) {
        // Alterna el estado de una cochera (ejemplo)
        $stmt = $this->pdo->prepare("UPDATE garages SET activo = NOT activo WHERE id = :id");
        $stmt->execute(['id' => $garageId]);
    }
}
