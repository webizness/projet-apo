<?php
namespace App\Controller;


use App\Entity\Barman;
use App\Entity\Produit;
use App\Repository\BarRepository;
use App\Repository\BarmanRepository;
use App\Repository\ProduitRepository;
use App\Form\BarmanType;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BarmanController extends AbstractController
{
    /**
     * @Route("barman/home_barman", name="barman_home")
     */
    public function index(): Response
    {
        $client=$this->getUser('id');
        $entityManager = $this->getDoctrine()->getManager();
        $barman = $entityManager ->getRepository(Barman::class)->find($client);

        return $this->render('barman/home_barman.html.twig', array(
            'barman' => $barman
        ));
      
    }

    /**
     * @Route("/barman/home_barman/edit/{id}", name="barman_home_barman_edit", requirements={"id": "\d+"})
     */
    public function barmanEdit(Barman $barman, Request $request)
    {
        $form = $this->createForm(BarmanType::class, $barman);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Le formulaire est valide, on change la valeur du $updatedAt de $person
            //$campagne->setUpdatedAt(new \DateTime());

            // On peut flusher les modifications
            // Inutile de persister car l'entity manager connait déjà cet objet
            // Inutile de récupérer le manager dans $em juste pour écrire $em->flush() ensuite
            // On peut donc tout faire en une seule ligne
            $this->getDoctrine()->getManager()->flush();

            // On peut rediriger l'utilisateur vers la liste des personnes
            return $this->redirectToRoute('barman_home');
        }

        return $this->render('barman/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("barman/produit/cocktails/search", name="barman_produit_cocktails_search" , methods="GET|POST")
     */
    public function api(Request $request,EntityManagerInterface $em): Response
    {
        $produit = new Produit();

        $cocktail = null;
        $nom = $request->query->get('nom');
    
        if($nom){
            $clientHttp = HttpClient::create();
            $url = sprintf('https://www.thecocktaildb.com/api/json/v1/1/search.php?s=%s',$nom);
            //dd($nom);
             //dd($url);

            $reponse = $clientHttp->request(Request::METHOD_GET,$url);
            $drinks = json_decode($reponse->getContent());
            $cocktail = $drinks->drinks;
            $ingredients = "";
            $cocktail = $cocktail[0];
            for($i =1; $i <=15; $i++){
                $key = 'strIngredient'.$i;
                $ingredients .= " ". $cocktail->$key; 
            } 
            $produit->setCreatedAt(new \DateTime());
            $produit->setNom($cocktail->strDrink);
            $produit->setImage($cocktail->strDrinkThumb);
            $produit->setIngredient($ingredients);
            
            // $this->redirectToRoute('')
        }
        // ici faire un mapping cocktail avec produit
    
        $form = $this->createForm(ProduitType::class, $produit);
        //$bar = new Bar();
        if($request->getMethod() === Request::METHOD_POST) {
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $produit->setBar($this->getUser()->getBar());
                
                $em->persist($produit);
                $em->flush();
                
                return $this->redirectToRoute('barman_produit_cocktails_search');
            }
        }

        return $this->render('barman/search.html.twig', [
            'controller_name' => 'BarController',
            'form' => $form->createView(),
            'cocktail' => $cocktail,
        ]);
    }

    
     /**
     * @Route("barman/bar", name="barman_bar")
     */
    public function recupererleBar(BarRepository $barRepository): Response
    {
        $bar=$this->getUser()->getBar();
        $monBar=$bar->getId();
        $barId = $barRepository ->find($monBar);

        //dd($barId);
        return $this->render('bar/bar.html.twig', [
            'barId'=> $barId
        ]);
    }   
}
    