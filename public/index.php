<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Requerir controladores y autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';


// -------------- i18n block----------------s
// Initialize Twig
$twig = require __DIR__ . '/../config/twig.php';

// Initialize i18n
$translations = require __DIR__ . '/../config/i18n.php';


// Add translations to Twig globals 

/* we use this to make the translations available in all templates */
$twig->addGlobal('translations', $translations);


// -------------------i18n fin--------------------------


//File to include the translation service and use it for translations:

use App\Controller\HomeController;
use App\Controller\DashboardController;
use App\Controller\SessionController;
use App\Controller\ErrorController;
use App\Controller\API\PhoneAPI;
use App\Controller\ClientController;
use App\Middleware\AuthMiddleware;



// Extraer la ruta base sin parámetros de consulta
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Eliminar posibles barras al final de la ruta
$request = rtrim($request, '/');

// Directorio base para las vistas
$viewDir = '/views/';

// Verificar si la solicitud es para la API
if (strpos($request, '/api') === 0) {
    //To protect API requests for only users who can log in,
    //wee use the AuthMiddleware class to validate the JWT token.

    
     //AuthMiddleware::protectRoute();

    // Rutas de la API
    switch ($request) {

        // Ruta para obtener todos los teléfonos
        case '/api/phones':
             // Verificar si el usuario está autenticado
            AuthMiddleware::protectRoute();
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $phoneAPI = new PhoneAPI();
                $searchQuery = isset($_GET['search']) ? $_GET['search'] : null;
                $phones = $phoneAPI->getPhones($searchQuery);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Ruta para crear un teléfono
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['name'], $data['price'], $data['marca_id'], $data['image_url'])) {
                    $phoneAPI = new PhoneAPI();
                    $response = $phoneAPI->createPhone($data['name'], $data['price'], $data['marca_id'], $data['image_url']);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Missing required fields'
                    ]);
                }
            }
            break;

        // Ruta para obtener un teléfono específico por ID
        case (preg_match('/^\/api\/phones\/\d+$/', $request) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $id = basename($request);
                $phoneAPI = new PhoneAPI();
                $phone = $phoneAPI->getPhoneById($id);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                // Ruta para actualizar un teléfono completamente
                $id = basename($request);
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['name'], $data['price'], $data['marca_id'], $data['image_url'])) {
                    $phoneAPI = new PhoneAPI();
                    $response = $phoneAPI->updatePhone($id, $data['name'], $data['price'], $data['marca_id'], $data['image_url']);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Missing required fields'
                    ]);
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
                // Ruta para actualizar parcialmente un teléfono
                $id = basename($request);
                $data = json_decode(file_get_contents('php://input'), true);
                $phoneAPI = new PhoneAPI();
                $response = $phoneAPI->partialUpdatePhone($id, $data);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                // Ruta para eliminar un teléfono
                $id = basename($request);
                $phoneAPI = new PhoneAPI();
                $response = $phoneAPI->deletePhone($id);
            }
            break;

        // Si la ruta no existe en la API
        default:
            http_response_code(404);
            echo json_encode(['error' => 'API route not found']);
            break;
    }
} else {
    // Resto de las rutas 
    switch ($request) {
        case '': // Página raíz
        case '/':
        case '/home': // Página principal
            $homeController = new HomeController($twig);
            $homeController->renderHome();
            break;
    
        case '/checkout':
            $clientController = new ClientController($twig);
            $clientController->renderCheckout();
            break;

        case '/login': // Página de inicio de sesión
            AuthMiddleware::protectRoute();
            $sessionController = new SessionController();
            $sessionController->handleLogin();
            break;

        case '/logout': // Acción de cierre de sesión
            AuthMiddleware::protectRoute();
            $sessionController = new SessionController();
            $sessionController->logout();
            break;

        case '/register': // Página de registro
            $sessionController = new SessionController();
            $sessionController->handleRegister();
            break;

        case '/update': // Actualización de datos

             // Verificar si el usuario está autenticado
            AuthMiddleware::protectRoute();
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

        case '/create':

             // Verificar si el usuario está autenticado
            AuthMiddleware::protectRoute();
            // Verificar si el usuario está autenticado
            SessionController::check();

            // Crear una instancia del controlador
            $dashboardController = new DashboardController($twig);

            // Manejar el proceso de creación
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $dashboardController->handleCreate();
            } else {
                // Si es una solicitud GET, mostrar la página de creación
                $dashboardController->renderCreatePage();
            }
            break;

        case '/dashboard': // Página del dashboard
            AuthMiddleware::protectRoute();  // Aquí se valida la autenticación del usuario
            // Verificar si el usuario está autenticado
            SessionController::check();
            
            $dashboardController = new DashboardController($twig);

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone_id'])) {
                $phoneId = $_POST['phone_id'];  // Obtener el ID del teléfono desde el formulario
                $dashboardController->deletePhone($phoneId);  // Pasar el ID a la función
            } else {
                $dashboardController->renderDashboard();
            }
            break;

        default: // Página no encontrada (404)
            http_response_code(404);
            $errorController = new ErrorController();
            $errorController->render404();
            break;
    }
}
