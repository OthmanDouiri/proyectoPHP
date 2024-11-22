<?php
$request = $_SERVER['REQUEST_URI'];

// Eliminar posibles barras al final de la URL
$request = rtrim($request, '/');

// Directorio base para las vistas (home, 404, etc.)
$viewDir = '/views/';

// Incluir controlador de base de datos
require_once '../src/controller/DatabaseController.php';
require_once '../src/controller/DashboardController.php';

// Verificar la solicitud y redirigir según el caso
switch ($request) {
    case '':            // Caso de raíz de URL
    case '/':
    case '/login':      // Caso para login
        require __DIR__ . $viewDir . 'login.php';
        break;

    case '/register':    // Caso para registro
        require __DIR__ . $viewDir . 'register.php';
        break;

    case '/dashboard':   // Caso para el dashboard
        require __DIR__ . $viewDir . 'dashboard.php';
        break;

    default:             // Rutas no definidas
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
        break;      
}



//pasar los datos obtenidos getPhone a la plantilla Twig.
require_once '../vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

// Configuración de Twig
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

// Crear una instancia de DashboardController
$dashboardController = new DashboardController();

// Obtener los datos de la base de datos
$phone = $dashboardController->getPhone();


// Renderizar la plantilla
echo $twig->render('dashboard.twig', ['phone' => $phone]);

?>