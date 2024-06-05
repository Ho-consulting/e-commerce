<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\Panier;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/commande')]
class CommandeController extends AbstractController
{

    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }


    #[Route('/addres-validation', name: 'app_commande_adress', methods: ['GET'])]
    public function show_addres(): Response
    {
        return $this->render('commande/validate_addres.html.twig', [
            'adress' => $this->getUser()->getAdresse(),
        ]);
    }


    #[Route('/payment', name: 'app_commande_payment', methods: ['GET', 'POST'])]
    public function commande_paiement() : Response
    {
        return $this->render('commande/payment.html.twig', [
            'panier' => $this->getUser()->getPanier(),
        ]);
    }


    #[Route('/{id}/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
    public function new(Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commande();

            foreach ($panier->getArticlesPanier() as &$articlePanier) {
                $commande->addArticle($articlePanier);
                $articlePanier->getProduit()->setStockQuantite($articlePanier->getProduit()->getStockQuantite() - $articlePanier->getQuantity());
                if ($articlePanier->getProduit()->getStockQuantite() == 0) {
                    $articlePanier->getProduit()->setAvailible(false);
                }
                $panier->removeArticlesPanier($articlePanier);
            }

            $commande->setUser($panier->getUser());
            $address = new Adresse();
            $address = $panier->getUser()->getAdresse();
            $commande->setAdresse($address);
            $panier->setUser(null);
            $entityManager->persist($commande);
            $entityManager->remove($panier);
            $entityManager->flush();

            $this->addFlash('success', 'Votre commande a bien été prise en compte');
            
            return $this->redirectToRoute('app_commande_show', ['id' => $commande->getId()], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}', name: 'app_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->getPayload()->get('_token'))) {

            foreach ($commande->getArticles() as &$articlePanier) {
                $commande->removeArticle($articlePanier);
            }
            $commande->setUser(null);
            $commande->setAdresse(null);
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }

}