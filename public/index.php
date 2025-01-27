<?php

// Requerir controladores y autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\HomeController;
use App\Controller\DashboardController;
use App\Controller\SessionController;
use App\Middleware\AuthMiddleware;
use App\Controller\ErrorController;

// Extraer la ruta base sin parámetros de consulta
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Eliminar posibles barras al final de la ruta
$request = rtrim($request, '/');

// Directorio base para las vistas
$viewDir = '/views/';

// Verificar la solicitud y redirigir según el caso
switch ($request) {
    case '': // Página raíz
    case '/':
    case '/home': // Página principal
        $homeController = new HomeController();
        $homeController->renderHome();
        break;

    case '/login': // Página de inicio de sesión
        $sessionController = new SessionController();
        $sessionController->handleLogin();
        break;

    case '/logout': // Acción de cierre de sesión
        $sessionController = new SessionController();
        $sessionController->logout();
        break;

    case '/api/login': // API de inicio de sesión
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $sessionController = new SessionController();
            $response = $sessionController->login($data['username'], $data['password']);
            echo json_encode($response);
        }
        break;

    case '/api/protected': 
        // Ruta protegida con middleware
            AuthMiddleware::protectRoute($request, function ($request, $userData) {
            $dashboardController = new DashboardController();
            echo json_encode(['message' => 'This is a protected route', 'user' => $userData]);
        });
        break;

    case '/register': // Página de registro
        $sessionController = new SessionController();
        $sessionController->handleRegister();
        break;

    case '/update': // Actualización de datos
        SessionController::check();
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

    case '/create': // Creación de datos
        SessionController::check();
        $dashboardController = new DashboardController();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $dashboardController->renderCreatePage();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dashboardController->handleCreate();
        }
        break;

    case '/dashboard': // Página del dashboard
        SessionController::check();
        $dashboardController = new DashboardController();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone_id'])) {
            // Si es una solicitud POST con un ID, manejar la eliminación
            $dashboardController->handleDelete();  
        } else {
            // Si no es POST o no tiene un phone_id, renderizamos el dashboard
            $dashboardController->renderDashboard();
        }
        break;

    case '/gettext': // Página para gettext
        require __DIR__ . $viewDir . 'gettext.php';
        break;

    default: // Página no encontrada (404)
        http_response_code(404);
        $errorController = new ErrorController();
        $errorController->render404();
        break;
        break;
}
