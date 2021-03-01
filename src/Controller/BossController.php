<?php

namespace App\Controller;

use App\Entity\Barman;
use App\Repository\BarmanRepository;
use App\Form\BarmanType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mime\Email;




class BossController extends AbstractController
{
    /**
     * @Route("/boss", name="boss")
     */
    public function index(): Response
    {
        return $this->render('boss/index.html.twig', [
            'controller_name' => 'BossController',
        ]);
    }

    /**
     * @Route("/barman/add_barman", name="add_barman")
     */
        public function addBarman(
        Request $request,
        BarmanRepository $barmanRepository, 
        UserpasswordEncoderInterface $passwordEncoder, 
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
            //$image = $form->get('image')->getData();
            //$imageName = uniqid().'.'.$image->guessExtension();

            $barman->getPassword();
            $encodedpassword = $passwordEncoder->encodePassword($barman,$barman->getPassword());
            $barman->setPassword($encodedpassword);
           
            //dd($request);
            //$contactFormData = $form->getData('email');
            //dd($contactFormData);
            $barman->setBar($this->getUser()->getBar());
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
            return $this->redirectToRoute('barman_home');

        }
        return $this->render('barman/add_barman.html.twig',[
            "form" => $form->createView()
        ]);

    }
}
