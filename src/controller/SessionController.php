<?php

require_once '../src/controller/DatabaseController.php';

class SessionController {
    private $conn;

    // Constructor que establece la conexión a la base de datos
    public function __construct() {
        $this->conn = DatabaseController::connect();
    }

    // Verificar si el usuario ya existe en la base de datos
    public function exist($username, $email = null) {
        try {
            if ($email === null) {
                // SQL para seleccionar el usuario por nombre de usuario
                $sql = "SELECT * FROM User WHERE username = :username";
                $statement = $this->conn->prepare($sql);
                $statement->bindValue(':username', $username);
            } else {
                // SQL para seleccionar el usuario por nombre de usuario y correo electrónico
                $sql = "SELECT * FROM User WHERE username = :username AND email = :email";
                $statement = $this->conn->prepare($sql);
                $statement->bindValue(':username', $username);
                $statement->bindValue(':email', $email);
            }
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
        if ($this->exist($username, $email)) {
            return "El usuario ya existe";
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

                return "Usuario registrado correctamente";
            } catch (PDOException $error) {
                return "Error: " . $error->getMessage();
            }
        }
    }


    // methode de sign up 
    public function login($username, $password) {
        // Verificar si el usuario existe
        if (!$this->exist($username)) {
            return false;
        }

        try {
            // SQL para obtener la contraseña del usuario
            $sql = "SELECT id, password FROM User WHERE username = :username";
            $statement = $this->conn->prepare($sql);
            $statement->bindValue(':username', $username);
            $statement->execute();

            // Obtener el usuario
            $user = $statement->fetch(PDO::FETCH_OBJ);

            // Verificar la contraseña
            if ($user && password_verify($password, $user->password)) {
                // Iniciar la sesión del usuario
                session_start();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $username;

                return true; // Inicio de sesión exitoso
            } else {
                return false; // Contraseña incorrecta
            }
        } catch (PDOException $error) {
            echo "Error en la consulta: " . $error->getMessage();
            return false;
        }
    }


    public static function logout() {
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
    }
    
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

        session_start();
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];

            $statement = (new self)->conn->prepare("SELECT id, username FROM User WHERE token = :token");
            $statement->bindValue(":token", $token);
            $statement->setFetchMode(PDO::FETCH_OBJ);
            $statement->execute();
            $user = $statement->fetch();


            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;

                return true;


        } else {
            // Token inválido
            setcookie("token", "", time() - 3600, "/"); // Eliminar cookie
            // header("Location: login.php");
            // exit();
            echo "Token inválido!";
            return false;
        }
    } else {
        return false;
    }

    }



    public static function isLoggedIn() {
        return self::verifyTokenCookie();
    }


    
}





?>
