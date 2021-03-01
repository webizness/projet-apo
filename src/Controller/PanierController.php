<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Service\Panier\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $panier = $session->get('panier',[]);

        $panierWithData = [];

        foreach($panier as $id => $quantite){
            $panierWithData[] = [
                'produit'=>$produitRepository->find($id),
                'quantite'=> $quantite
            ];
        }

        $total = 0;

        foreach($panierWithData as $item){
            $totalItem = $item['produit']->getprix()* $item['quantite'];
            $total += $totalItem;
        }
        //dd($panierWithData);
        //dd($panier);
        return $this->render('front/panier/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total,
        ]);
    }
    
    /**
     * @Route("/panier/add{id}", name="panier_add")
     */
    public function add($id, PanierService $panierService)
    {
        $panierService->add($id);

        return $this->redirectToRoute('panier');
    }

    /**
     * @Route("/panier/delete/{id}", name="panier_delete")
     */
    public function delete($id, PanierService $panierService)
    {
        $panierService->delete($id);

        return $this->redirectToRoute('panier');
    }
}