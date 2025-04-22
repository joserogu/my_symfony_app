<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_inicio')]
    public function index(): Response
    {
        return $this->render('/home/index.html.twig');
    }
    #[Route('/home/saludo', name: 'home_saludo')]
    public function saludo(): Response
    {
        die("hola soy tu saludo");
    }

    #[Route('/home/despedida', name: 'home_despedida')]
    public function despedida_algo(): Response
    {
        die("hola soy tu despedida");
    }
}
