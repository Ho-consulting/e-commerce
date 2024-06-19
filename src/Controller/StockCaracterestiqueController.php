<?php

namespace App\Controller;

use App\Entity\StockCaracterestique;
use App\Form\StockCaracterestiqueType;
use App\Repository\StockCaracterestiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/stock/caracterestique')]
class StockCaracterestiqueController extends AbstractController
{
    #[Route('/', name: 'app_stock_caracterestique_index', methods: ['GET'])]
    public function index(StockCaracterestiqueRepository $stockCaracterestiqueRepository): Response
    {
        return $this->render('stock_caracterestique/index.html.twig', [
            'stock_caracterestiques' => $stockCaracterestiqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stock_caracterestique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stockCaracterestique = new StockCaracterestique();
        $form = $this->createForm(StockCaracterestiqueType::class, $stockCaracterestique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stockCaracterestique);
            $entityManager->flush();

            return $this->redirectToRoute('app_stock_caracterestique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stock_caracterestique/new.html.twig', [
            'stock_caracterestique' => $stockCaracterestique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_caracterestique_show', methods: ['GET'])]
    public function show(StockCaracterestique $stockCaracterestique): Response
    {
        return $this->render('stock_caracterestique/show.html.twig', [
            'stock_caracterestique' => $stockCaracterestique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stock_caracterestique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StockCaracterestique $stockCaracterestique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StockCaracterestiqueType::class, $stockCaracterestique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stock_caracterestique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stock_caracterestique/edit.html.twig', [
            'stock_caracterestique' => $stockCaracterestique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_caracterestique_delete', methods: ['POST'])]
    public function delete(Request $request, StockCaracterestique $stockCaracterestique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stockCaracterestique->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($stockCaracterestique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stock_caracterestique_index', [], Response::HTTP_SEE_OTHER);
    }
}
