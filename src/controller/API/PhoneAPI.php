<?php
namespace App\Controller\API;
use App\Controller\DatabaseController;
use PDO;
use PDOException;

class PhoneAPI {
    private $conn;

    public function __construct() {
        $this->conn = DatabaseController::connect();
    }










    
    // GET /phones: Recupera una lista de phones
    public function getPhones($searchQuery = null) {
        header('Content-Type: application/json');  // Establecer encabezado para JSON
        try {
            $sql = "SELECT phone.*, marca.nombre AS marca_nombre FROM phone JOIN marca ON phone.marca_id = marca.id";
            if ($searchQuery) {
                $sql .= " WHERE phone.name LIKE :search OR phone.price LIKE :search OR marca.nombre LIKE :search";
            }
            $sql .= " ORDER BY phone.id ASC";
            $statement = $this->conn->prepare($sql);
            if ($searchQuery) {
                $statement->bindValue(':search', "%$searchQuery%");
            }
            $statement->execute();
            $phones = $statement->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($phones);
        } catch (PDOException $error) {
            echo json_encode(['error' => 'Error: ' . $error->getMessage()]);
        }
    }

    // GET /phones/{id}: Recupera un phone específico por su ID
   public function getPhoneById($id) {
    header('Content-Type: application/json'); // Asegurar respuesta en JSON

    try {
        $sql = "SELECT phone.*, marca.nombre AS marca_nombre 
                FROM phone 
                JOIN marca ON phone.marca_id = marca.id 
                WHERE phone.id = :id";
        $statement = $this->conn->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $phone = $statement->fetch(PDO::FETCH_ASSOC);

        if ($phone) {
            http_response_code(200); // Éxito
            echo json_encode($phone);
        } else {
            http_response_code(404); // No encontrado
            echo json_encode(['status' => 'error', 'message' => 'Phone not found']);
        }
    } catch (PDOException $error) {
        http_response_code(500); // Error del servidor
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $error->getMessage()]);
    }
    exit();
}

    // POST /phones: Crea un nuevo phone
    public function createPhone($name, $price, $marca_id, $image_url) {
        header('Content-Type: application/json');  // Establecer encabezado para JSON
        try {
            $query = "INSERT INTO phone (name, price, marca_id, image_url) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$name, $price, $marca_id, $image_url]);
            
            // Si la ejecución es exitosa, se devuelve el objeto de teléfono creado
            $response = [
                'status' => 'success',
                'message' => 'Phone created successfully',
                'data' => [
                    'name' => $name,
                    'price' => $price,
                    'marca_id' => $marca_id,
                    'image_url' => $image_url
                ]
            ];
            echo json_encode($response);
        } catch (PDOException $error) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to create phone',
                'error' => $error->getMessage()
            ]);
        }
    }

    // PUT /phones/{id}: Actualiza todos los datos de un phone específico
    public function updatePhone($id, $name, $price, $marca_id, $image_url) {
        header('Content-Type: application/json');  // Establecer encabezado para JSON
        try {
            $sql = "UPDATE phone SET name = :name, price = :price, marca_id = :marca_id, image_url = :image_url WHERE id = :id";
            $statement = $this->conn->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':marca_id', $marca_id);
            $statement->bindValue(':image_url', $image_url);
            $statement->execute();
            echo json_encode(['message' => 'Phone updated successfully']);
        } catch (PDOException $error) {
            echo json_encode(['error' => 'Error: ' . $error->getMessage()]);
        }
    }

    // PATCH /phones/{id}: Modifica parcialmente los datos de un phone
    public function partialUpdatePhone($id, $data) {
        header('Content-Type: application/json');  // Establecer encabezado para JSON
        try {
            $sql = "UPDATE phone SET ";
            $fields = [];
            $values = [];
            foreach ($data as $key => $value) {
                $fields[] = "$key = :$key";
                $values[":$key"] = $value;
            }
            $sql .= implode(", ", $fields);
            $sql .= " WHERE id = :id";
            $values[':id'] = $id;

            $statement = $this->conn->prepare($sql);
            $statement->execute($values);

            if ($statement->rowCount() > 0) {
                http_response_code(200); // Éxito
                echo json_encode(['message' => 'Phone partially updated successfully', 'data' => $data]);
            } else {
                http_response_code(404); // No encontrado
                echo json_encode(['message' => 'Phone not found']);
            }
        } catch (PDOException $error) {
            echo json_encode(['error' => 'Error: ' . $error->getMessage()]);
        }
    }

    // DELETE /phones/{id}: Elimina un phone específico
    public function deletePhone($id) {
    header('Content-Type: application/json'); // Respuesta en JSON

    try {
        $sql = "DELETE FROM phone WHERE id = :id";
        $statement = $this->conn->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            http_response_code(200); // Éxito
            echo json_encode(['status' => 'success', 'message' => 'Phone deleted successfully']);
        } else {
            http_response_code(404); // No encontrado
            echo json_encode(['status' => 'error', 'message' => 'Phone not found']);
        }
    } catch (PDOException $error) {
        http_response_code(500); // Error del servidor
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $error->getMessage()]);
    }
    exit();
}
}   
