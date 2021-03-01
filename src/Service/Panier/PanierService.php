<?php

namespace App\Service\Panier;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProduitRepository;

class PanierService {

  protected $session;
  protected $produitRepository;

  public function __construct(SessionInterface $session, ProduitRepository $produitRepository)
  {

    $this->session = $session;
    $this->produitRepository = $produitRepository;

  }

  public function add(int $id) {
    $panier = $this->session->get('panier',[]);
        
        if(!empty($panier[$id])){
            $panier[$id]++;
        } else{
            $panier[$id] = 1;
        }
        
        $this->session->set('panier',$panier);

  }

  public function delete(int $id) 
  {

    $panier = $this->session->get('panier',[]);
        
    if(!empty($panier[$id])){
        unset($panier[$id]);
        } 

        $this->session->set('panier', $panier);

  }

  public function getFullPanier() : array 
  {

    $panier = $this->session->get('panier',[]);

        $panierWithData = [];

        foreach($panier as $id => $quantite){
            $panierWithData[] = [
                'produit'=>$this->produitRepository->find($id),
                'quantite'=> $quantite
            ];
        }
            return $panierWithData;
  }

  //public function getTotal() : float {}

}