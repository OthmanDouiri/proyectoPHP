<?php
namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController
{
    private $twig;

    public function __construct()
    {
        // Configuración de Twig
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
    }

    public function renderHome()
    {
        // Renderiza la plantilla home.html.twig con datos
        echo $this->twig->render('home.html.twig', [
            'title' => 'Bienvenido a la página principal',
            'message' => 'Este es un ejemplo con Twig y PHP.'
        ]);
    }
}
