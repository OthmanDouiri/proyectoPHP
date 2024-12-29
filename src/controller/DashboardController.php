<?php 
require_once '../src/controller/SessionController.php';
require_once '../src/controller/DatabaseController.php';
//namespace App\Controller;


require_once '../vendor/autoload.php';
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use PDOException;
use PDO;


class DashboardController {
    // Atributo que almacena la conexión a la base de datos
    private $conn;
    private $twig;
    
    // Constructor que establece la conexión a la base de datos
    public function __construct() {
        $this->conn = DatabaseController::connect();
        // Configurar Twig
        $loader = new FilesystemLoader('../public/templates');
        $this->twig = new Environment($loader);    
    }
    
    // Método para obetener phone 

    public function getPhone(){
        try {
            // SQL para seleccionar el teléfono
            $sql = "SELECT * FROM phone";
            $statement = $this->conn->prepare($sql);
            // Ejecutar la sentencia SQL
            $statement->execute();
            // Retornar el resultado de la consulta
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
            return false;
        }
    }


    // methode para modificar phone
    public function modifyPhone($id, $name, $price){
        try {
            // SQL para actualizar el telefono coger el id y modificar el nombre y el precio
            $sql = "UPDATE phone SET name = :name, price = :price WHERE id = :id";
            $statement = $this->conn->prepare($sql);
            $statement->bindValue(':id', $id);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':price', $price);
            // Ejecutar la sentencia SQL
            $statement->execute();
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
        }

            
    }

    public function renderDashboard() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Assurez-vous que la session est démarrée
        }
        $phones = $this->getPhone();
        $username = htmlspecialchars($_SESSION['username']);
        // Renderizar la vista del dashboard
        echo $this->twig->render('dashboard.html.twig',
        [
            'phones' => $phones ,
            'username' => $username
        ],
        );
    }


    public static function goOut(){
        // Verificar si se hizo clic en "Logout"
        if (isset($_POST['logout'])) {
            $sessionController = new SessionController();
            $sessionController->logout();
        }
    }


}