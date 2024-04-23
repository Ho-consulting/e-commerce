<?php

namespace App\Controller;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\ArticlesPanier;
use App\Form\ArticlesPanierType;


class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/produit/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/produit/{id}', name: 'app_produit_show', methods: ['GET', 'POST'])]
    public function show(Produit $produit, Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(ArticlesPanierType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articlesPanier = new ArticlesPanier();
            $articlesPanier->setProduit($produit);
            $articlesPanier->setQuantity($request->request->all()['articles_panier']['quantity']);

            // restes : 
            // tester si un panier existe déja pour un utilisateur (si oui on ajoute juste le produit au panier si non on crée un nouveau panier)

            $panier = new Panier();
            $panier->addArticlesPanier($articlesPanier);

            $entityManager->persist($panier);
            $entityManager->persist($articlesPanier);
            $entityManager->flush();

           // return $this->redirectToRoute('app_articles_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/produit/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/produit/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
