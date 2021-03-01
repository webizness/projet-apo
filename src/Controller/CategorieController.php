<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        return $this->render('front/categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @Route("/categorie/cocktails/", name="categorie_cocktails",  )
     */
    public function cocktails(ProduitRepository $produitRepository): Response
    {
        $produit = $produitRepository->findAll();
        return $this->render('front/categorie/index.html.twig', [
            'produit' => $produit,
        ]);
    }

     /**
     * @Route("/categorie/cocktails/{id}", name="categorie_cocktails_details", requirements={"id": "\d+"})
     */
    public function movieRead(int $id, ProduitRepository $produitRepository)
    {
        $produit = $produitRepository->findSingleFullProduit($id);

        // Si le produit n'existe pas en BDD, on lève une erreur pour obtenir une 404
        if ($produit === null) {
            throw $this->createNotFoundException('ça n\'existe pas');
        }

        return $this->render('front/categorie/cocktails.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/categorie/softs", name="categorie_softs")
     */
    public function softs(): Response
    {
        return $this->render('front/categorie/softs.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @Route("/categorie/snacks", name="categorie_snacks")
     */
    public function snacks(): Response
    {
        return $this->render('front/categorie/snacks.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }




}
