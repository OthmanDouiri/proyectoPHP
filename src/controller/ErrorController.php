<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ErrorController
{
    private $twig;

    public function __construct()
    {
        // Configuración de Twig
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);
    }

    public function render404()
    {
       
        // Renderiza la plantilla home.html.twig con los datos de los teléfonos
        echo $this->twig->render('404.html.twig');
    }

   
    
}
