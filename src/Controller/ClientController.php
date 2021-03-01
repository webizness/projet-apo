<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\UserType;
use App\Form\RegistrationFormType;
use App\Repository\CommandeRepository;
use App\Repository\LigneDeCommandeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("client/home", name="client_home")
     */
    public function cityBrowse(UserRepository $userRepository) : Response
    {
        $user= $userRepository ->findAll();
        return $this->render('front/client/index.html.twig', [
            'user' => $user,
        ]);
    }
    
    /**
     * @Route("client/home/details/{id}", name="client_home_details" ,requirements={"id": "\d+"})
     */
    public function clientDetails(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->findAll($id);
        return $this->render('front/client/details.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/client/adresse/add", name="client_adresse_add")
     */
    public function adresseClientAdd(Request $request): Response
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);
        
        $form->handleRequest($request);

       // Une fois la requête reliée, si formulaire a détecté tous ses champs,
       // il est capable de nous dire si le formulaire est envoyé et si les données reçues sont valides
       // (attention, on parlera de validation plus tard)
       // isValid() nous permet de confirmer si le token CSRF est valide !)
       if ($form->isSubmitted() && $form->isValid()) {
           // On peut persister notre objet en BDD
           $em = $this->getDoctrine()->getManager();
           $em->persist($client);
           $em->flush();

           return $this->redirectToRoute('client_home');
       }

        return $this->render('front/client/add_adresse.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/client/adresse/edit/{id}", name="client_adresse_edit", requirements={"id": "\d+"})
     */
    public function clientAdresseEdit(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_home');
        }

        return $this->render('front/client/adresse_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("client/information/edit", name="client_information_edit")
     */
    public function clientInformationEdit(Request $request,UserRepository $ur)
    {
        $user = $ur->find(9);
        $form = $this->createForm(UserType::class, $user);
        
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $this->getDoctrine()->getManager()->flush();
    
                return $this->redirectToRoute('client_home');
            }
        
        return $this->render('front/client/edit_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("client/test", name="client_test")
     */
    public function profile()
    {
        $user = $this->getUser();
        return $this->render('front/client/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("client/test", name="client_test")
     */
    public function index(): Response
    {
        return $this->render('front/client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    /**
     * Liste des commandes
     *
     * @Route("/client/commandes", name="commandes_client", methods={"GET"})
     */
    public function commandList(LigneDeCommandeRepository $ligneDeCommandeRepository)
    {
        $barId=$this->getUser()->getId();
    //dd($barId);
        $ligneDeCommandes = $ligneDeCommandeRepository->commandeClient($barId);
        //$commandes->getLigneDeCommandes()->getProduits()->getNom();
        //dd($ligneDeCommandes);
        return $this->render('commande/commandeClient.html.twig', [
            'ligneDeCommandes' => $ligneDeCommandes,
        ]); 
    }

}
