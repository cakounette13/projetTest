<?php

namespace App\Controller;

use App\Repository\CountriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(CountriesRepository $countries): Response
    {
        return $this->render('main/home.html.twig', [
            'countries' => $countries->findAll(),
        ]);
    }
}
