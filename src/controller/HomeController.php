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
    
    $json = file_get_contents($url); // Get the JSON from the API
    $phones = json_decode($json, true); // Decode the JSON into an array

    echo $this->twig->render('home.html.twig', [
        'phones' => $phones
    ]);
}



    

}

   
    

