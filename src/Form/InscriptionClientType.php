<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class InscriptionClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('nom', TextType::class,[
                'label' => 'Nom',
                'constraints' => new NotBlank,
            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prénom',
                'constraints' => new NotBlank,
            ])
            ->add('email', EmailType::class,[
                'label'=>'E-mail',
                'constraints' => [
                    new NotBlank,
                    new Email(),
                ]
            ])
            ->add('numero')
            ->add('adresse')
            ->add('code_postal')
            ->add('ville')
            ->add('telephone', TextType::class, [
                'label'=>'Téléphone'
            ])
            ->add('date_de_naissance')
            ->add('password',PasswordType::class, [
                'label'=>'Mot de passe'
            ])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
