<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Repository\BarRepository;
use App\Form\ContactType;
use App\Form\SearchVilleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;


class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index(): Response
    {
        return $this->render('front/main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    
   /**
     * @Route("/cgv", name="cgv")
     */
    public function cgv(): Response
    {
        return $this->render('front/main/cgv.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/condition/de/livraison", name="condition_de_livraison")
     */
    public function cdl(): Response
    {
        return $this->render('front/main/condition_de_livraison.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function searchCity(Request $request, BarRepository $barRepository): Response
    {
        $bar = new Bar();
        $form = $this->createForm(SearchVilleType::class, $bar);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $ville = $form->getData()->getVille();
            $searchResult = $barRepository->findBy(['ville' => $ville]);

            return $this->render('front/ville/search.html.twig', [
                'form' => $form->createView(),
                'searchResult' => $searchResult,
                ]);
        }
        
        return $this->render('front/ville/search.html.twig', [ 
            'form' => $form->createView(),
            'searchResult' => [],
            ]);
    }
   
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            
            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('teamtonapero@gmail.com')
                //->to('moneyandsucces@gmail.com')
                ->subject('Contact front end')
                ->text('Sender : '.$contactFormData['email'].\PHP_EOL.
                    $contactFormData['message'],
                    'text/plain');
            $mailer->send($message);

            $this->addFlash('success', 'Votre message a été envoyé');

            return $this->redirectToRoute('contact');
        }

        return $this->render('front/main/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/main", name="main")
     */
    public function bar(BarRepository $barRepository): Response
    {
        $bar = $barRepository ->findAll();
        //dd($bar);
        return $this->render('front/main/index.html.twig', [
            'bar' => $bar,
        ]);
    }
}    
