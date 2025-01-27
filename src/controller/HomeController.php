<?php

namespace App\Controller;

use App\Controller\DashboardController; // Asegúrate de importar DashboardController
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController
{
    private $twig;

    public function __construct()
    {
        // Configuración de Twig
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);
    }

    public function renderHome()
    {
        // Crear una instancia de DashboardController para acceder a getPhone
        $dashboardController = new DashboardController();

        // Llamar a getPhone y obtener los teléfonos
        $phones = $dashboardController->getPhone();  // Si necesitas usar searchQuery, pásalo aquí

        // Renderiza la plantilla home.html.twig con los datos de los teléfonos
        echo $this->twig->render('home.html.twig', [
            // 'title' => 'Bienvenido a la página principal',
            // 'message' => 'Este es un ejemplo con Twig y PHP.',
            'phones' => $phones // Pasamos los teléfonos al template
        ]);
    }

   
    
}
