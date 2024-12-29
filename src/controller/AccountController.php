<?php 
//namespace App\Controller;
require_once '../src/controller/DatabaseController.php';
//require_once '../vendor/autoload.php';
use Twig\Loader\FilesystemLoader;
use Twig\Environment;


class AccountController {
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
    
    // Método para obetener phone ç



    public function renderAccount() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Assurez-vous que la session est démarrée
        }
    
        $username = htmlspecialchars($_SESSION['username']);
        // Renderizar la vista del dashboard

        echo $this->twig->render('account.html.twig',
         ['username' => $username],

        );

    }




}















?>