<?php 

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
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);    
      
    }
    



    // Método para obetener phone 
    // actualizamos getPhone para incluit la busqueda

    public function getPhone($searchQuery = null) {
        // Obtener teléfonos usando API cURL
        $url = 'http://proyectophp.local/api/phones';
        if ($searchQuery) {
            $url .= '?search=' . urlencode($searchQuery);
        }
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        if (isset($response['status']) && $response['status'] === 'error') {
            echo "Error: " . $response['message'];
            return false;
        }
        return $response;
    }


    // methode para modificar phone
    // public function modifyPhone($id, $name, $price, $marca_id) {
    //     try {
    //         // SQL para actualizar el telefono coger el id y modificar el nombre y el precio
    //         $sql = "UPDATE phone SET name = :name, price = :price , marca_id = :marca_id WHERE id = :id";
    //         $statement = $this->conn->prepare($sql);
    //         $statement->bindValue(':id', $id);
    //         $statement->bindValue(':name', $name);
    //         $statement->bindValue(':price', $price);
    //         $statement->bindValue(':marca_id', $marca_id);
    //         // Ejecutar la sentencia SQL
    //         $statement->execute();
    //     } catch (PDOException $error) {
    //         echo "Error: " . $error->getMessage();
    //     }

            
    // }

    public function renderDashboard() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Assurez-vous que la session est démarrée
        }

        $data = $this->graficHightChart();

        // actualizar  para manejar busqueda
        $searchQuery = isset($_GET['search']) ? $_GET['search'] : null ;

        // Obtener los teléfonos según la búsqueda
        $phones = $this->getPhone($searchQuery);
        $username = htmlspecialchars($_SESSION['username']);
        $usernameUppercase = strtoupper($username);
        // Mensaje si no hay resultados
            $noResultsMessage = null;
            if ($searchQuery && empty($phones)) {
                $noResultsMessage = "No se encontraron resultados para '$searchQuery'.";
            }                
        
        

        echo $this->twig->render('dashboard.html.twig',
        [
           
            'phones' => $phones ,
            'username' => $usernameUppercase,
            'search_query' => $searchQuery,
            'noResultsMessage' => $noResultsMessage,
            'chartData' => $data,
        ],
        );
    }

    public static function goOut(){
        // Verificar si se hizo clic en "Logout"
        if (isset($_POST['logout'])) {
            $sessionController = new SessionController();
            // Cerrar la sesión
            $sessionController->logout();
        }
    }





    // for update-----------------------------------------
    public function getPhoneById($id) {
        // get phone by id using api curl
        $url = "http://proyectophp.local/api/phones/$id";
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        return $response;
    }


    
    public function handleUpdate() { 
        // update phone using api curl
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $marca_id = $_POST['marca_id'];
            $image_url = $_POST['image_url'];
    
            $data = [
                'name' => $name,
                'price' => $price,
                'marca_id' => $marca_id,
                'image_url' => $image_url,

            ];
            $url = "http://proyectophp.local/api/phones/$id";
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_CUSTOMREQUEST => 'PATCH',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_RETURNTRANSFER => true,
            ]);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response, true);
            if (isset($response['status']) && $response['status'] === 'error') {
                echo $this->twig->render('404.html.twig', [
                    'errorMessage' => $response['message'],
                ]);
            } else {
                header('Location: /dashboard');
                exit();
            }
        }
    }


    // render update page
     public function renderUpdatePage($id) {

        $phone = $this->getPhoneById($id);
        if (!$phone) {
            http_response_code(404);
            echo $this->twig->render('404.html.twig');
            return;
        }
        echo $this->twig->render('update.html.twig', ['phone' => $phone]);
    }

    //-----------------delete phone----------------------------------------------
    public function deletePhone($id) {
        //delete phone using api curl
        $url = "http://proyectophp.local/api/phones/$id";
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        if (isset($response['status']) && $response['status'] === 'error') {
            echo $this->twig->render('404.html.twig', [
                'errorMessage' => $response['message'],
            ]);
        } else {
            header('Location: /dashboard');
            exit();
        }
    }


    //-----------------create phone-----------------------------           

     // Método para manejar la creación de un teléfono usando cURL
    public function handleCreate() {
        // Verificar si el formulario fue enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $marca_id = $_POST['marca_id'];
            $image_url = $_POST['image_url'];

            // Llamar a la API usando cURL
            $url = 'http://proyectophp.local/api/phones'; 
            $data = [
                'name' => $name,
                'price' => $price,
                'marca_id' => $marca_id,
                'image_url' => $image_url,
            ];

            // Configuración de cURL
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_RETURNTRANSFER => true,
            ]);

            // Ejecutar la solicitud cURL
            $response = curl_exec($ch);
            curl_close($ch);

            // Procesar la respuesta de la API
            $response = json_decode($response, true);
            if (isset($response['status']) && $response['status'] === 'error') {
                // Si hubo un error, mostrar mensaje
                echo $this->twig->render('create.html.twig', [
                    'errorMessage' => $response['message'],
                ]);
            } else {
                // Si la creación fue exitosa, mostrar mensaje de éxito
                echo $this->twig->render('create.html.twig', [
                    'successMessage' => 'El teléfono fue creado exitosamente.',
                ]);
            }
        }
    }

            // Método para renderizar la página de creación
            public function renderCreatePage() {
                echo $this->twig->render('create.html.twig');
            }


    //Método para obtener los datos de la base de datos y generar el gráfico de la librería Highcharts

    public function graficHightChart()
    {
        // Consulta SQL con JOIN para obtener el nombre de cada marca
        $query = "
            SELECT m.nombre AS nombre_marca, COUNT(*) AS total
            FROM phone p
            JOIN marca m ON p.marca_id = m.id
            GROUP BY m.nombre
        ";
    
        $stmt = $this->conn->prepare($query); // Preparar la consulta
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Calcular el porcentaje de cada marca
        $totalPhones = array_sum(array_column($result, 'total'));   // Sumar el total de teléfonos
        $data = []; // Array para almacenar los datos del gráfico

     // Iterar sobre los resultados para calcular el porcentaje de cada marca
        foreach ($result as $row) { 
            $percentage = round(($row['total'] / $totalPhones) * 100, 2); // Calcular el porcentaje // Redondear a 2 decimales
            $data[] = [
                'name' => $row['nombre_marca'] . " ({$row['total']} teléfonos)", // Usamos el nombre real de la marca
                'y' => $percentage
            ];
        }

        return json_encode($data); // Devolver los datos en formato JSON ( render el la funcion renderDashboard)
    }

















}