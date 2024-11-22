<?php 

require_once '../src/controller/DatabaseController.php';

class DashboardController {
    // Atributo que almacena la conexión a la base de datos
    private $conn;
    
    // Constructor que establece la conexión a la base de datos
    public function __construct() {
        $this->conn = DatabaseController::connect();
    }
    
    // Método para obetener phone ç

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

}
















?>