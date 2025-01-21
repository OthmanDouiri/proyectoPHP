<?php



require_once '../src/controller/DatabaseController.php';
require_once '../src/controller/DashboardController.php';
require_once '../src/controller/SessionController.php';
require_once '../src/controller/HomeController.php';
use App\Controller\HomeController;





require_once __DIR__ . '../../vendor/autoload.php';
use App\Controller\DashboardController;
use App\Controller\SessionController;
use App\Middleware\AuthMiddleware;


// Extraer la ruta base sin parámetros de consulta
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Eliminar posibles barras al final de la ruta
$request = rtrim($request, '/');
// Directorio base para las vistas (home, 404, etc.)
$viewDir = '/views/';


// Verificar la solicitud y redirigir según el caso

switch ($request) {
    case '':            // Caso de raíz de URL
    case '/':
    
    case '/home':      // Caso para 
        $homeController = new HomeController();
        $homeController->renderHome();
        break;
    

    case '/login':      // Caso para login
        require __DIR__ . $viewDir . 'login.php';
        break;

    case '/logout':     // Caso para logout
        $sessionController = new SessionController();
        $sessionController->logout();
        break;

    case '/api/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $sessionController = new SessionController();
            $response = $sessionController->login($data['username'], $data['password']);
            echo json_encode($response);
        }
        break;

    case '/api/protected':
        AuthMiddleware::protectRoute($request, function($request, $userData) {
            $dashboardController = new DashboardController();
            // Your protected route logic here
            echo json_encode(['message' => 'This is a protected route', 'user' => $userData]);
        });
        break;

    case '/register':    // Caso para registro
        require __DIR__ . $viewDir . 'register.php';
        break;
    
    case '/update':      // Caso para actualizar
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

    case '/create':      // Caso para crear
        SessionController::check();
        $dashboardController = new DashboardController();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $dashboardController->renderCreatePage();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dashboardController->handleCreate();
        }
        break;

    case '/dashboard':   // Caso para el dashboard
        SessionController::check();
        $dashboardController = new DashboardController();
        $dashboardController->renderDashboard();
        break;

    case '/gettext':     // Caso para gettext
        require __DIR__ . $viewDir . 'gettext.php';
        break;

    default:             // Rutas no definidas
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
        break;      
}
?>