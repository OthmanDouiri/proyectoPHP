<?php
namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Controller\DatabaseController;




class ClientController
{
    private $twig;
    private $conn;

    // Constructor: Recibe el objeto Twig para renderizar las vistas y establece la conexión a la base de datos
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->conn = DatabaseController::connect();

        // Configurar Twig
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);    
    }



    


    // Método para mostrar la vista del checkout
    public function renderCheckout()
    {
        echo $this->twig->render('checkout.html.twig');
    }

    

  
}
