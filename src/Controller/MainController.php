<?php

namespace App\Controller;

use App\Entity\Continents;
use App\Repository\ContinentsRepository;
use App\Repository\CountriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(CountriesRepository $countries, ContinentsRepository $continents): Response
    {
        return $this->render('main/home.html.twig', [
            'countries' => $countries->findAll(),
            'continents' => $continents->findAll(),
        ]);
    }

    #[Route(path: "/tab/{id}", name: "tab", methods: ["GET"])]
    public function tab(Continents $continents, CountriesRepository $repoCountries, ContinentsRepository $repoContinents ): Response
    {
        $continent = $repoContinents->findAll();
        return $this->render('tab.html.twig', [
            'cont' => $continent,
            'countries' => $repoCountries->findAll(),
            'continents' => $continents,
        ]);
    }
}