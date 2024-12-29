<?php

// Extraer la ruta base sin parámetros de consulta
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Eliminar posibles barras al final de la ruta
$request = rtrim($request, '/');
// Directorio base para las vistas (home, 404, etc.)
$viewDir = '/views/';

//Incluir controlador de base de datos
require_once '../src/controller/DatabaseController.php';
require_once '../src/controller/DashboardController.php';
require_once '../src/controller/SessionController.php';
require_once '../src/controller/AccountController.php';
/*require_once '../vendor/autoload.php';
use App\Controller\DatabaseController;
use App\Controller\DashboardController;
use App\Controller\SessionController;
use App\Controller\AccountController;*/



// Verificar la solicitud y redirigir según el caso

switch ($request) {
    case '':            // Caso de raíz de URL
    case '/':
    case '/login':      // Caso para login
    
        require __DIR__ . $viewDir . 'login.php';
        break;

    case '/logout':   // Caso para el dashboard
        // Crear una instancia de DashboardController y renderizar el dashboard
        $sessionController = new SessionController();
        $sessionController->logout();
        break;

    case '/register':    // Caso para registro
        require __DIR__ . $viewDir . 'register.php';
        break;
    
    case '/update':    // Caso para registro
        require __DIR__ . $viewDir . 'update.php';
        break;
    
    case '/delete':    // Caso para registro
            require __DIR__ . $viewDir . 'delete.php';
            break;

    case '/dashboard':   // Caso para el dashboard
        // Crear una instancia de DashboardController y renderizar el dashboard
        $sessionController = new SessionController();
        $sessionController->checkSession();
        $dashboardController = new DashboardController();
        $dashboardController->renderDashboard();
        break;
    
    case '/account':   // Caso para el dashboard
            // Crear una instancia de DashboardController y renderizar el dashboard
            $accountController = new AccountController();
            $accountController->renderAccount();
            break;
    default:             // Rutas no definidas
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
        break;      
}
?>