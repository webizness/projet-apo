<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneDeCommande;
use App\Entity\Produit;
use App\Repository\CommandeRepository;
use App\Repository\LigneDeCommandeRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(Request $request, ProduitRepository $produitRepository, EntityManagerInterface $em)
    {
        $session = $request->getSession();
               
        //dd($session);
        $commande = new Commande();
        $commande->setPrix(0);
        $commande -> setAdresseDeLivraison($this->getUser()->getAdresse());
        $commande -> setUser($this->getUser());
       
        $commande->setCreatedAt(new \DateTime());
        // dd($commande);
        // ajouter les propos d'une commande id_bar adresse_livraison
       
        $paniers = $session->get('panier');
    
        //$em = $this->getDoctrine()->getManager();
        //$produit = $em->getRepository(Produit::class)->getArray(array_keys($panier));
        //$produits=[];

        foreach ($paniers as $id => $qte) {
            $produit =  $produitRepository->find($id);
            $ldc = new LigneDeCommande();
            $ldc->setQuantite($qte);
            $ldc->setProduits($produit);
            $em->persist($ldc);
            $commande->addLigneDeCommande($ldc);
            $commande->setPrix($commande->getPrix() + ($qte * $produit->getPrix()));
        }
        //$em->persist($ldc);
        //$user=$this->getUser();
        //dd($ldc);
        
        //dd($commande);
        //$em = $this->getDoctrine()->getManager();
               
        //dd($em);
        $em->persist($commande);
        $em->flush();
        $session->remove('panier');

        $this->addFlash('success', 'Votre commande a bien été validée');
        return $this->redirectToRoute('commandes_client');


        //dd($produits);

        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
            'commande' => $commande
        ]);
    }


    /**
     * Liste des commandes
     *
     * @Route("/barman/commandes", name="commands_list", methods={"GET"})
     */
    public function commandList(LigneDeCommandeRepository $ligneDeCommandeRepository)
    {
        $barId=$this->getUser()->getBar()->getId();
    //dd($barId);
        $ligneDeCommandes = $ligneDeCommandeRepository->commandeBar($barId);
        //$commandes->getLigneDeCommandes()->getProduits()->getNom(); 
        //dd($commandes);
        return $this->render('commande/commandList.html.twig', [
            'ligneDeCommandes' => $ligneDeCommandes,
            
        ]);
    }

    
}

