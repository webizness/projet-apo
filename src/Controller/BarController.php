<?php

namespace App\Controller;
use App\Entity\Bar;
use App\Entity\Barman;
use App\Entity\Produit;
use App\Form\BarType;
use App\Form\ProduitType;
use App\Repository\BarRepository;
use App\Repository\BarmanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\BarmanType;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BarController extends AbstractController
{
    /**
     * @Route("/bar", name="bar")
     */
    public function index(): Response
    {
        return $this->render('front/bar/index.html.twig', [
            'controller_name' => 'BarController',
        ]);
    }

    /**
     * @Route("/bar/categorie/{id}", name="bar_categorie",requirements={"id": "\d+"})
     */
    
    public function test(int $id,ProduitRepository $produitRepository,Categorierepository $categorieRepository ,Request $request): Response
    {
        $barId=$this->getUser()->getBar()->getId();
        //$produit = $produitRepository->findCategorieProduit($id);
        $categorie =$categorieRepository->findAll();
        //dd($produit);
        
        return $this->render('front/bar/test.html.twig', [
            'controller_name' => 'BarController',
            'categorie'=>$categorie,
            //'produit' =>$produit,
        ]);
           
    } 

    /**
     * @Route("/ville", name="ville")
     */
    public function cityBrowse(BarRepository $barRepository) : Response
    {
            $bar= $barRepository ->findAll();
        return $this->render('front/bar/index.html.twig', [
            'bar' => $bar,
        ]);
    }
   
    /**
     * @Route("/details/{id}", name="details", requirements={"id": "\d+"})
     */
    public function detailsSingle(int $id, BarRepository $barRepository ,CategorieRepository $categorieRepository)
    {

        $bar = $barRepository->findSingleFullBar($id);
        $categories =$categorieRepository->findAll();
      
        // Si le movie n'existe pas en BDD, on lève une erreur pour obtenir unr 404
        if ($bar === null) {
            throw $this->createNotFoundException('ça n\'existe pas');
        }

        return $this->render('front/bar/details.html.twig', [
            'bar' => $bar,
            'categories'=> $categories,
        ]);
    }


    /**
     * @Route("/details/{id}/categorie/{categorieId}", name="details_categorie", requirements={"id": "\d+"},requirements={"categorieId": "\d+"})
     */
    public function detailsCategorieBar(int $id,int $categorieId, BarRepository $barRepository ,CategorieRepository $categorieRepository,ProduitRepository $produitRepository)
    {
        
        $bar = $barRepository->findSingleFullBar($id);
        $categories =$categorieRepository->findAll();
        $produit = $produitRepository->findCategorieProduit($id,$categorieId);
        
        return $this->render('front/bar/categorie_produits.html.twig', [
            'bar' => $bar,
            'categories'=> $categories,
            'produit'=> $produit
        ]);
    }

    /*===============================================ADMIN =======================================================================*/

    /**
     * @Route("/bar/bar", name="bar_bar")
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

    /**
     * @Route("/bar/bar/edit/{id}", name="bar_bar_edit", requirements={"id": "\d+"})
     */
    public function barEdit(Bar $bar, Request $request)
    {
        $form = $this->createForm(BarType::class, $bar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();

            
            return $this->redirectToRoute('bar_bar');
        }

        return $this->render('bar/bar_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("bar/barman", name="bar_barman")
     */
    public function allBarmans(BarRepository $barRepository) : Response
    {
        $bar=$this->getUser()->getBar();
        $monBar=$bar->getId();
        $barman = $barRepository ->findBarmanBar($monBar);

           
        //dd($barman);
        return $this->render('bar/barmansdetails.html.twig', [
            'bar' => $bar,
        ]);
    }

    /**
     * @Route("/bar/barman/edit/{id}", name="bar_barman_edit", requirements={"id": "\d+"})
     */
    public function barmanEdit(Barman $barman, Request $request)
    {
        $form = $this->createForm(BarmanType::class, $barman);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();

            
            return $this->redirectToRoute('bar_barman');
        }

        return $this->render('bar/barman_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bar/barman/delete/{id}", name="bar_barman_delete", requirements={"id":"\d+"}, methods={"DELETE"})
     */
    public function barmanDelete(Barman $barman )
    {
        $em = $this->getDoctrine()->getManager();
            $em->remove($barman);
            $em->flush();


            
            $this->addFlash('Bravo','Votre Barman a bien été supprimé');

            return $this->redirectToRoute('bar_barman');
    }

    /**
     * @Route("/bar/details/{id}", name="bar_details", requirements={"id": "\d+"})
     */
    public function singleBarman(int $id, BarmanRepository $barmanRepository)
    {
        $barman = $barmanRepository->findSingleBarman($id);
        
        if ($barman === null) {
            throw $this->createNotFoundException('ça n\'existe pas');
        }

        return $this->render('bar/barmansdetails.html.twig', [
            'barman' => $barman,
        ]);
    }

    /**
     * @Route("bar/produit", name="bar_produit")
     */
    public function barProduits(BarRepository $barRepository): Response
    {
        $bar=$this->getUser()->getBar();
        $monBar=$bar->getId();
        $bar = $barRepository->findSingleFullBar($monBar);
        //dd($produit);
        return $this->render('bar/produit.html.twig', [
            'bar' => $bar,
        ]);
    }

    /**
     * @Route("/bar/produit/edit/{id}", name="bar_produit_edit", requirements={"id": "\d+"})
     */
    public function edit(Produit $produit, Request $request)
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();

            
            return $this->redirectToRoute('bar_produit');
        }

        return $this->render('bar/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bar/produit/delete/{id}", name="bar_produit_delete", requirements={"id":"\d+"}, methods={"DELETE"})
     */
    public function delete(Produit $produit )
    {
        $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();

            return $this->redirectToRoute('bar_produit');
    }

    /**
    * @Route("barman/add_snacks", name="barman_add_snacks" )
    */
    public function add(Request $request): Response
    {
        

        $produit = new Produit();

        
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        $produit->setCreatedAt(new \DateTime());
        
        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setBar($this->getUser()->getBar());
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            $this->addFlash('success', 'Votre produit a été ajouté');
            return $this->redirectToRoute('barman_add_snacks');
        }

        return $this->render('bar/add_snacks.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bar/add/barman", name="bar_add_barman")
     */
    public function addBarman(
        Request $request,
        BarmanRepository $barmanRepository, 
        UserPasswordEncoderInterface $passwordEncoder, 
        MailerInterface $mailer,
        EntityManagerInterface $entitymanager
        ): Response
    {
        $barman = new Barman();
       //utilsateur propriodubar=  $this->getUser();
        //$barman->setBar($this->getUser()->getBar());
        $form  = $this->createForm(BarmanType::class, $barman);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isvalid()){
            $barman->getPassword();
            $encodedpassword = $passwordEncoder->encodePassword($barman,$barman->getPassword());
            $barman->setPassword($encodedpassword);
            //dd($request);
            //$contactFormData = $form->getData('email');
            //dd($contactFormData);
            $barman->setCreatedAt(new \DateTime());
            $email = (new Email())
            ->from('lateamtonapero@gmail.com')
            ->to($barman->getEmail())
            ->subject('time for symfony mail')
            ->text('blablabla')
            ->html('blablabla');
            //$barman=$request->request->get(["barman"]["barman"]);
            //dd($request);
            
            $mailer->send($email);
            $entitymanager->persist($barman);
            $entitymanager->flush();
            return $this->redirectToRoute('bar_barman');
        }

        return $this->render('bar/barman.html.twig',[
            "form" => $form->createView()
        ]);
    }
}



