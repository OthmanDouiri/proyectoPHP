<?php
namespace App\Controller;
use App\Controller\DatabaseController;
use App\model\User;
use App\utils\JWTUtils;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PDO;
use PDOException;
use Exception;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class SessionController {
    private $conn;

    // Constructor que establece la conexión a la base de datos
    public function __construct() {
        $this->conn = DatabaseController::connect();
    }

    // Verificar si el usuario ya existe en la base de datos
    public function exist($email) {
        try {
            
                // SQL para seleccionar el usuario por nombre de usuario y correo electrónico
                $sql = "SELECT * FROM User WHERE email = :email";
                $statement = $this->conn->prepare($sql);
                $statement->bindValue(':email', $email);
            
            // Ejecutar la sentencia SQL
            $statement->execute();
            // Verificar si se obtuvo algún resultado
            return $statement->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
            return false;
        }
    }

    // Registrar nuevo usuario
    public function register($username, $email, $password) {
        // Verificar si el usuario ya existe
        if ($this->exist($email)) {
            return ['success' => false, 'error' => 'El usuario ya existe'];
        } else {
            try {
                // SQL para insertar un nuevo usuario en la base de datos
                $sql = "INSERT INTO User (username, email, password, token) VALUES (:username, :email, :password, :token)";
                // Hashear la contraseña antes de guardarla
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                // Preparar la sentencia SQL
                $statement = $this->conn->prepare($sql);
                $statement->bindValue(':username', $username);
                $statement->bindValue(':email', $email);
                $statement->bindValue(':password', $passwordHash);
                $statement->bindValue(':token', ''); // Inicialmente sin token
                // Ejecutar la sentencia SQL
                $statement->execute();

                return ['success' => true];
            } catch (PDOException $error) {
                return ['error' => false, 'error' => $error->getMessage()];
            }
        }
    }


    // methode de sign up 
    public function login($username,$password){
        
        $userModel = new User($this->conn);
        $user = $userModel->findByUsername($username);
               
        if($user){
            if(password_verify($password, $user['password'])){
                $token = JWTUtils::generateJWt($user['id'], $user['username'], $user['role']);
                $userModel->updateToken($user['id'], $token);
                 // Store the username in the session
                 $_SESSION['username'] = $user['username'];
                // Guardar el token en una cookie
                setcookie("token", $token, time() + (86400 * 30), "/"); // 86400 segundos en un día * 30 días
                return ['token' => $token, 'message' => 'Login successful'];
            } else {
                return ['error' => 'Invalid credentials'];
            }
        } else {
            return ['error' => 'User not found'];
        }
    }

// logout version 2 

public function logout() {
    // Verificar si la sesión está activa
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Eliminar todas las variables de sesión
    $_SESSION = [];
    // Destruir la sesión
    session_destroy();
    // Eliminar la cookie 'token'
    setcookie("token", "", time() - 3600, "/"); // Expira inmediatamente
    // Redirigir al login
    header("Location: login");
    exit();
}
 // logout methode version 1
    /*public  function logout() {

        // Iniciar la sesión si aún no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Destruir todas las variables de sesión y la sesión en sí
        $_SESSION = [];
        session_destroy();
        // Redirigir al login
        header("Location: login");
        exit();
    }*/
    
    // vamos a hacer una función para generar token

    public function generateToken($user) {
        // Verificar si la sesión está activa comprobando si existe user_id en $_SESSION
        if (isset($_SESSION['user_id'])) {
            // Generar un token aleatorio de 16 bytes y convertirlo a hexadecimal
            $token = bin2hex(random_bytes(16));
    
            // Establecer una cookie con el nombre 'token', que expira en 30 días
            setcookie("token", $token, time() + (86400 * 30), "/"); // 86400 segundos en un día * 30 días
    
            // Guarda el token en la base de datos
            $statement = $this->conn->prepare("UPDATE User SET token = :token WHERE id = :id");
            $statement->bindValue(':token', $token);
            $statement->bindValue(':id', $user->id);
            $statement->execute();
    
            return true; // Devolver 'true' si todo se ejecutó correctamente
        } else {
            return false; // Devolver 'false' si no hay una sesión activa
        }
    }
        
    // function verirfyTokenCookie 
    public static function verifyTokenCookie() {
        // Asegurarse de que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Verificar si existe la cookie 'token'
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
    
            // Preparar la consulta para verificar el token en la base de datos
            $statement = (new self)->conn->prepare("SELECT id, username FROM User WHERE token = :token");
            $statement->bindValue(":token", $token);
            $statement->setFetchMode(PDO::FETCH_OBJ);
            $statement->execute();
            $user = $statement->fetch();
    
            // Si se encuentra un usuario con el token válido
            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                return true;
            } else {
                // Token inválido: eliminar cookie
                setcookie("token", "", time() - 3600, "/"); // Expira inmediatamente
                // Redirigir al login o manejar el error
                echo "Token inválido!";
                return false;
            }
        } else {
            // No existe la cookie 'token'
            return false;
        }
    }
    

    // return token
    public static function isLoggedIn() {
        return self::verifyTokenCookie();
    }


    // Verificar si el usuario está logueado
    public static function checkSession() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: login"); // Redirige al login si no está logueado
            exit();
        }
    }





    //funcion is loggedin actualizado por jwt 

    public static function isAuthenticated() {
        // Verificar si el token está en las cookies
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];

            try {
                // Decodificar el token usando la clave secreta
                $decoded = JWT::decode($token, new Key('my_secret_key', 'HS256'));
    
                // Validar si el token sigue siendo válido
                if ($decoded && isset($decoded->userId)) {
                    return true;
                }
            } catch (Exception $e) {
                // Si el token no es válido
                error_log($e->getMessage());
                return false;
            }
        }
        return false; // Si no hay token, el usuario no está autenticado
    }

    // Verificar si el usuario está logueado
        public static function check() {
            session_start();

            if (!SessionController::isAuthenticated()) {
                header("Location: /login");
                exit();
            }
        }
    



        public function handleLogin() {
            // Inicia la sesión
            session_start();
    
            // Verifica si el usuario ya está logueado
            if (isset($_SESSION['user_id'])) {
                header("Location: /dashboard"); // Redirige al dashboard si ya está logueado
                exit();
            }
    
            // Configurar Twig
            $loader = new FilesystemLoader(__DIR__ . '/../../templates');
            $twig = new Environment($loader);
    
            // Maneja el inicio de sesión del usuario
            $error = null;
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];
    
                // Llama al método de inicio de sesión
                $loginResult = $this->login($username, $password);
    
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
    
            // global $twig para que twig pueda ser usado en la función (i18n)
            global $twig;

            // Renderiza la plantilla de Twig
            echo $twig->render('login.html.twig', [
                'error' => $error
                
            
            ]);
        }


        // Maneja el registro del usuario
       public function handleRegister() {
        // Inicia la sesión
        session_start();

        // Configurar Twig
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $twig = new Environment($loader);

        // Maneja el registro del usuario
        $message = null;
        $messageType = 'danger';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Llama al método de registro
            $registerResult = $this->register($username, $email, $password);

            if ($registerResult['success']) {
                $message = "Registro exitoso. Por favor, inicia sesión.";
            } else {
                $error = "Error en el registro: " . $registerResult['error'];
            }
        }


        
        global $twig;

        // Renderiza la plantilla de Twig
        echo $twig->render('register.html.twig', [
            'message' => $message,
        ]);
    }

        
}












?>