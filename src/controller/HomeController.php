<?php
namespace App\Controller;

use Twig\Environment;

class HomeController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function renderHome()
{

    // Get phones from the API
    $url = 'http://proyectophp.local/api/phones'; // actual API URL
    $json = file_get_contents($url);
    $phones = json_decode($json, true);

    echo $this->twig->render('home.html.twig', [
        'phones' => $phones
    ]);
}



    

}

   
    

