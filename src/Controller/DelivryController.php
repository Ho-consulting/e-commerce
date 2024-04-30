<?php

namespace App\Controller;

use App\Entity\Delivry;
use App\Form\DelivryType;
use App\Repository\DelivryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/delivry')]
class DelivryController extends AbstractController
{
    #[Route('/', name: 'app_delivry_index', methods: ['GET'])]
    public function index(DelivryRepository $delivryRepository): Response
    {
        return $this->render('delivry/index.html.twig', [
            'delivries' => $delivryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_delivry_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $delivry = new Delivry();
        $form = $this->createForm(DelivryType::class, $delivry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($delivry);
            $entityManager->flush();

            return $this->redirectToRoute('app_delivry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('delivry/new.html.twig', [
            'delivry' => $delivry,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_delivry_show', methods: ['GET'])]
    public function show(Delivry $delivry): Response
    {
        return $this->render('delivry/show.html.twig', [
            'delivry' => $delivry,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_delivry_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Delivry $delivry, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DelivryType::class, $delivry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_delivry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('delivry/edit.html.twig', [
            'delivry' => $delivry,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_delivry_delete', methods: ['POST'])]
    public function delete(Request $request, Delivry $delivry, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$delivry->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($delivry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_delivry_index', [], Response::HTTP_SEE_OTHER);
    }
}
