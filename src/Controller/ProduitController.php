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

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findBy(['availible' => true]),
        ]);
    }


    // cette action pour l'utilisation des admins
    #[Route('/epuise', name: 'app_produit_epuise', methods: ['GET'])]
    public function index_epuise(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findBy(['availible' => false]),
        ]);
    }


    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $produit->setAvailible(true);
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET', 'POST'])]
    public function show(Produit $produit, Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(ArticlesPanierType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            
            $exist = false;
            if ($this->getUser() and $this->getUser()->getPanier() == null) {
                $panier = new Panier();
            } else {
                $panier = $this->getUser()->getPanier();
                foreach ($panier->getArticlesPanier() as &$article) {
                    if ($article->getProduit() == $produit) {
                        $exist = true;
                        $article->setQuantity($article->getQuantity() + $request->request->all()['articles_panier']['quantity']);
                        break;
                    }
                }
            }

            if ($exist == false) {
                $articlesPanier = new ArticlesPanier();
                $articlesPanier->setProduit($produit);
                $articlesPanier->setQuantity($request->request->all()['articles_panier']['quantity']);
                $entityManager->persist($articlesPanier);
                $panier->addArticlesPanier($articlesPanier);
            }
            
            $panier->setUser($this->getUser());
            $panier->setPrixTotal($panier->getTotalPanier());
            $panier->setDelivry($panier->getDelivryMax());
            $entityManager->persist($panier); 
            $entityManager->flush();

        }

        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
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


    #[Route('/{id}/availible', name: 'app_produit_not_availible')]
    public function notavailible(Produit $produit, EntityManagerInterface $entityManager): Response
    {

        $produit->setAvailible(false);
        $entityManager->flush();

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER); 
    }


    /*
    #[Route('/produit/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
          
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }
    */
    
}

