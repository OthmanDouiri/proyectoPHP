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
        $dashboardController = new DashboardController();
        $phones = $dashboardController->getPhone();

        echo $this->twig->render('home.html.twig', [
            'phones' => $phones
        ]);
    }
}

   
    

