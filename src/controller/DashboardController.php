<?php 
//require_once '../src/controller/SessionController.php';
//require_once '../src/controller/DatabaseController.php';
namespace App\Controller;
use App\Controller\SessionController;
use App\Controller\DatabaseController;

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
    

    function detectUserLocale() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5); // Detecta el idioma principal
        
        $supportedLanguages = ['en-US', 'es-ES']; // Idiomas soportados por la app
        

        // Verifica si el idioma detectado es compatible con los soportados
        if (in_array($lang, $supportedLanguages)) {
            return $lang;
        } else {
            return 'en-US'; // Idioma predeterminado
        }
    }

    // Método para obetener phone 
    // actualizamos getPhone para incluit la busqueda

    public function getPhone($searchQuery = null){
        try {
            // SQL para seleccionar el teléfono
            $sql = "SELECT phone.*, marca.nombre AS marca_nombre 
                FROM phone 
                JOIN marca ON phone.marca_id = marca.id";

            //Si $searchQuery no es null
            if ($searchQuery) {
                //Modifica la consulta SQL para filtrar los registros donde el nombre (name) o el precio (price) contengan la cadena proporcionada en $searchQuery.
                $sql .= " WHERE phone.name LIKE :search OR phone.price LIKE :search OR marca.nombre LIKE :search";
            }
              // Añadimos el ORDER BY para ordenar por ID
                $sql .= " ORDER BY phone.id ASC";
            // Preparar la sentencia SQL
            $statement = $this->conn->prepare($sql);
            // 
            if ($searchQuery) {
                //Aquí, la condición asegura que solo se asocie un valor al marcador :search si realmente se va a usar.
                $statement->bindValue(':search', "%$searchQuery%");
            }
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
    public function modifyPhone($id, $name, $price, $marca_id) {
        try {
            // SQL para actualizar el telefono coger el id y modificar el nombre y el precio
            $sql = "UPDATE phone SET name = :name, price = :price , marca_id = :marca_id WHERE id = :id";
            $statement = $this->conn->prepare($sql);
            $statement->bindValue(':id', $id);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':marca_id', $marca_id);
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

        // actualizar  para manejar busqueda
        $searchQuery = isset($_GET['search']) ? $_GET['search'] : null ;

        // Obtener los teléfonos según la búsqueda
        $phones = $this->getPhone($searchQuery);
        $username = htmlspecialchars($_SESSION['username']);
        
        // Mensaje si no hay resultados
            $noResultsMessage = null;
            if ($searchQuery && empty($phones)) {
                $noResultsMessage = "No se encontraron resultados para '$searchQuery'.";
            }                
        
        echo $this->twig->render('dashboard.html.twig',
        [
            'phones' => $phones ,
            'username' => $username,
            'search_query' => $searchQuery,
            'noResultsMessage' => $noResultsMessage
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





    // for update-----------------------------------------
    public function getPhoneById($id) {
        try {
            $sql = "SELECT * FROM phone WHERE id = :id";
            $statement = $this->conn->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
            return false;
        }
    }


    public function renderUpdatePage($id) {
        $phone = $this->getPhoneById($id);
        if (!$phone) {
            http_response_code(404);
            echo $this->twig->render('404.html.twig');
            return;
        }
        echo $this->twig->render('update.html.twig', ['phone' => $phone]);
    }


    
    public function handleUpdate() { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {// Verificar si se envió el formulario
            $id = $_POST['id'];// Recuperar los datos del formulario
            $name = $_POST['name'];     
            $price = $_POST['price'];
            $marca_id = $_POST['marca_id'];
    
            $this->modifyPhone($id, $name, $price, $marca_id); // Modificar el teléfono en la base de datos
            // onsublit alert to confirme the update
            
            // Redirigir al dashboard
            header('Location: /dashboard');
            exit();
        }
    }
    //-----------------delete phone----------------------------------------------
    public function deletePhone($id) {
        try {
            $sql = "DELETE FROM phone WHERE id = :id";
            $statement = $this->conn->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
        }
    }

    public function handleDelete() {
            $id = $_POST['phone_id'];
            $this->deletePhone($id);
            header('Location: /dashboard');
            exit();
    }

    //-----------------create phone----------------------------------------------

    public function createPhone($name, $price) {
        try {
            $sql = "INSERT INTO phone (name, price) VALUES (:name, :price)";
            $statement = $this->conn->prepare($sql);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':price', $price);
            $statement->execute();
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
        }
    }

    public function handleCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            
            $this->createPhone($name, $price);  
            echo $this->twig->render('create.html.twig', [
                'successMessage' => 'El teléfono fue creado exitosamente.',
            ]);
        }
    }

    public function renderCreatePage() {
        echo $this->twig->render('create.html.twig');
    }



}