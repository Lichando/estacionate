<?php
// controllers/ReservationController.php
class ReservationController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function reserveGarage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente_id = $_POST['cliente_id'] ?? null;
            $cochera_id = $_POST['cochera_id'] ?? null;
            $fecha_reserva = $_POST['fecha_reserva'] ?? null;
            $duracion = $_POST['duracion'] ?? null;

            if ($this->validateReservation($cliente_id, $cochera_id, $fecha_reserva, $duracion)) {
                $this->saveReservation($cliente_id, $cochera_id, $fecha_reserva, $duracion);
                header('Location: /reservations');
                exit;
            } else {
                $error = "Datos de reserva inválidos.";
            }
        }

        $garages = $this->getAvailableGarages();
        include 'views/reservations/reserve.php';
    }

    public function listReservations($userId) {
        return $this->getReservationsByUserId($userId);
    }

    public function cancelReservation($reservationId) {
        $this->deleteReservation($reservationId);
        header('Location: /reservations');
        exit;
    }

    private function validateReservation($cliente_id, $cochera_id, $fecha_reserva, $duracion) {
        return !empty($cliente_id) && !empty($cochera_id) && !empty($fecha_reserva) && !empty($duracion);
    }

    private function getAvailableGarages() {
        $stmt = $this->pdo->query("SELECT * FROM garages WHERE activo = 1 AND id NOT IN (SELECT cochera_id FROM reservations WHERE fecha_reserva = CURDATE())");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getReservationsByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM reservations WHERE cliente_id = :cliente_id");
        $stmt->execute(['cliente_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function saveReservation($cliente_id, $cochera_id, $fecha_reserva, $duracion) {
        $stmt = $this->pdo->prepare("INSERT INTO reservations (cliente_id, cochera_id, fecha_reserva, duracion) VALUES (:cliente_id, :cochera_id, :fecha_reserva, :duracion)");
        $stmt->execute([
            'cliente_id' => $cliente_id,
            'cochera_id' => $cochera_id,
            'fecha_reserva' => $fecha_reserva,
            'duracion' => $duracion
        ]);
    }

    private function deleteReservation($reservationId) {
        $stmt = $this->pdo->prepare("DELETE FROM reservations WHERE id = :id");
        $stmt->execute(['id' => $reservationId]);
    }
    
}
