<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'label'=>'E-mail'])
            ->add('agreeTerms', CheckboxType::class, [
                'label'=> 'Veuillez accepter nos termes',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter nos termes.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label'=>'Mot de passe',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} charactères',
                        // max length allowed by Symfony for security reasons
                        'max' => 16,
                    ]),
                ],
            ])
            ->add('nom', TextType::class,[
                'label' => 'Nom',
                'constraints' => new NotBlank,
            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prénom',
                'constraints' => new NotBlank,
            ])
            ->add('adresse')
            ->add('code_postal')
            ->add('ville')
            ->add('telephone', TextType::class, [
                'label'=>'Téléphone'
            ])
            ->add('date_de_naissance', BirthdayType::class, [
                'placeholder' => [
                    'day' => 'Jour', 'month' => 'Mois' , 'Year' => 'Année',
                ],
                'format'=> 'dd-MM-yyyy'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
