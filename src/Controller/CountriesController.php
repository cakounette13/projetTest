<?php

namespace App\Controller;

use App\Entity\Countries;
use App\Form\CountriesType;
use App\Repository\CountriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\ExpressionLanguage\Expression;


#[Route('/countries')]
final class CountriesController extends AbstractController
{
    
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN")'))]
    #[Route(name: 'countries_index', methods: ['GET'])]
    public function index(CountriesRepository $countriesRepository): Response
    {
        return $this->render('countries/index.html.twig', [
            'countries' => $countriesRepository->findAll(),
        ]);
    }

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/new', name: 'countries_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $country = new Countries();
        $form = $this->createForm(CountriesType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($country);
            $entityManager->flush();

            return $this->redirectToRoute('countries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('countries/new.html.twig', [
            'country' => $country,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'countries_show', methods: ['GET'])]
    public function show(Countries $country): Response
    {
        return $this->render('countries/show.html.twig', [
            'country' => $country,
        ]);
    }

    #[Route('/{id}/edit', name: 'countries_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Countries $country, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CountriesType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('countries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('countries/edit.html.twig', [
            'country' => $country,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'countries_delete', methods: ['POST'])]
    public function delete(Request $request, Countries $country, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$country->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($country);
            $entityManager->flush();
        }

        return $this->redirectToRoute('countries_index', [], Response::HTTP_SEE_OTHER);
    }
}
