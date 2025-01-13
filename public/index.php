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
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($_GET['id'])) {
                    $dashboardController = new DashboardController();
                    $dashboardController->renderUpdatePage($_GET['id']);
                } else {
                    http_response_code(400);
                    echo "Falta el ID del teléfono.";
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $dashboardController = new DashboardController();
                $dashboardController->handleUpdate();
            }
            break;
    case '/create':
        
            $dashboardController = new DashboardController();
        
            // Render the create page initially
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $dashboardController->renderCreatePage();
            }
            
            // Handle form submission for creating a phone
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $dashboardController->handleCreate();
            }
            break;

    case '/dashboard':   // Caso para el dashboard
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
                $sessionController = new SessionController();
                $sessionController->checkSession();
                $dashboardController = new DashboardController();
            
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone_id'])) {
                    // Si es una solicitud POST con un ID, manejar la eliminación
                    $dashboardController->handleDelete();  
                } else {
                    // Si no es POST o no tiene un phone_id, renderizamos el dashboard
                    $dashboardController->renderDashboard();
                }
                break;
    
    case '/account':   // Caso para el dashboard
            // Crear una instancia de DashboardController y renderizar el dashboard
            $accountController = new AccountController();
            $accountController->renderAccount();
            break;
    case '/gettext':   // Caso para el dashboard
        require __DIR__ . $viewDir . 'gettext.php';
        break;

    default:             // Rutas no definidas
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
        break;      
}
?>