<?php

namespace App\Controller;

use App\Entity\ArticlesPanier;
use App\Form\ArticlesPanierType;
use App\Repository\ArticlesPanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/articles/panier')]
class ArticlesPanierController extends AbstractController
{
    #[Route('/', name: 'app_articles_panier_index', methods: ['GET'])]
    public function index(ArticlesPanierRepository $articlesPanierRepository): Response
    {
        return $this->render('articles_panier/index.html.twig', [
            'articles_paniers' => $articlesPanierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_articles_panier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $articlesPanier = new ArticlesPanier();
        $form = $this->createForm(ArticlesPanierType::class, $articlesPanier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($articlesPanier);
            $entityManager->flush();

            return $this->redirectToRoute('app_articles_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('articles_panier/new.html.twig', [
            'articles_panier' => $articlesPanier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_articles_panier_show', methods: ['GET'])]
    public function show(ArticlesPanier $articlesPanier): Response
    {
        return $this->render('articles_panier/show.html.twig', [
            'articles_panier' => $articlesPanier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_articles_panier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ArticlesPanier $articlesPanier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticlesPanierType::class, $articlesPanier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_articles_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('articles_panier/edit.html.twig', [
            'articles_panier' => $articlesPanier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_articles_panier_delete', methods: ['POST'])]
    public function delete(Request $request, ArticlesPanier $articlesPanier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articlesPanier->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($articlesPanier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_articles_panier_index', [], Response::HTTP_SEE_OTHER);
    }
}
