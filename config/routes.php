<?php


function routes() {
    

    $url = isset($_GET['url']) ? $_GET['url'] : '';
    $url = rtrim($url, '/');
    $url = explode('/', $url);
    
    switch ($url[0]) {
        case 'register':
            $controller = new UserController();
            $controller->register();
            break;

        case 'login':
            $controller = new UserController();
            $controller->login();
            break;

        case 'garages':
            $controller = new GarageController();
            if (isset($url[1])) {
                switch ($url[1]) {
                    case 'add':
                        $controller->addGarage();
                        break;
                    case 'edit':
                        $controller->editGarage();
                        break;
                    case 'activate':
                        $controller->activateGarage($url[2]); // Asumiendo que pasas el ID de la cochera
                        break;
                    default:
                        $controller->listGarages();
                }
            } else {
                $controller->listGarages();
            }
            break;

        case 'reserve':
            $controller = new ReservationController();
            $controller->reserveGarage();
            break;

        case 'reservations':
            $controller = new ReservationController();
            $controller->listReservations($_SESSION['user_id']); // Asumiendo que tienes una sesión activa
            break;

        case 'cancelReservation':
            $controller = new ReservationController();
            $controller->cancelReservation($url[1]); // ID de la reserva
            break;

        default:
            // Cargar vista de inicio o error
            $homePath = './app/views/home.php';
            if (file_exists($homePath)) {
                include $homePath;
            } else {
                echo "Error: Vista no encontrada.";
            }
            break;
    }
}

