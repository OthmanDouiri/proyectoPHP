<?php 
namespace App\Model;
use App\Controller\DatabaseController;
Use PDO;
Use PDOException;

class User {
    // Propiedades
    private $conn;
// Constructor
    public function __construct($conn){
        $this->conn = DatabaseController::connect();
    }
    
// buscar user by username

public function findByUsername($username){

        $sql = "SELECT id, username, password, role FROM User WHERE username = :username";
        $statement = $this->conn->prepare($sql);
        $statement->bindValue(':username', $username);
        $statement->execute();
        // Debugging: Check if the user is fetched
        $user = $statement->fetch(PDO::FETCH_ASSOC);
    

        return $user;
    }


// find user by token 
public function findByToken($token){
    try{
        $sql = "SELECT * FROM User WHERE token = :token";
        $statement = $this->conn->prepare($sql);
        $statement->bindValue(':token', $token);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $error){
        echo "Error: " . $error->getMessage();
        return false;
    }
}

// create a new user
public function create($username, $email, $password){{
    try{
        password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO User (username, email, password) VALUES (:username, :email, :password)";
        $statement = $this->conn->prepare($sql);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
         return $statement->execute();
        
    }catch(PDOException $error){
        echo "Error: " . $error->getMessage();
        return false;
    }
    
}
}

// update user token 
public function updateToken($id, $token){
    try{
        $sql = "UPDATE User set token = :token WHERE id = :id";
        $statement = $this->conn->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':token', $token);
        return $statement->execute();

    }catch(PDOException $error){
        echo "Error: " . $error->getMessage();
        return false;
    }
}























}
?>