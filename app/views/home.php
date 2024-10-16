</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Cocheras</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <style>
        #map {
            height: 600px;
            width: 100%;
        }
        .navbar {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }
    </style>
</head>
<body>

<div id="map"></div>

<!-- Barra de Navegación -->
<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="#">Gestión de Cocheras</a>
    <button class="btn btn-secondary" id="registerBtn">Registrarse</button>
</nav>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script>
    // Inicializa el mapa
    const map = L.map('map').setView([40.4168, -3.7038], 13); // Coordenadas de Madrid

    // Capa de mapa base
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Datos de las cocheras
    const cocheras = [
        { 
            lat: 40.4168, 
            lon: -3.7038, 
            nombre: 'Cochera 1', 
            direccion: 'Calle Ejemplo 1', 
            precio: '10€ por hora', 
            imagen: 'https://via.placeholder.com/150' 
        },
        { 
            lat: 40.4178, 
            lon: -3.7048, 
            nombre: 'Cochera 2', 
            direccion: 'Calle Ejemplo 2', 
            precio: '12€ por hora', 
            imagen: 'https://via.placeholder.com/150' 
        },
        { 
            lat: 40.4158, 
            lon: -3.7058, 
            nombre: 'Cochera 3', 
            direccion: 'Calle Ejemplo 3', 
            precio: '15€ por hora', 
            imagen: 'https://via.placeholder.com/150' 
        },
    ];

    // Variable para simular estado de inicio de sesión
    let isLoggedIn = false; // Cambiar a true si el usuario está logeado

    // Agregar marcadores para cada cochera
    cocheras.forEach(cochera => {
        const marker = L.marker([cochera.lat, cochera.lon]).addTo(map);
        marker.on('click', function() {
            const popupContent = `
                <div>
                    <h5>${cochera.nombre}</h5>
                    <img src="${cochera.imagen}" alt="${cochera.nombre}" style="width:100%; height:auto;">
                    <p>Dirección: ${cochera.direccion}</p>
                    <p>Precio: ${cochera.precio}</p>
                    <button class="btn btn-primary" id="reserveBtn">Reservar</button>
                </div>
            `;
            const popup = L.popup()
                .setLatLng([cochera.lat, cochera.lon])
                .setContent(popupContent)
                .openOn(map);

            // Manejo del botón de reserva en el popup
            document.getElementById('reserveBtn').onclick = function() {
                if (!isLoggedIn) {
                    alert('Para poder reservar necesitas iniciar sesíon. Seras redirigido al inicio de sesión.');
                    window.location.href = 'users/login.php'; // Redirigir al login
                } else {
                    // Lógica para concretar la reserva
                    alert('Reserva concretada.');
                }
            };
        });
    });

    // Manejo de botones de registro
    document.getElementById('registerBtn').addEventListener('click', function() {
        window.location.href = 'registro.html';
    });
</script>

</body>
</html>
