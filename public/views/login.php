<?php 
use App\Controller\SessionController;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

// for errors 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia la sesión
session_start();
require_once __DIR__ . '/../../vendor/autoload.php'; // Adjusted path

// Verifica si el usuario ya está logueado
if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard"); // Redirige al dashboard si ya está logueado
    exit();
}

// Configurar Twig
$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

// Maneja el inicio de sesión del usuario
$error = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];


     
    // Crea una instancia del controlador de sesión
    $sessionController = new SessionController();
  
    // Llama al método de inicio de sesión
    $loginResult = $sessionController->login($username, $password);

    
  
    if (isset($loginResult['token'])) {
        // Guarda el token en la sesión
        $_SESSION['token'] = $loginResult['token'];
         

        // Check if headers are already sent
        if (headers_sent()) {
          echo "Headers already sent!";
          die();
      }
        // Redirige al dashboard si el inicio de sesión es exitoso
        header("Location: /dashboard");
        exit();
        
    } else {
        // Maneja el error de inicio de sesión
        $error = "Usuario o contraseña incorrectos.";
    }
}

// Renderiza la plantilla de Twig
echo $twig->render('login.html.twig', ['error' => $error]);