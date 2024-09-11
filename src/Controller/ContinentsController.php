<?php
namespace App\Controller;

use App\Entity\Continents;
use App\Form\ContinentType;
use App\Repository\ContinentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/continent')]
final class ContinentsController extends AbstractController
{
    #[Route(name: 'continent_index', methods: ['GET'])]
    public function indexContinent(ContinentsRepository $continentsRepository): Response
    {
        return $this->render('continent/index.html.twig', [
            'continents' => $continentsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'add_continent')]
    public function addContinent(Request $request, EntityManagerInterface $entityManager): Response
    {
        $continents = new Continents();
        $form = $this->createForm(ContinentType::class, $continents);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($continents);
            $entityManager->flush();

            return $this->redirectToRoute('continent_index');
        }

        return $this->render('continent/new.html.twig', [
            'myForm' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'continent_edit')]
    public function edit(Request $request, Continents $continents, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContinentType::class, $continents);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('continent_index');
        }

        return $this->render('continent/edit.html.twig', [
            'myForm' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'continent_delete')]
    public function delete(Request $request, Continents $continents, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($continents);
        $entityManager->flush();    

        return $this->redirectToRoute('continent_index');
    }
}